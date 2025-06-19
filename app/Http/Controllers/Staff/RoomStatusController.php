<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomStatusController extends Controller
{
    /**
     * Menampilkan halaman status kamar.
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Hitung kamar yang sedang dipakai HARI INI
            // Kondisi: Reservasi sudah dikonfirmasi DAN hari ini berada di antara tgl check-in dan check-out
            $in_use_count = Reservation::where('room_id', $room->id)
                ->whereIn('status', ['Confirmed', 'Dikonfirmasi'])
                ->where('check_in_date', '<=', $today)
                ->where('check_out_date', '>', $today)
                ->count();

            // Tambahkan properti baru ke setiap objek kamar
            $room->in_use_count = $in_use_count;
            $room->available_count = $room->quantity - $in_use_count;
        }

        // Kirim data ke view
        return view('staff.room-status.index', [
            'rooms' => $rooms,
        ]);
    }
}
