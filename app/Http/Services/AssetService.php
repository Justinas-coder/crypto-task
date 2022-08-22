<?php

namespace App\Http\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AssetService
{

    // return Asset $asset
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

}

