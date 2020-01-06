<?php

namespace App\Services;

use App\Repositories\CharacterRepository;
use App\Pipes\Query;
use Arr;

class CharacterService
{
    protected $repo;

    public function __construct(CharacterRepository $repo)
    {
        $this->repo = $repo;
    }

    public function fetch($page = 1, $limit = 25, $filters = [])
    {
        $query = $this->repo->query()->pushPipe(new Query\Paginate($page, $limit));

        if ($character = Arr::get($filters, 'search', false)) {
            $query->pushPipe(new Query\Character\NameLike($character));
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