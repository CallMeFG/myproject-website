<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        // Jika bukan admin, arahkan ke halaman login atau halaman error akses
        // Auth::logout(); // Opsional: logout pengguna jika mencoba akses tidak sah
        return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses Admin.');
    }
}
