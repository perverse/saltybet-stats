<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class HasCharacters extends QueryPipe
{
    protected $character_a;
    protected $character_b;

    public function __construct(string $character_a, string $character_b)
    {
        $this->character_a = $character_a;
        $this->character_b = $character_b;
    }

    public function handle($builder, Closure $next)
    {
        $builder->where(function($query){
            $query->where('characters_index', '=', $this->character_a . '^' . $this->character_b);
            $query->orWhere('characters_index', '=', $this->character_b . '^' . $this->character_a);
        });
        return $next($builder);
    }
}