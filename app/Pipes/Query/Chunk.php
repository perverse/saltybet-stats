<?php

namespace App\Pipes\Query;

use App\Pipes\QueryPipe;
use Closure;

class Chunk extends QueryPipe
{
    protected $num;
    protected $closure;

    public function __construct(int $num, Closure $closure)
    {
        $this->num = $num;
        $this->closure = $closure;
    }

    public function handle($builder, Closure $next)
    {
        $builder = $next();
        return $builder->chunk($this->num, $this->closure);
    }
}