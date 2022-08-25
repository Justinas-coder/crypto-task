<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetValidationRequest;
use App\Http\Services\AssetService;
use App\Http\Services\HttpClientService;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AssetController extends Controller
{
    public function index(Request $request, HttpClientService $service)
    {
        $currencies = Currency::all();

        $currencies_stock = $service->httpClientResponse();

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

        if ($request->asset) {
            $queried_asset = auth()->user()->assets()->where('crypto_currency', $request->asset)->get()->all();
        } else {
            $queried_asset = auth()->user()->assets()->get()->all();
        }

        return view('admin.index', [
            'currencies' => $currencies,
            'queried_asset' => $queried_asset,
            'asset_quantities' => $asset_quantities,
        ]);
    }

    public function create()
    {
        $currencies = Currency::all();

        $asset = auth()->user()->assets()->get()->all();

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

    public function edit(Asset $asset)
    {
        $currencies = Currency::all();
        return view('admin.update', ['asset' => $asset, 'currencies' => $currencies]);
    }


    public function update(AssetValidationRequest $request, Asset $asset)
    {

        auth()->user()->assets()->where('id', $asset->id)->update($request->validated());

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
