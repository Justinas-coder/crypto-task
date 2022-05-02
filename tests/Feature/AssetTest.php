<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $asset = [];

    public function __construct()
    {
        $this->asset = [
            'title' => 'Binance',
            'crypto_currency' => 'BTC',
            'quantity' => '2',
            'paid_value' => '20',
            'currency' => 'USD'
        ];
    }

    public function asset_store_response_test()
    {
        $response = $this->post('/asset/store', $this->asset);

        $response = assertRedirect('/home');
    }

    public function asset_store_db_test()
    {
        $this->assertDatabaseHas('assets', $this->asset);
    }
}
