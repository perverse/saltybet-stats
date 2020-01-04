<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class Paginate extends QueryPipe
{
    public function handle($builder, Closure $next)
    {
        return $next($builder->get());
    }
}