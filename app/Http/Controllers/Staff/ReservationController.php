<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;         // Import model Reservation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Untuk validasi
use Carbon\Carbon; // Import Carbon
class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for staff.
     */
    public function index(Request $request) // Pastikan Request $request ada di sini
    {
        $statuses = ['Pending', 'Confirmed', 'Cancelled'];
        $selectedStatus = $request->query('status');

        // Ambil input tanggal
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $reservationsQuery = Reservation::with(['user', 'room']);

        // Terapkan filter status jika ada dan valid
        if (in_array($selectedStatus, $statuses)) {
            $reservationsQuery->where('status', $selectedStatus);
        }

        // Terapkan filter tanggal jika kedua tanggal diisi
        if ($dateFrom && $dateTo) {
            try {
                $validDateFrom = Carbon::createFromFormat('Y-m-d', $dateFrom)->startOfDay();
                $validDateTo = Carbon::createFromFormat('Y-m-d', $dateTo)->endOfDay();

                if ($validDateTo->gte($validDateFrom)) { // Pastikan tanggal_sampai >= tanggal_dari
                    $reservationsQuery->whereBetween('check_in_date', [$validDateFrom, $validDateTo]);
                }
            } catch (\Exception $e) {
                // Abaikan filter tanggal jika format tidak valid
            }
        }

        $reservations = $reservationsQuery->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString(); // Penting agar semua parameter filter terbawa di pagination

        return view('staff.reservations.index', [
            'reservations' => $reservations,
            'statuses' => $statuses,
            'selectedStatus' => $selectedStatus,
            'dateFrom' => $dateFrom, // Kirim tanggal filter ke view
            'dateTo' => $dateTo,     // Kirim tanggal filter ke view
        ]);
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
    /**
     * Display the specified reservation detail for staff.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // Eager load relasi user dan room untuk memastikan data tersedia di view
        $reservation->load(['user', 'room']);

        return view('staff.reservations.show', compact('reservation'));
    }
}
