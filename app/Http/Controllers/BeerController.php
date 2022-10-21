<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeerRequest;
use App\Services\PunkapiService;
use Illuminate\Http\Request;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers(...$request->validated());
    }
}
