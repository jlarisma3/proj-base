<?php

namespace App\Http\Middleware\System\Auth;

use Closure;
use Illuminate\Http\Request;

class RoleEndpointMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if($user->role->code == 'admin')
            return $next($request);

        $routeName = $request->route()->getName();
        $access = $user->role
            ->endpoints()
            ->where('route_name', $routeName)
            ->first();

        if(! $access) {
            return redirect()->route('dashboard');
        }


        return $next($request);
    }
}
