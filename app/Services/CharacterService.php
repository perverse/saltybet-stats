<?php

namespace App\Services;

use App\Repositories\CharacterRepository;
use App\Services\MatchService;
use App\Pipes\Query;
use Arr;

class CharacterService
{
    protected $repo;
    protected $match_service;

    public function __construct(CharacterRepository $repo, MatchService $match_service)
    {
        $this->repo = $repo;
        $this->match_service = $match_service;
    }

    public function fetch($page = 1, $limit = 25, $filters = [], $sortBy = 'name', $sortDirection='DESC')
    {
        $query = $this->repo->query()->pushPipe(new Query\Paginate($page, $limit))->pushPipe(new Query\OrderBy($sortBy, $sortDirection));

        if ($character = Arr::get($filters, 'search', false)) {
            $query->pushPipe(new Query\Character\NameLike($character));
        }

        return $query->execute();
    }

    public function find($id)
    {
        $query = $this->repo->query()
                            ->pushPipe(new Query\IdIs($id));
        
        $character = $query->pushPipe(new Query\First)
                           ->execute();
        
        $matches = $this->match_service->fetch(1, 15, ['search' => $character->name]);
        $character->setRelation('matches', $matches);

        return $character;
    }
}