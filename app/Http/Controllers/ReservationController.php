<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <-- Ganti Validator dengan Log
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini untuk otorisasi

class ReservationController extends Controller
{
    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request, Room $room)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'booking_name' => 'required|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ], [
            'booking_name.required' => 'Nama pemesan wajib diisi.',
            'check_in_date.required' => 'Tanggal check-in wajib diisi.',
            'check_in_date.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out_date.required' => 'Tanggal check-out wajib diisi.',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',
        ]);

        $checkInDate = Carbon::parse($validated['check_in_date']);
        $checkOutDate = Carbon::parse($validated['check_out_date']);

        // 2. Pengecekan Ketersediaan Kamar
        $availableQuantity = $room->quantity;
        $conflictingReservations = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['Pending', 'Confirmed']) // Status yang dianggap "aktif"
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    $q->where('check_in_date', '>=', $checkInDate->toDateString())
                        ->where('check_in_date', '<', $checkOutDate->toDateString());
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    $q->where('check_out_date', '>', $checkInDate->toDateString())
                        ->where('check_out_date', '<=', $checkOutDate->toDateString());
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
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

        // 3. Perhitungan Jumlah Malam & Total Harga (Server-side)
        $numberOfNights = abs($checkInDate->diffInDays($checkOutDate));
        $totalPrice = $room->price * $numberOfNights;

        // 4. Simpan Reservasi Baru
        try {
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'booking_name' => $validated['booking_name'], // Simpan nama pemesan
                'room_id' => $room->id,
                'check_in_date' => $checkInDate->toDateString(),
                'check_out_date' => $checkOutDate->toDateString(),
                'total_nights' => $numberOfNights,
                'total_price' => $totalPrice,
                'status' => 'Pending',
            ]);

            // 5. Redirect ke Halaman Sukses dengan ID Reservasi
            return redirect()->route('reservations.success', $reservation->id)
                ->with('success', 'Permintaan reservasi Anda berhasil dikirim!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan reservasi: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses reservasi Anda. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Menampilkan halaman sukses/bukti transaksi setelah reservasi dibuat.
     */
    public function success(Reservation $reservation)
    {
        // Pastikan hanya pengguna yang membuat reservasi yang bisa melihat halaman ini
        if (Gate::denies('view', $reservation)) {
            abort(403);
        }

        return view('reservations.success', [
            'reservation' => $reservation
        ]);
    }
}
