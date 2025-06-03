<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;         // Import model Reservation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Untuk validasi

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for staff.
     */
    public function index()
    {
        // Ambil semua reservasi
        // Eager load relasi 'user' (pengguna yang memesan) dan 'room' (kamar yang dipesan)
        // Urutkan berdasarkan tanggal reservasi dibuat, yang paling baru di atas
        $reservations = Reservation::with(['user', 'room'])
            ->orderBy('created_at', 'desc')
            ->paginate(15); // Gunakan pagination

        // Kirim data ke view 'staff.reservations.index'
        return view('staff.reservations.index', compact('reservations'));
    }
    /**
     * Update the status of the specified reservation.
     */
    public function updateStatus(Request $request, Reservation $reservation) // $reservation di-inject via Route Model Binding
    {
        // 1. Validasi input status baru
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:Pending,Confirmed,Cancelled', // Sesuaikan dengan daftar status valid Anda
        ], [
            'status.required' => 'Status baru wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.reservations.index')
                ->with('error', 'Gagal memperbarui status: ' . $validator->errors()->first())
                ->withInput(); // Jika perlu input dipertahankan (meskipun di sini tidak banyak)
        }

        // 2. Update status reservasi
        try {
            $oldStatus = $reservation->status;
            $newStatus = $request->input('status');

            // Logika tambahan bisa dimasukkan di sini jika diperlukan
            // Misalnya, jika status diubah menjadi 'Confirmed', kirim email ke pengguna, dll.
            // Atau jika status diubah menjadi 'Cancelled', mungkin kembalikan kuantitas kamar. (Fitur lanjutan)

            $reservation->status = $newStatus;
            $reservation->save();

            return redirect()->route('staff.reservations.index')
                ->with('success', 'Status reservasi ID ' . $reservation->id . ' berhasil diperbarui dari "' . $oldStatus . '" menjadi "' . $newStatus . '".');
        } catch (\Exception $e) {
            \Log::error('Error updating reservation status: ' . $e->getMessage() . ' for reservation ID: ' . $reservation->id);
            return redirect()->route('staff.reservations.index')
                ->with('error', 'Terjadi kesalahan saat memperbarui status reservasi.');
        }
    }
}
