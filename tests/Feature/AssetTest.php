<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;

class AssetTest extends TestCase
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

            'title' => 'Binanceeee',
            'crypto_currency' => 'MIOTA',
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

        $user = User::factory()->create();

        $this->actingAs($user)->withSession(['banned' => false])->post('/asset/store', $this->asset);

        $this->assertDatabaseHas('assets', $this->asset);
    }


}
