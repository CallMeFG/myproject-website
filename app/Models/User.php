<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Pastikan ini ada atau tambahkan

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'user', 'staff', 'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function reservations(): HasMany // Tambahkan tipe return HasMany
    {
        return $this->hasMany(Reservation::class, 'user_id', 'id');
        // Parameter kedua ('user_id') adalah foreign key di tabel reservations
        // Parameter ketiga ('id') adalah local key di tabel users
        // Jika Anda mengikuti konvensi Laravel (user_id di tabel reservations),
        // maka cukup: return $this->hasMany(Reservation::class);
    }
}
