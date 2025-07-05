<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if(auth()->check()) {
            if ($request->routeIs('manage_profile')) {
                return $next($request);
            }
            $user = auth()->user();
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        return redirect()->route('unauthorized');
    }
}



