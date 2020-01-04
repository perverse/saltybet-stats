<?php

namespace App\Services;

use App\Repositories\MatchRepository;
use App\Repositories\CharacterRepository;
use App\Pipes\Query;
use Carbon\Carbon;

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
        $hash = implode(',', $matchData);
        $match = $this->repo->query()
                            ->pushPipe(new Query\Match\HashIs($hash))
                            ->pushPipe(new Query\First)
                            ->execute();

        echo(get_class($match));
        die();

        if (!$match) {
            $characters = [
                0 => $this->findCharacterByNameOrCreate($matchData[0]),
                1 => $this->findCharacterByNameOrCreate($matchData[1])
            ];
    
            $winner = &$characters[intval($matchData[2])];
            $loser = &$characters[intval($matchData[2] == 0 ? 0 : 1)];
            $crowd_fav = &$characters[intval($matchData[9])];
            $illum_fav = &$characters[intval($matchData[10])];

            $winner->wins++;
            $loser->losses++;

            $this->character_repo->persist($winner);
            $this->character_repo->persist($loser);

            $date = Carbon::createFromFormat("d-m-Y", $matchData[11]);

            $match = $this->repo->create([
                'character_a_id' => $characters[0]->id,
                'character_b_id' => $characters[1]->id,
                'character_winner_id' => $winner->id,
                'character_crowd_favour_id' => $crowd_fav->id,
                'character_illum_favour_id' => $illum_fav->id,
                'character_a_bet_return' => 0,
                'character_b_bet_return' => 0,
                'strategy' => $matchData[3],
                'prediction' => $matchData[4],
                'tier' => $matchData[5],
                'mode' => $matchData[6],
                'odds' => $matchData[7],
                'time' => $matchData[8],
                'date' => $date->format('Y-m-d H:i:s'),
                'hash' => $hash
            ]);
        }

        return $match;
    }
}