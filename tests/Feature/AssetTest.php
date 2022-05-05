<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

class AssetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public $asset = [];


    public function __construct()
    {
        parent::__construct();
        $this->asset = [
            'title' => 'Binanceeee',
            'crypto_currency' => 'BTC',
            'quantity' => '2',
            'paid_value' => '20',
            'currency' => 'USD'
        ];
    }


    public function test_asset_store_response()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/asset/store', $this->asset);

        $response->assertRedirect('/assets');


    }

    public function test_asset_store_db()
    {
        $this->assertDatabaseHas('assets', $this->asset);
    }
}
