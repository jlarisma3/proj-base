<?php

namespace Database\Seeders;

use App\Models\User\Role\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['name' => 'Admin', 'code' => 'admin'],
            ['name' => 'Staff', 'code' => 'staff'],
            ['name' => 'Member', 'code' => 'member'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'code' => $role['code']
            ],$role);
        }
    }
}
