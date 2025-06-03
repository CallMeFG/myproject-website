<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Untuk validasi manual
use Carbon\Carbon; // Untuk manipulasi tanggal

class ReservationController extends Controller
{
    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request, Room $room) // $room akan otomatis di-inject oleh Laravel
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ], [
            'check_in_date.required' => 'Tanggal check-in wajib diisi.',
            'check_in_date.date' => 'Format tanggal check-in tidak valid.',
            'check_in_date.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out_date.required' => 'Tanggal check-out wajib diisi.',
            'check_out_date.date' => 'Format tanggal check-out tidak valid.',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $checkInDate = Carbon::parse($request->input('check_in_date'));
        $checkOutDate = Carbon::parse($request->input('check_out_date'));

        // 2. Pengecekan Ketersediaan Kamar (Logika Minimal - Pilihan A)
        $availableQuantity = $room->quantity;

        // Hitung reservasi aktif yang tumpang tindih untuk tipe kamar ini
        $conflictingReservations = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['Pending', 'Menunggu Konfirmasi', 'Confirmed', 'Dikonfirmasi']) // Status yang dianggap "aktif"
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    // Reservasi dimulai di dalam periode yang diminta
                    $q->where('check_in_date', '>=', $checkInDate->toDateString())
                        ->where('check_in_date', '<', $checkOutDate->toDateString());
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Reservasi berakhir di dalam periode yang diminta
                    $q->where('check_out_date', '>', $checkInDate->toDateString())
                        ->where('check_out_date', '<=', $checkOutDate->toDateString());
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Reservasi mencakup seluruh periode yang diminta
                    $q->where('check_in_date', '<', $checkInDate->toDateString())
                        ->where('check_out_date', '>', $checkOutDate->toDateString());
                });
            })
            ->count();

        if ($conflictingReservations >= $availableQuantity) {
            return redirect()->back()
                ->with('error', 'Maaf, kamar tidak tersedia untuk tanggal yang Anda pilih.')
                ->withInput();
        }

        // 3. Perhitungan Jumlah Malam & Total Harga
        // Carbon::diffInDays akan menghitung selisih hari penuh.
        // Gunakan diffInDays dengan parameter absolut true secara eksplisit
        $numberOfNights = $checkOutDate->diffInDays($checkInDate, true);

        // Kondisi if ini tetap baik sebagai pengaman,
        // meskipun dengan abs=true dan validasi, $numberOfNights seharusnya > 0
        if ($numberOfNights <= 0) { 
            $numberOfNights = 1; // Minimal 1 malam
        }
        $totalPrice = $room->price * $numberOfNights;

        // 4. Simpan Reservasi Baru
        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::id(); // ID pengguna yang sedang login
            $reservation->room_id = $room->id;
            $reservation->check_in_date = $checkInDate->toDateString();
            $reservation->check_out_date = $checkOutDate->toDateString();
            $reservation->total_nights = $numberOfNights;
            $reservation->total_price = $totalPrice;
            $reservation->status = 'Pending'; // Sesuai permintaan: "menunggu konfirmasi dari staff/admin"
            $reservation->save();

            // 5. Redirect Pengguna dengan Pesan Sukses
            return redirect()->route('dashboard') // Atau ke halaman lain yang sesuai
                ->with('success', 'Reservasi Anda untuk ' . $room->type . ' telah diterima dan sedang menunggu konfirmasi.');
        } catch (\Exception $e) {
            // Tangani error jika gagal menyimpan ke database
            // Log errornya untuk debug: \Log::error($e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses reservasi Anda. Silakan coba lagi.')
                ->withInput();
        }
    }
}
