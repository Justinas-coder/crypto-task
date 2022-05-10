<?php

namespace Tests\Feature;

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



    public function test_api_asset_delete_response()
    {

        $response = $this->delete('/api/assets', $this->asset);

        $response->assertStatus(204);
    }
}
