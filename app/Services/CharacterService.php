<?php

namespace App\Services;

use App\Repositories\CharacterRepository;
use App\Pipes\Query;

class CharacterService
{
    protected $repo;

    public function __construct(CharacterRepository $repo)
    {
        $this->repo = $repo;
    }

    public function fetch($page = 1, $limit = 25, $filters = [])
    {
        $query = $this->repo->query()
                            ->pushPipe(new Query\Offset(($page - 1) * $limit))
                            ->pushPipe(new Query\Limit($limit));

        return $query->pushPipe(new Query\Fetch)
                     ->execute();
    }

    public function find($id)
    {
        $query = $this->repo->query()
                            ->pushPipe(new Query\IdIs($id));
        
        return $query->pushPipe(new Query\First)
                     ->execute();
    }
}