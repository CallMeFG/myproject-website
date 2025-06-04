<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request; // PASTIKAN BARIS INI ADA DAN TIDAK DIKOMENTARI
use Carbon\Carbon; // Import Carbon untuk validasi tanggal jika diperlukan

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for the admin.
     */
    public function index(Request $request)
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
            // Validasi sederhana untuk format tanggal (YYYY-MM-DD)
            // Anda bisa menambahkan validasi yang lebih ketat jika perlu
            try {
                $validDateFrom = Carbon::createFromFormat('Y-m-d', $dateFrom)->startOfDay();
                $validDateTo = Carbon::createFromFormat('Y-m-d', $dateTo)->endOfDay();

                if ($validDateTo->gte($validDateFrom)) { // Pastikan tanggal_sampai >= tanggal_dari
                    $reservationsQuery->whereBetween('check_in_date', [$validDateFrom, $validDateTo]);
                } else {
                    // Opsi: berikan pesan error jika rentang tanggal tidak valid
                    // atau abaikan filter tanggal. Untuk sekarang, kita abaikan jika tidak valid.
                }
            } catch (\Exception $e) {
                // Abaikan filter tanggal jika format tidak valid
            }
        }

        $reservations = $reservationsQuery->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString(); // Penting agar semua parameter filter terbawa di pagination

        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'statuses' => $statuses,
            'selectedStatus' => $selectedStatus,
            'dateFrom' => $dateFrom, // Kirim tanggal filter ke view
            'dateTo' => $dateTo,     // Kirim tanggal filter ke view
        ]);
    }
    /**
     * Display the specified reservation detail for the admin.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // Eager load relasi user dan room jika belum otomatis ter-load atau untuk memastikan
        // Meskipun Route Model Binding sudah menyediakan $reservation,
        // eager loading di sini bisa memastikan relasi ada jika akan sering diakses.
        // Namun, karena kita sudah pakai with() di index, mungkin tidak perlu load lagi di sini jika objeknya dari sana.
        // Jika objek $reservation langsung dari query (misal di-refresh), load diperlukan.
        // Untuk keamanan, kita bisa load lagi:
        $reservation->load(['user', 'room']);

        return view('admin.reservations.show', compact('reservation'));
    }
    // ... (metode lainnya jika ada) ...
}