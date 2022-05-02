<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $currencies = Currency::all();

        $asset = auth()->user()->assets()->get()->all();

        return view('admin.create', ['asset' => $asset, 'currencies' => $currencies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|min:8|max:255',
            'crypto_currency' => ['required', Rule::in(['BTC', 'ETH', 'MIOTA'])],
            'quantity' => 'required|numeric|min:0',
            'paid_value' => 'required|numeric|min:0',
            'currency' => 'required',
        ]);

        auth()->user()->assets()->create($inputs);
        session()->flash('asset-created-message', 'Asset was Created');
        return redirect()->route('asset.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $currencies = Currency::all();
        return view('admin.update', ['asset' => $asset, 'currencies' => $currencies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        Session::flash('message', 'Asset was deleted');
        return back();
    }
}
