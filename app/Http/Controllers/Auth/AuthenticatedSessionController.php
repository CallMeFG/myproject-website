<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Logika pengalihan berdasarkan peran
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Kita akan membuat nama rute 'admin.dashboard' nanti
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'staff') {
            // Kita akan membuat nama rute 'staff.dashboard' nanti
            return redirect()->intended(route('staff.dashboard'));
        }

        // Untuk pengguna biasa, arahkan ke '/dashboard' yang sudah ada namanya
        // atau ke RouteServiceProvider::HOME jika Anda sudah mengubahnya.
        // Jika RouteServiceProvider::HOME masih '/dashboard', ini sudah benar.
        return redirect()->intended(route('dashboard'));
        // Atau jika RouteServiceProvider::HOME sudah Anda ubah ke '/' atau '/home'
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
