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
use App\Http\Controllers\Admin\UserManagementController; // Tambahkan ini
use App\Http\Controllers\Staff\RoomStatusController; // <-- TAMBAHKAN INI

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
// TAMBAHKAN RUTE UNTUK HALAMAN ABOUT DAN KONTAK DI SINI:
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [HomeController::class, 'handleContactForm'])->name('contact.submit'); // RUTE BARU

// --- RUTE AREA PENGGUNA BARU (Perubahan Besar) ---
Route::middleware(['auth'])->group(function () {
    // Rute untuk menyimpan reservasi tetap di sini
    Route::post('/reservations/{room}', [ReservationController::class, 'store'])->name('reservations.store');
    // RUTE BARU UNTUK HALAMAN SUKSES/RESI
    Route::get('/reservations/success/{reservation}', [ReservationController::class, 'success'])->name('reservations.success');
    // Grup baru untuk Area Pengguna dengan prefix /user
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });

    // Rute profil untuk update dan delete kita arahkan ke controller yang sama
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rute untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    // TAMBAHKAN RESOURCE ROUTE UNTUK KAMAR DI SINI:
    Route::resource('rooms', RoomManagementController::class);
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    // TAMBAHKAN RUTE UNTUK MANAJEMEN PENGGUNA & STAFF DI SINI:
    Route::get('/users', [UserManagementController::class, 'listUsers'])->name('users.index'); // Daftar pengguna biasa
    Route::get('/staff', [UserManagementController::class, 'listStaff'])->name('staff.index'); // Daftar staff
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy'); // Hapus pengguna atau staff
    // TAMBAHKAN RUTE UNTUK MELIHAT DETAIL SATU RESERVASI DI SINI:
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    // TAMBAHKAN RUTE UNTUK EDIT DAN UPDATE PERAN PENGGUNA DI SINI:
    Route::get('/users/{user}/edit-role', [UserManagementController::class, 'editRole'])->name('users.editRole');
    Route::patch('/users/{user}/update-role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');
});

// Rute untuk Staff
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', StaffDashboardController::class)->name('dashboard');
    // Rute staff lainnya akan ditambahkan di sini nanti
    // TAMBAHKAN RUTE UNTUK MELIHAT SEMUA RESERVASI STAFF DI SINI:
    Route::get('/reservations', [StaffReservationController::class, 'index'])->name('reservations.index');
    // TAMBAHKAN RUTE UNTUK UPDATE STATUS RESERVASI DI SINI:
    Route::patch('/reservations/{reservation}/update-status', [StaffReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    // TAMBAHKAN RUTE UNTUK MELIHAT DETAIL SATU RESERVASI STAFF DI SINI:
    Route::get('/reservations/{reservation}', [StaffReservationController::class, 'show'])->name('reservations.show');
    // RUTE BARU UNTUK STATUS KAMAR <-- TAMBAHKAN BLOK INI
    Route::get('/room-status', [RoomStatusController::class, 'index'])->name('room-status.index');
});
require __DIR__ . '/auth.php';
