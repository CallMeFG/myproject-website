<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation; // Import model Reservation
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for the admin.
     */
    public function index()
    {
        // Ambil semua reservasi
        // Eager load relasi 'user' (pengguna yang memesan) dan 'room' (kamar yang dipesan)
        // Urutkan berdasarkan tanggal reservasi dibuat, yang paling baru di atas
        $reservations = Reservation::with(['user', 'room'])
            ->orderBy('created_at', 'desc')
            ->paginate(15); // Gunakan pagination jika datanya banyak

        return view('admin.reservations.index', compact('reservations'));
    }

    // Jika nanti Anda butuh metode show untuk melihat detail satu reservasi oleh admin:
    /*
    public function show(Reservation $reservation)
    {
        // $reservation sudah otomatis di-load dengan Route Model Binding jika rutenya didefinisikan dengan {reservation}
        // Anda mungkin ingin eager load user dan room juga di sini jika belum otomatis
        $reservation->load(['user', 'room']);
        return view('admin.reservations.show', compact('reservation'));
    }
    */
}
