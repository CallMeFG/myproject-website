<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Reservation; // Tambahkan ini
use App\Policies\ReservationPolicy; // Tambahkan ini
class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Reservation::class => ReservationPolicy::class, // <-- TAMBAHKAN BARIS INI
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
