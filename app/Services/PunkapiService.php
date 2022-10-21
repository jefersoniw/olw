<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PunkapiService
{
  public function getBeers(?string $beer_name = null, ?string $food = null, ?int $ibu_gt = null, ?string $malt = null)
  {

    $params = array_filter(get_defined_vars());

    return Http::punkapi()
      ->get("/beers", $params)
      ->throw()
      ->json();
  }
}
