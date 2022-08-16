<?php

namespace App\Http\Services;

use App\Models\Asset;

class AssetService
{
    public function storeNewAsset(
        string $title,
        string $crypto_currency,
        string $quantity,
        string $paid_value,
        string $currency
    ): Asset
    {
        $asset = Asset::create([
            'title' => $title,
            'crypto_currency' => $crypto_currency,
            'quantity' => $quantity,
            'paid_value' => $paid_value,
            'currency' => $currency
        ]);

        return $asset;

}




}

