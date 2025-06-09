<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Meskipun tidak langsung digunakan di metode index, baik untuk disertakan.
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan informasi pengguna yang sedang login.
// Kita tidak perlu meng-import model App\Models\Reservation secara langsung di sini
// karena kita akan mengaksesnya melalui relasi dari model User.
// Kita juga tidak perlu meng-import model App\Models\User di sini karena Auth::user()
// akan mengembalikan instance dari model User tersebut.

class UserDashboardController extends Controller
{
    /**
     * Menampilkan dashboard pengguna beserta riwayat reservasi mereka.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \App\Models\User|null $user */ // Tambahkan baris PHPDoc ini
        $user = Auth::user();
        $reservations = collect(); // Inisialisasi sebagai collection kosong

        if ($user) { // Baik untuk memeriksa apakah user benar-benar ada
            // Ambil reservasi milik user, urutkan berdasarkan yang terbaru
            // Eager load relasi 'room' agar kita bisa menampilkan tipe kamar
            $reservations = $user->reservations()->with('room')->orderBy('created_at', 'desc')->get();
        }

        return view('customer.dashboard', ['reservations' => $reservations]);
    }
}
