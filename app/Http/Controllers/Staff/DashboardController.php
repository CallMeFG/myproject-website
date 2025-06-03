<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request) // Atau public function index()
    {
        // return "Admin Dashboard"; // Untuk tes awal
        return view('staff.dashboard'); // View akan dibuat nanti
    }
}
