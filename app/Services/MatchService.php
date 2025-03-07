<?php

namespace App\Services;

use App\Repositories\MatchRepository;
use App\Repositories\CharacterRepository;
use App\Pipes\Query;
use Carbon\Carbon;
use Arr;

class MatchService
{
    protected $repo;
    protected $character_repo;

    public function __construct(MatchRepository $repo, CharacterRepository $character_repo)
    {
        $this->repo = $repo;
        $this->character_repo = $character_repo;
    }

    /*
        0 { data: "c1", title: "Character 1" },
        1 { data: "c2", title: "Character 2" },
        2 { data: "w", title: "Winner" },
        3 { data: "sn", title: "Strategy" },
        4 { data: "pw", title: "Prediction" },
        5 { data: "t", title: "Tier" },
        6 { data: "m", title: "Mode" },
        7 { data: "o", title: "Odds" },
        8 { data: "ts", title: "Time" },
        9 { data: "cf", title: "Crowd favor" },
        10 { data: "if", title: "Illum favor" },
        11 { data: "dt", title: "Date" },
    */

    protected function findCharacterByNameOrCreate($name)
    {
        $character = $this->character_repo->query()
                                          ->pushPipe(new Query\Character\NameIs($name))
                                          ->pushPipe(new Query\First)
                                          ->execute();

        if (!$character) {
            $character = $this->character_repo->create([
                'name' => $name
            ]);
        }

        return $character;
    }

    public function importMatchCsvRow(array $matchData)
    {
        $hash = md5(implode(',', $matchData));
        $match = $this->repo->query()
                            ->pushPipe(new Query\Match\HashIs($hash))
                            ->pushPipe(new Query\First())
                            ->execute();

        if (!$match) {
            $characters = [
                0 => $this->findCharacterByNameOrCreate($matchData[0]),
                1 => $this->findCharacterByNameOrCreate($matchData[1])
            ];
    
            $winner = $characters[intval($matchData[2])];
            $loser = $characters[intval($matchData[2] == 0 ? 1 : 0)];
            $crowd_fav = (intval($matchData[9]) <= 1) ? $characters[intval($matchData[9])] : null;
            $illum_fav = (intval($matchData[10]) <= 1) ? $characters[intval($matchData[10])] : null;

            $winner->wins++;
            $loser->losses++;

            $this->character_repo->persist($winner);
            $this->character_repo->persist($loser);

            $date = Carbon::createFromFormat("d-m-Y", $matchData[11]);

            $match = $this->repo->create([
                'character_a_id' => $characters[0]->id,
                'character_b_id' => $characters[1]->id,
                'character_winner_id' => $winner->id,
                'character_crowd_favour_id' => $crowd_fav ? $crowd_fav->id : 0,
                'character_illum_favour_id' => $illum_fav ? $illum_fav->id : 0,
                'character_a_bet_return' => 0,
                'character_b_bet_return' => 0,
                'strategy' => $matchData[3],
                'prediction' => $matchData[4],
                'tier' => $matchData[5],
                'mode' => $matchData[6],
                'odds' => $matchData[7],
                'time' => $matchData[8],
                'date' => $date->format('Y-m-d H:i:s'),
                'hash' => $hash,
                'characters_index' => $characters[0]->name . '^' . $characters[1]->name
            ]);
        }

        $this->repo->persist($match);

        return $match;
    }

    public function fetch($page = 1, $limit = 25, $filters = [], $sortBy = 'date', $sortDirection='DESC')
    {
        $query = $this->repo->query()
                            ->pushPipe(new Query\Match\WithCharacters)
                            ->pushPipe(new Query\Paginate($page, $limit))
                            //->pushPipe(new Query\RawSql())
                            ->pushPipe(new Query\OrderBy($sortBy, $sortDirection));

        if ($character = Arr::get($filters, 'search', false)) {
            $characters = explode(':', $character);

            if (count($characters) > 1) {
                $query->pushPipe(new Query\Match\HasCharacters($characters[0], $characters[1]));
            } else {
                $query->pushPipe(new Query\Match\HasCharacter($characters[0]));
            }
        }

        return $query->execute();
    }

    public function find($id)
    {
        $query = $this->repo->query()
                            ->pushPipe(new Query\IdIs($id));
        
        return $query->pushPipe(new Query\First)
                     ->execute();
    }
}