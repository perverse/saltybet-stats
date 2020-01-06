<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class First extends QueryPipe
{
    public function handle($builder, Closure $next)
    {
        $builder = $next($builder);

        return $builder->first();
    }
}