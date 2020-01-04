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

    public function getCharacters($filters = [], $page = 1, $limit = 25)
    {
        return $this->repo->query()
                          ->pushPipe(new Query\Offset(($page - 1) * $limit))
                          ->pushPipe(new Query\Limit($limit))
                          ->pushPipe(new Query\Fetch)
                          ->execute();
    }
}