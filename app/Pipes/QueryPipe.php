<?php

namespace App\Pipes;

use Closure;

abstract class QueryPipe
{
    abstract public function handle($builder, Closure $next);
}   