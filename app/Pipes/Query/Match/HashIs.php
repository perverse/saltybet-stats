<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class HashIs extends QueryPipe
{
    protected $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->where('hash', '=', $this->hash));
    }
}