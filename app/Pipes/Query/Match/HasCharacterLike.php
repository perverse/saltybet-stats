<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class HasCharacterLike extends QueryPipe
{
    protected $character;

    public function __construct(string $character)
    {
        $this->character = $character;
    }

    public function handle($builder, Closure $next)
    {
        $builder->where(function($query){
            $query->whereHas('character_a', function($query){
                $query->where('name', 'LIKE', '%' . $this->character . '%');
            });

            $query->orWhereHas('character_b', function($query){
                $query->where('name', 'LIKE', '%' . $this->character . '%');
            });
        });

        return $next($builder);
    }
}