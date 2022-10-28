<?php

namespace App\Http\Controllers;

use App\Exports\BeersExport;
use App\Http\Requests\BeerRequest;
use App\Mail\ExportEmail;
use App\Services\PunkapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers(...$request->validated());
    }

    public function export(BeerRequest $request, PunkapiService $service)
    {
        $beers = $service->getBeers(...$request->validated());

        $filteredBeers = collect($beers)->map(function ($value, $key) {
            return collect($value)
                ->only(['name', 'tagline', 'first_brewed', 'description'])
                ->toArray();
        })->toArray();

        $filename = "cervejas-encontradas-" . now()->format('Y-m-d - H_i') . ".xlsx";

        Excel::store(
            new BeersExport($filteredBeers),
            $filename,
            's3'
        );

        Mail::to("jeferson_chagas25@hotmail.com")->send(new ExportEmail($filename));

        return 'Relatório criado';
    }
}
