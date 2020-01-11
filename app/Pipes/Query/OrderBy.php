<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class OrderBy extends QueryPipe
{
    protected $field;
    protected $direction;

    public function __construct($field, $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->orderBy($this->field, $this->direction));
    }
}