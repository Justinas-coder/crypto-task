<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Http\Services\CurrencyService;

use Illuminate\Support\Facades\Http;

class HttpClientService
{
    public function httpClientResponse()
    {
//        /**
//         * #2-1 using Laravel HTTP Client
//         */
//
//
        $response = Http::get('http://api.coinlayer.com/live', [
            "access_key" => config('services.coin_layer.api_key'),
            "symbols" => Currency::get()->implode('name', ', ')
        ]);


        $currencies_stock = ($response->json());

                return $currencies_stock;


        //** In Case of limited number of request to Coin Layer, temporary can use fake data */

//        $currencies_stock_fake = ['rates' => [
//            "BTC" => 21654.144787,
//            "ETH" => 1700.76,
//            "MIOTA" => 0.30422
//        ]];
//
//
//        return $currencies_stock_fake;
    }




}
