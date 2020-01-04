<?php

namespace App\Repositories;

use App\Pipes\QueryPipe;
use App\Pipes\Query\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

abstract class Repository
{
    protected $pipeline;
    protected $pipes;

    public function __construct()
    {
        $this->flushPipeline();
    }

    protected function createPipeline()
    {
        return app(Pipeline::class);
    }

    protected function createModel()
    {
        return app($this->getModel());
    }

    protected function flushPipeline()
    {
        $this->pipeline = $this->createPipeline();
        $this->pipeline->send($this->createModel());
        $this->pipes = [];
    }

    public function query()
    {
        if (!empty($this->pipeline)) {
            $this->flushPipeline();
        }
        
        $this->pushPipe(app(Query::class));

        return $this;
    }

    public function create(array $properties = [])
    {
        $modelName = $this->getModel();

        return new $modelName($properties);
    }

    public function persist(Model $model)
    {
        return $model->save();
    }

    public function pushPipe($pipe)
    {
        $this->pipes[] = $pipe;

        return $this;
    }

    public function setPipes(array $pipes)
    {
        $this->pipes = $pipes;

        return $this;
    }

    public function flushPipes()
    {
        $this->pipes = [];

        return $this;
    }

    public function execute()
    {
        $return = $this->pipeline->through($this->pipes)
                                 ->thenReturn();
        
        $this->flushPipeline();

        return $return;
    }

    abstract public function getModel();
}