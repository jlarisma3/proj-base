<?php

namespace Database\Seeders;

use App\Models\System\Route\Endpoint;
use App\Models\User\Role\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleEndpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_endpoints')->truncate();

        $roles = Role::get(); //UserType::all();
        $roles->each(function ($role) {
            $endpoints = Endpoint::get();
            $routes = array_merge($this->roledRoutes()[$role->code], $this->genericRoutes());

            $endpoints->each(function ($endpoint) use($role, $routes) {
                if($role->code == 'admin') {
                    if(!$role->endpoints->contains($endpoint->id)) {
                        $role->endpoints()->attach($endpoint->id);
                    }
                } else {
                    if(in_array($endpoint->route_name, $routes)) {
                        if(!$role->endpoints->contains($endpoint->id)) {
                            $role->endpoints()->attach($endpoint->id);
                        }
                    }
                }
            });
        });
    }

    private function roledRoutes() : array
    {
        return [
            'admin' => ['*']
        ];
    }

    /**
     * @return string[]
     */
    private function genericRoutes() : array
    {
        return [
            'dashboard',
        ];
    }
}
