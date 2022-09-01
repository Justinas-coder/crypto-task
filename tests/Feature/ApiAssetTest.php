<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ApiAssetTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }


    public $asset = [];

    public function __construct()
    {
        parent::__construct();
        $this->asset = [
            'id' => '1',
            'user_id' => '2',
            'title' => 'Binanceeee',
            'crypto_currency' => 'MIOTA',
            'quantity' => '2',
            'paid_value' => '20',
            'currency' => 'USD'
        ];
    }



    public function test_api_asset_store_response()
    {
         Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );


        $response = $this->postJson('/api/assets', $this->asset);

        $this->asset = $response['asset'];


        $response->assertStatus( 201);
    }

    public function test_api_asset_update_response()
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $asset = Asset::factory()->create();


        $response = $this->putJson('/api/assets/' . $asset->id, [

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
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $asset = Asset::factory()->create();


        $response = $this->delete('/api/assets/'. $asset->id);

        $response->assertStatus(200);
    }
}
