<?php

namespace Database\Seeders;

use App\Models\User\Payment\UserPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EndpointSeeder::class,
            StatusSeeder::class,
            RoleSeeder::class,
            RoleEndpointSeeder::class,
        ]);

         \App\Models\User::factory(50)->create();

         //UserPayment::factory(50)->create();
    }
}
