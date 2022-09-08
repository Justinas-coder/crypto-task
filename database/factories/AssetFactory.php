<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => '1',
            'user_id' => '1',
            'title' => 'Binanceeee',
            'crypto_currency' => 'MIOTA',
            'quantity' => '2',
            'paid_value' => '20',
            'currency' => 'USD'
        ];
    }
}
