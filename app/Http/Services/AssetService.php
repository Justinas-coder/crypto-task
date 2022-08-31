<?php

namespace App\Http\Services;

use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;


class AssetService
{
    public function storeNewAsset(
        int $user_id,
        string $title,
        string $crypto_currency,
        int $quantity,
        int $paid_value,
        string $currency
    ): Asset
    {
        $asset = Asset::create([
            'user_id' => $user_id,
            'title' => $title,
            'crypto_currency' => $crypto_currency,
            'quantity' => $quantity,
            'paid_value' => $paid_value,
            'currency' => $currency
        ]);

        return $asset;

}


    public function assetQuantitiesIndex()
    {
        $currencies = Currency::all();

        $currencies_stock = (new HttpClientService())->httpClientResponse();

        $asset_quantities = [];

        foreach ($currencies as $currency) {
            $asset_quantities[] = [
                'currency' => $currency->name,
                'total_qty' => auth()->user()->assets()->where('crypto_currency', $currency->name)->sum('quantity'),
                'total_value' => auth()->user()->assets()->where('crypto_currency',
                    $currency->name)->get()->sum('total_value'),
                'current_value' => auth()->user()->assets()->where('crypto_currency',
                        $currency->name)->sum('quantity') * $currencies_stock['rates'][$currency->name],
            ];
        }

        return  $asset_quantities;
    }

    public function getQueriedAsset(Request $request){

        if ($request->asset) {
            $queried_asset = auth()->user()->assets()->where('crypto_currency', $request->asset)->get()->all();
        } else {
            $queried_asset = auth()->user()->assets()->get()->all();
        }
        return $queried_asset;
    }

    public function getAllAssets(){

        $asset = auth()->user()->assets()->get()->all();

        return $asset;
    }

    public function getAllCurrencies(){

        $currencies = Currency::all();

        return $currencies;
    }

    public function getSingleAssetData($id){

        if (Asset::where('id', $id)->exists() && auth('sanctum')->user()->id === Asset::where('id', $id)->value('user_id')){

            $asset = auth('sanctum')->user()->assets()->where('id', $id)->get();

        return $asset; } else {

            return ('Asset id '.'  '.$id.'  '.' not exist or  belongs to another user');
        }
    }

    public function updateAsset(Request $request, Asset $asset){

        $asset = auth()->user()->assets()->where('id', $asset->id)->update($request->validated());

        return $asset;
    }

    public function apiAssetDelete($id){

        if (Asset::where('id', $id)->exists() && auth('sanctum')->user()->id === Asset::where('id', $id)->value('user_id')) {
            auth('sanctum')->user()->assets()->where('id', $id)->delete();
            return response()->json('Asset id -'.'  '.$id.'  '.' was deleted');

        } else {

            return response()->json('Asset id '.'  '.$id.'  '.' not exist or  belongs to another user');
        }
    }

}

