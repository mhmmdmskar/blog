<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUser
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user punya role 'user'
        if (auth()->check() && auth()->user()->role === 'user') {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }
}