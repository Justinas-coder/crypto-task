<?php

namespace Tests\Feature;

use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiAssetTest extends TestCase
{
    public $asset = [];

    public function __construct()
    {
        parent::__construct();
        $this->asset = [
            'user_id' => '2',
            'title' => 'Binanceeee',
            'crypto_currency' => 'BTC',
            'quantity' => '2',
            'paid_value' => '20',
            'currency' => 'USD'
        ];
    }

    public function test_api_asset_store_response()
    {
        $response = $this->post('/api/assets', $this->asset);

        $this->asset = $response['asset'];

        $response->assertStatus( 201);
    }

    public function test_api_asset_update_response()
    {
        $asset = Asset::first();

        $response = $this->put('/api/assets/' . $asset->id, [

            'user_id' => 2,
            'title' => 'TestTestTestUpdate',
            'crypto_currency' => 'BTC',
            'quantity' => 3,
            'paid_value' => 4222,
            'currency' => 'USD'

        ]);

        $response->assertStatus( 201);
    }










    public function test_api_asset_delete_response()
    {
        $asset = Asset::first();

        $response = $this->delete('/api/assets', ['id' => $asset->id]);


        $response->assertStatus(204);
    }
}
