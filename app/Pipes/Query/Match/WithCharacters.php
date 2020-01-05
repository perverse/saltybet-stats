<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class WithCharacters extends QueryPipe
{
    public function handle($builder, Closure $next)
    {
        return $next($builder->with('character_a', 'character_b', 'winner', 'crowd_favourite', 'illum_favourite'));
    }
}