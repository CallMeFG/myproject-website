<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Import model dan Carbon
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Data untuk Kartu Statistik Operasional
        $pendingReservationsCount = Reservation::whereIn('status', ['Pending', 'Menunggu Konfirmasi'])->count();

        $checkInsTodayCount = Reservation::where('status', 'Dikonfirmasi')
            ->whereDate('check_in_date', Carbon::today())
            ->count();

        $checkOutsTodayCount = Reservation::where('status', 'Dikonfirmasi')
            ->whereDate('check_out_date', Carbon::today())
            ->count();

        // Data untuk Tabel "Reservasi Perlu Tindakan"
        $reservationsNeedingAction = Reservation::with(['user', 'room'])
            ->whereIn('status', ['Pending', 'Menunggu Konfirmasi'])
            ->latest()
            ->take(10)
            ->get();

        return view('staff.dashboard', [
            'pendingReservationsCount' => $pendingReservationsCount,
            'checkInsTodayCount' => $checkInsTodayCount,
            'checkOutsTodayCount' => $checkOutsTodayCount,
            'reservationsNeedingAction' => $reservationsNeedingAction,
        ]);
    }
}
