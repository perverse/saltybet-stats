<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MatchService;
use Illuminate\Http\Request;
use App\Resources\Match as Resource;

class MatchController extends Controller
{
    protected $service;
    protected $request;

    public function __construct(MatchService $service, Request $request)
    {
        $this->service = $service;
        $this->request = $request;
    }

    public function index()
    {
        return Resource\Full::collection($this->service->fetch(
            $this->request->get('page', 1),
            $this->request->get('limit', 25),
            json_decode($this->request->get('filters', []), true),
            $this->request->get('sortBy', ['date'])[0],
            $this->request->get('sortDesc')[0] == 'false' ? 'ASC' : 'DESC'
        ));
    }

    public function find($id)
    {
        return $this->service->find($id);
    }
}