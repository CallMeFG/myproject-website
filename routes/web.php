<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;    // Sudah ada dari Breeze
use App\Http\Controllers\HomeController;        // Tambahan dari kita
use App\Http\Controllers\RoomController;        // Tambahan dari kita
use App\Http\Controllers\ReservationController; // Pastikan ini ada
use App\Http\Controllers\UserDashboardController; // Tambahkan ini
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomManagementController; // Tambahkan ini
use App\Http\Controllers\Admin\ReservationController as AdminReservationController; // Tambahkan ini
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\ReservationController as StaffReservationController; // Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute-rute baru kita untuk halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');


// Rute Dashboard Pengguna (menggantikan definisi lama dari Breeze)
Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
// Grup rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Rute untuk profil pengguna (sudah ada)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk menyimpan reservasi baru (TAMBAHKAN BARIS INI)
    Route::post('/reservations/{room}', [ReservationController::class, 'store'])->name('reservations.store');
});
// Rute untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    // TAMBAHKAN RESOURCE ROUTE UNTUK KAMAR DI SINI:
    Route::resource('rooms', RoomManagementController::class);
    // Rute admin lainnya akan ditambahkan di sini nanti
    // TAMBAHKAN RUTE UNTUK MELIHAT SEMUA RESERVASI DI SINI:
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    // Mungkin nanti kita tambahkan rute untuk melihat detail satu reservasi oleh admin:
    // Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
});

// Rute untuk Staff
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', StaffDashboardController::class)->name('dashboard');
    // Rute staff lainnya akan ditambahkan di sini nanti
    // TAMBAHKAN RUTE UNTUK MELIHAT SEMUA RESERVASI STAFF DI SINI:
    Route::get('/reservations', [StaffReservationController::class, 'index'])->name('reservations.index');
    // TAMBAHKAN RUTE UNTUK UPDATE STATUS RESERVASI DI SINI:
    Route::patch('/reservations/{reservation}/update-status', [StaffReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
});
require __DIR__ . '/auth.php';
