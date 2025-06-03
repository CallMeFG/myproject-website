<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Jangan lupa tambahkan ini

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (beranda).
     */
    public function index()
    {
        // Ambil misalnya 3 kamar terbaru berdasarkan ID atau created_at
        // Jika ingin berdasarkan ID terbaru (asumsi ID lebih besar = lebih baru)
        $featuredRooms = Room::orderBy('id', 'desc')->take(3)->get();

        // Atau jika ingin berdasarkan tanggal dibuat terbaru
        // $featuredRooms = Room::orderBy('created_at', 'desc')->take(3)->get();

        // Kirim data kamar ke view 'home'
        // Kita akan buat view 'home.blade.php' nanti
        return view('home', ['featuredRooms' => $featuredRooms]);
    }
}
