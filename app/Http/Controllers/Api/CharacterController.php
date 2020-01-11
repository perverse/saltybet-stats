<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Resources\Character as Resource;
use App\Services\CharacterService;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    protected $service;
    protected $request;

    public function __construct(CharacterService $service, Request $request)
    {
        $this->service = $service;
        $this->request = $request;
    }

    public function index()
    {
        return Resource\Full::collection($this->service->fetch(
            $this->request->get('page', 1),
            $this->request->get('limit', 25),
            json_decode($this->request->get('filters', '{}'), true),
            $this->request->get('sortBy', ['name'])[0],
            $this->request->get('sortDesc')[0] == 'true' ? 'DESC' : 'ASC'
        ));
    }

    public function find($id)
    {
        return new Resource\Full($this->service->find($id, json_decode($this->request->get('filters', '{}'))));
    }
}