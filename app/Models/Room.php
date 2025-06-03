<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'price',
        'description',
        'image',
        'quantity', // Tambahkan ini
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
