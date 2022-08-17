<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Http\Services\CurrencyService;

use Illuminate\Support\Facades\Http;

class HttpClientService
{
    public function httpClientResponse()
    {
        /**
         * #2-1 using Laravel HTTP Client
         */
        $currency_type = Currency::get()->implode('name', ', ');

        $response = Http::get('http://api.coinlayer.com/live', [
            "access_key" => config('services.coin_layer.api_key'),
            "symbols" => $currency_type
        ]);

        $currencies_stock = ($response->json());

        return $currencies_stock;
    }




}
