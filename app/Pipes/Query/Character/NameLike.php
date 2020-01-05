<?php

namespace App\Pipes\Query\Character;

use App\Pipes\QueryPipe;
use Closure;

class NameLike extends QueryPipe
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->where('name', 'LIKE', '%' . $this->name . '%'));
    }
}