<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Asset;
use Carbon\Carbon;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'currency' => $this->crypto_currency,
            'quantity' => $this->quantity,
            'payed_value' => $this->paid_value,
            'crypto_currency' => carbon::parse($this->created_at),
        ];
    }
}
