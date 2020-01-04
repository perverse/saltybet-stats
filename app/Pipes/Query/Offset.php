<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class Offset extends QueryPipe
{
    protected $offset;

    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    public function handle($builder, Closure $next)
    {
        return $next($builder->skip($this->offset));
    }
}