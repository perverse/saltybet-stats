<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class Paginate extends QueryPipe
{
    public function __construct($page, $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function handle($builder, Closure $next)
    {
        $builder = $next($builder);

        return $builder->paginate($this->perPage, ['*'], 'page', $this->page);
    }
}