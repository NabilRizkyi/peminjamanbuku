<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role != $role) {

            if (auth()->user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/anggota');
        }

        return $next($request);
    }
}