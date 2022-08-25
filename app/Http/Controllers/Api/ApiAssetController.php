<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\AssetValidationRequest;
use App\Http\Resources\AssetResource;
use App\Http\Services\AssetService;
use App\Http\Services\HttpClientService;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApiAssetController extends Controller
{
    public function index(Request $request)
    {
        return AssetResource::collection(Asset::all());
    }

    public function showTotalSum(Request $request, HttpClientService $service)
    {
        $currencies = Currency::all();

        $currencies_stock = $service->httpClientResponse();

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

    public function store(AssetValidationRequest $request, AssetService $service)
    {
        $asset = $service->storeNewAsset(

            auth('sanctum')->user()->id,
            $request->title,
            $request->crypto_currency,
            $request->quantity,
            $request->paid_value,
            $request->currency
        );
        return response()->json(['asset' => $asset], 201);
    }

    public function update(AssetValidationRequest $request, $id)
    {
        $asset = Asset::findOrFail($id);

        auth('sanctum')->user()->assets()->where('id', $asset->id)->update($request->validated());

        return response()->json(['asset' => $asset], 201);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return $validator->messages();
        }

        $asset = Asset::findOrFail($request->id);

        $asset->delete();

        return response()->json('deleted', 204);
    }


}
