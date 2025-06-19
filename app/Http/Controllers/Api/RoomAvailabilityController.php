<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomAvailabilityController extends Controller
{
    public function check(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $checkInDate = Carbon::parse($validated['check_in_date']);
        $checkOutDate = Carbon::parse($validated['check_out_date']);

        // Logika ini sama dengan di ReservationController
        $conflictingReservations = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['Pending', 'Confirmed'])
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

        $availableUnits = $room->quantity - $conflictingReservations;

        return response()->json([
            'available_units' => $availableUnits < 0 ? 0 : $availableUnits,
        ]);
    }
}
