<?php

namespace App\Http\Controllers;

use App\Http\Services\HttpClientService;
use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index(Request $request, HttpClientService $service)
    {
        $currencies = Currency::all();

        $currencies_stock = $service->httpClientResponse();

        dd($currencies_stock);

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

    public function store(Request $request)
    {

//        $service->storeNewAsset(
////            $request->title,
////            $request->crypto_currency,
////            $request->quantity,
////            $request->paid_value,
////            $request->currency
////        );

        $inputs = $request->validate([
            'title' => 'required|min:8|max:255',
            'crypto_currency' => ['required', Rule::in(['BTC', 'ETH', 'MIOTA'])],
            'quantity' => 'required|numeric|min:1',
            'paid_value' => 'required|numeric|min:0',
            'currency' => 'required',
        ]);


        auth()->user()->assets()->create($inputs);
        session()->flash('asset-created-message', 'Asset was Created');
        return redirect()->route('asset.index');
    }

    public function edit(Asset $asset)
    {
        $currencies = Currency::all();
        return view('admin.update', ['asset' => $asset, 'currencies' => $currencies]);
    }


    public function update(Request $request, Asset $asset)
    {
        $inputs = request()->validate([
            'title' => 'required|min:8|max:255',
            'currency' => 'required',
            'crypto_currency' => ['required', Rule::in(['BTC', 'ETH', 'MIOTA'])],
            'quantity' => 'required|numeric|min:0',
            'paid_value' => 'required|numeric|min:0'
        ]);

        $asset->title = $inputs['title'];
        $asset->currency = $inputs['currency'];
        $asset->crypto_currency = $inputs['crypto_currency'];
        $asset->quantity = $inputs['quantity'];
        $asset->paid_value = $inputs['paid_value'];

        auth()->user()->assets()->where('id', $asset->id)->update($inputs);
        Session::flash('asset-updated-message', 'Asset'.':  '.$inputs['title'].'  '.'was Updated');
        return redirect()->route('asset.index');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        Session::flash('message', 'Asset was deleted');
        return back();
    }
}
