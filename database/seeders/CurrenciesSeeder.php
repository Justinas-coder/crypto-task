<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = ['BTC', 'ETH', 'MIOTA'];

        foreach ($currencies as $currency) {

            Currency::insert(['name' => $currency]);

        }
    }
}
