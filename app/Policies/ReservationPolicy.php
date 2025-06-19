<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        // Izinkan user melihat reservasi jika user_id di reservasi sama dengan id user yg login
        return $user->id === $reservation->user_id;
    }
}
