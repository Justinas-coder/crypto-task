<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\AssetSumResource;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;



class ApiAssetController extends Controller
{
    public function index(Request $request)
    {

        return AssetResource::collection(Asset::all());
    }

    public function showTotalSum(Request $request)
    {
        $currencies = Currency::all();

        /**
         * #2-1 using Laravel HTTP Client
         */
        $response = Http::get('http://api.coinlayer.com/live', [
            "access_key" => config('services.coin_layer.api_key'),
            "symbols" => "BTC,ETH,MIOTA"
        ]);


        $currencies_stock = ($response->json());

        $asset_quantities = [];

        foreach ($currencies as $currency) {
            $asset_quantities[] = [
                'currency' => $currency->name,
                'current_value' => Asset::where('crypto_currency',
                        $currency->name)->sum('quantity') * $currencies_stock['rates'][$currency->name],
            ];
        }

        return $asset_quantities;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|min:0',
            'title' => 'required|min:8|max:255',
            'crypto_currency' => ['required', Rule::in(['BTC', 'ETH', 'MIOTA'])],
            'quantity' => 'required|numeric|min:0',
            'paid_value' => 'required|numeric|min:0',
            'currency' => 'required',
        ]);

       if($validator->fails()){
           return $validator->messages();
       }

        $asset = Asset::create($request->all());
        return response()->json($asset, 201);
    }

}
