<?php

namespace Database\Seeders;

use App\Models\System\Route\Endpoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EndpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        foreach ($routes as $k => $route) {

            if(! in_array('App\Http\Middleware\System\Auth\RoleEndpointMiddleware', $route->middleware()))
                continue;

            Endpoint::firstOrCreate([
                'route_name' => $route->getName()
            ],[
                'middleware' => implode(',', $route->middleware()),
                'uri' => $route->uri,
                'method' => implode(',', $route->methods())
            ]);
        }

    }
}
