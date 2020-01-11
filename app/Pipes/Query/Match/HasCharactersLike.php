<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class HasCharactersLike extends QueryPipe
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
    /*
        $builder->where(function($query){
            $query->where(function($query){
                $query->whereHas('character_a', function($query){
                    $query->where('name', 'LIKE', '%' . $this->character_a . '%');
                });

                $query->orWhereHas('character_a', function($query){
                    $query->where('name', 'LIKE', '%' . $this->character_b . '%');
                });
            });
            $query->where(function($query){
                $query->whereHas('character_b', function($query){
                    $query->where('name', 'LIKE', '%' . $this->character_a . '%');
                });

                $query->orWhereHas('character_b', function($query){
                    $query->where('name', 'LIKE', '%' . $this->character_b . '%');
                });
            });
        });
    */
        $builder->where(function($query){
            $query->where('characters_index', 'LIKE', '%' . $this->character_a . '^' . $this->character_b . '%');
            $query->orWhere('characters_index', 'LIKE', '%' . $this->character_b . '%^%' . $this->character_a . '%');
        });
        return $next($builder);
    }
}