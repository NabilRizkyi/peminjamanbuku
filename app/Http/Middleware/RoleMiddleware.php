<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // kalau belum login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // kalau role tidak sesuai
        if (auth()->user()->role != $role) {

            // ⛔ JANGAN ke dashboard (biar ga loop)
            // ✅ arahkan langsung sesuai role
            if (auth()->user()->role === 'admin') {
                return redirect()->route('books.index');
            }

            return redirect()->route('siswa.dashboard');
        }

        return $next($request);
    }
}