<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;


class UserSeeder extends Seeder
{

    use HasApiTokens;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $user->createToken('developer-access');
    }
}
