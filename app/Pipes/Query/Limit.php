<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class Limit extends QueryPipe
{
    protected $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->take($this->limit));
    }
}