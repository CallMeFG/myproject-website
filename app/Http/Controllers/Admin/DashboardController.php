<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // --- BAGIAN 1: DATA KARTU STATISTIK & TABEL ---
        $totalRevenueThisMonth = Reservation::where('status', 'confirmed')->whereMonth('created_at', now()->month)->sum('total_price');
        $newBookingsToday = Reservation::whereDate('created_at', today())->count();
        $newCustomersThisMonth = User::where('role', 'user')->whereMonth('created_at', now()->month)->count();
        $totalRoomUnits = Room::sum('quantity');
        $latestBookings = Reservation::with(['user', 'room'])->latest()->take(5)->get();

        // --- BAGIAN 2: DATA GRAFIK TIPE KAMAR TERPOPULER ---
        $popularRoomsData = Reservation::with('room')
            ->select('room_id', DB::raw('count(*) as total_bookings'))
            ->groupBy('room_id')
            ->orderBy('total_bookings', 'desc')
            ->take(5)
            ->get();

        $popularRoomsChartLabels = $popularRoomsData->map(fn($item) => $item->room->type ?? 'Kamar Dihapus');
        $popularRoomsChartData = $popularRoomsData->map(fn($item) => $item->total_bookings);

        // --- BAGIAN 3: DATA GRAFIK TREN RESERVASI HARIAN (7 HARI TERAKHIR) ---
        $dailyReservationsData = Reservation::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $dailyChartLabels = $dailyReservationsData->map(fn($item) => Carbon::parse($item->date)->format('d M'));
        $dailyChartData = $dailyReservationsData->map(fn($item) => $item->count);

        // --- BAGIAN 4: MENGIRIM SEMUA DATA KE VIEW ---
        return view('admin.dashboard', [
            'totalRevenueThisMonth' => $totalRevenueThisMonth,
            'newBookingsToday' => $newBookingsToday,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'totalRoomUnits' => $totalRoomUnits,
            'latestBookings' => $latestBookings,
            'popularRoomsChartLabels' => $popularRoomsChartLabels,
            'popularRoomsChartData' => $popularRoomsChartData,
            'dailyChartLabels' => $dailyChartLabels,
            'dailyChartData' => $dailyChartData,
        ]);
    }
}
