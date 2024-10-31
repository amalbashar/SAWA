<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role_id == $role) {
            return $next($request);
        }

        return redirect('/'); // Redirect unauthorized users to home or another page
    }
}

