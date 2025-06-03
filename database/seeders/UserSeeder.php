<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Support\Facades\Hash; // Pastikan ini di-import

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user lama jika ada dan ingin membuat ulang (hati-hati jika ada data penting)
        // User::truncate(); 

        User::firstOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name' => 'Admin CallMeHotel',
                'password' => Hash::make('password'), // Ganti dengan password yang aman nanti
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@example.test'],
            [
                'name' => 'Staff CallMeHotel',
                'password' => Hash::make('password'), // Ganti dengan password yang aman nanti
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@example.test'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'), // Ganti dengan password yang aman nanti
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
