<?php

namespace Database\Seeders;

use App\Models\User\Status\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Active', 'code' => 'activ'],
            ['name' => 'Inactive', 'code' => 'inactiv'],
        ];

        foreach ($status as $s) {
            Status::firstOrCreate([
                'code' => $s['code']
            ],$s);
        }

    }
}
