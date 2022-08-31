<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetValidationRequest;
use App\Http\Services\AssetService;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssetController extends Controller
{
    public function index(Request $request, AssetService $service)
    {
        $currencies = Currency::all();

        $asset_quantities = $service->assetQuantitiesIndex();

        $queried_asset = $service->getQueriedAsset($request);

        return view('admin.index', [
            'currencies' => $currencies,
            'queried_asset' => $queried_asset,
            'asset_quantities' => $asset_quantities,
        ]);
    }

    public function create(AssetService $service)
    {
        $currencies = Currency::all();

        $asset = $service->getAllAssets();

        return view('admin.create', ['asset' => $asset, 'currencies' => $currencies]);
    }

    public function store(AssetValidationRequest $request, AssetService $service)
    {
        $service->storeNewAsset(

                auth()->user()->id,
                $request->title,
                $request->crypto_currency,
                $request->quantity,
                $request->paid_value,
                $request->currency
        );

        session()->flash('asset-created-message', 'Asset was Created');
        return redirect()->route('asset.index');
    }

    public function edit(Asset $asset, AssetService $service)
    {
        $currencies = $service->getAllCurrencies();

        return view('admin.update', ['asset' => $asset, 'currencies' => $currencies]);
    }


    public function update(AssetValidationRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        Session::flash('asset-updated-message', 'Asset'.':  '.$request['title'].'  '.'was Updated');
        return redirect()->route('asset.index');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        Session::flash('message', 'Asset was deleted');
        return back();
    }
}
