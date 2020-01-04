<?php

namespace App\Pipes\Query;

use Closure;

class Query
{
    public function handle($model, Closure $next)
    {
        return $next($model->query());
    }
}