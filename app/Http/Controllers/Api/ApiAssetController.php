<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\AssetValidationRequest;
use App\Http\Resources\AssetResource;
use App\Http\Services\AssetService;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Exceptions\AssetNotFoundException;
use App\Exceptions\NotOwnedAssetException;


class ApiAssetController extends Controller
{
    public function index(Request $request)
    {
        return AssetResource::collection(Asset::all());
    }

    public function showTotalSum(AssetService $service)
    {
        return response()->json(['data' => $service->assetQuantitiesIndex()]);
    }

    public function showSingleAssetData(AssetService $service, $id){

        try {
            $data = $service->getSingleAssetData($id);
            return response()->json(['data' => $data]);

        } catch (AssetNotFoundException $exception) {

            return response()->json(['data' => $exception->getMessage()]);

        } catch (NotOwnedAssetException $exception) {

            return response()->json(['data' => $exception->getMessage()]);
        }

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

        auth('sanctum')->
        user()->assets()->
        where('id', $asset->id)->
        update($request->validated());

        $asset->refresh();

        return response()->json(['asset' => $asset], 201);
    }

    public function delete($id, AssetService $service)
    {
        try {
            $response = $service->apiAssetDelete($id);
            return $response;

        } catch (AssetNotFoundException $exception) {

            return response()->json(['data' => $exception->getMessage()], status: 404);

        } catch (NotOwnedAssetException $exception) {

            return response()->json(['data' => $exception->getMessage()]);
        }


    }


}
