<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MatchService;
use Illuminate\Http\Request;

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

    }
}