<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    }
}