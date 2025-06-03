<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'staff') {
            return $next($request);
        }
        // Jika bukan staff, arahkan ke halaman login atau halaman error akses
        // Auth::logout(); // Opsional
        return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses Staff.');
    }
}
