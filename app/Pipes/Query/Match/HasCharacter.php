<?php

namespace App\Pipes\Query\Match;

use App\Pipes\QueryPipe;
use Closure;

class HasCharacter extends QueryPipe
{
    protected $character;

    public function __construct(string $character)
    {
        $this->character = $character;
    }

    public function handle($builder, Closure $next)
    {
        /*
        $builder->where(function($query){
            $query->whereHas('character_a', function($query){
                $query->where('name', '=', $this->character);
            });

            $query->orWhereHas('character_b', function($query){
                $query->where('name', '=', $this->character);
            });
        });
        */
        /*
        $builder->join('characters as ca', 'ca.id', '=', 'matches.character_a_id')
                ->join('characters as cb', 'cb.id', '=', 'matches.character_b_id')
                ->where(function($query){
                    $query->where('ca.name', '=', $this->character)
                          ->orWhere('cb.name', '=', $this->character);
                });
        */
        $builder->select(\DB::raw('matches.*'))
                ->from(\DB::raw('matches, characters'))
                ->where(function($query){
                    $query->where('matches.character_a_id', '=', \DB::raw('characters.id'))
                          ->orWhere('matches.character_b_id', '=', \DB::raw('characters.id'));
                })
                ->where('characters.name', '=', $this->character);

        return $next($builder);
    }
}