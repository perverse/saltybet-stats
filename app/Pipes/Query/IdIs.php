<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class IdIs extends QueryPipe
{
    protected $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->where('id', '=', $this->id));
    }
}