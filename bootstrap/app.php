<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // <-- TAMBAHKAN BARIS INI
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    // Middleware global, grup, dll. mungkin sudah ada di sini
    // atau Anda bisa menambahkannya.

    // Untuk mendaftarkan alias middleware:
    $middleware->alias([ // Gunakan metode alias()
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'staff' => \App\Http\Middleware\StaffMiddleware::class,
        // Anda bisa menambahkan alias lain di sini juga jika ada
        // 'auth' => \App\Http\Middleware\Authenticate::class, // Contoh, ini biasanya sudah ada
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Contoh
    ]);
    // Contoh lain jika Anda perlu memodifikasi middleware global atau grup:
    // $middleware->web(append: [
    //     MyCustomWebMiddleware::class,
    // ]);

    // $middleware->api(prepend: [
    //     MyCustomApiMiddleware::class,
    // ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
    //Konfigurasi exception handling
})->create();
