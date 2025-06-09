<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Menampilkan dashboard pengguna dengan riwayat reservasi yang bisa difilter dan diurutkan.
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Memulai query dasar untuk reservasi milik pengguna yang sedang login
        $query = $user->reservations()->with('room');

        // 1. Menerapkan Filter berdasarkan Status
        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 2. Menerapkan Logika Urutkan (Sort)
        $sortOrder = $request->input('sort', 'created_at_desc'); // Default urutan adalah berdasarkan tanggal pesan terbaru

        switch ($sortOrder) {
            case 'check_in_asc':
                $query->orderBy('check_in_date', 'asc');
                break;
            case 'check_in_desc':
                $query->orderBy('check_in_date', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default: // created_at_desc
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 3. Mengambil hasil dengan pagination (10 data per halaman)
        $reservations = $query->paginate(10);

        // 4. Mengirim data ke view
        return view('customer.dashboard', [
            'reservations' => $reservations
        ]);
    }
}
