<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class RawSql extends QueryPipe
{
    public function handle($builder, Closure $next)
    {
        $builder = $next($builder);
        $builder->take(5)->skip(0);

        return $builder->toSql();
    }
}