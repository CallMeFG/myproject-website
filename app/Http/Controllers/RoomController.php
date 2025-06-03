<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Jangan lupa tambahkan ini

class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua kamar.
     */
    public function index()
    {
        // Ambil semua kamar dari database
        // Mungkin nanti kita tambahkan pagination jika datanya banyak
        $rooms = Room::all(); // Atau Room::paginate(10); untuk pagination

        // Kirim data kamar ke view 'rooms.index'
        // Kita akan buat view 'resources/views/rooms/index.blade.php' nanti
        return view('rooms.index', ['rooms' => $rooms]);
    }

    /**
     * Menampilkan detail satu kamar.
     * Laravel akan otomatis melakukan Route Model Binding di sini,
     * mencari Room berdasarkan {room} (ID) di URL dan menginjectnya sebagai objek $room.
     */
    public function show(Room $room) // Tipe parameter adalah Room $room
    {
        // Objek $room sudah otomatis berisi data kamar yang sesuai ID dari URL.
        // Kirim data kamar ke view 'rooms.show'
        // Kita akan buat view 'resources/views/rooms/show.blade.php' nanti
        return view('rooms.show', ['room' => $room]);
    }
}
