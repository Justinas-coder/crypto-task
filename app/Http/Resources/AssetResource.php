<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        /**
         * #2-1 using Laravel HTTP Client
         */
        $response = Http::get('http://api.coinlayer.com/live', [
            "access_key" => config('services.coin_layer.api_key'),
            "symbols" => Currency::get()->implode('name', ', ')
        ]);

        $currencies_stock = ($response->json());

        return [
            'id' => $this->id,
            'title' => $this->title,
            'currency' => $this->crypto_currency,
            'quantity' => $this->quantity,
            'payed_value' => $this->paid_value,
            'current_value' => $this->quantity * $currencies_stock['rates'][$this->crypto_currency],
            'created_at' =>$this->created_at->toDateTimeString(),
        ];
    }
}
