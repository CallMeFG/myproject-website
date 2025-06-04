<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // TAMBAHKAN INI
use Illuminate\Support\Facades\Storage; // TAMBAHKAN INI

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
    /**
     * Accessor untuk mendapatkan URL gambar yang benar.
     * Akan dipanggil dengan $room->image_url di Blade.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // Cek apakah ini URL absolut (dari data lama atau placeholder eksternal)
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }
            // Jika bukan URL absolut, berarti ini adalah path relatif di storage
            // Gunakan Storage::disk('public')->url() untuk mendapatkan URL publik yang benar
            return Storage::disk('public')->url($this->image);
        }

        // Jika tidak ada gambar, kembalikan URL placeholder default
        return 'https://via.placeholder.com/800x450.png/003366?text=No+Image+Available'; // Sedikit ubah teks placeholder
    }
}
