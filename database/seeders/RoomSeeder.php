<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room; // Jangan lupa tambahkan ini
use Illuminate\Support\Facades\DB; // Bisa juga pakai DB Facade

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'type' => 'Kamar Single Standard',
                'price' => 350000.00,
                'description' => 'Kamar nyaman untuk satu orang dengan fasilitas standar. Cocok untuk pelancong solo.',
                'image' => 'https://via.placeholder.com/640x480.png/007bff?text=Single+Standard',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Kamar Double Deluxe',
                'price' => 650000.00,
                'description' => 'Kamar luas dengan tempat tidur double atau twin, pemandangan kota, dan fasilitas mewah.',
                'image' => 'https://via.placeholder.com/640x480.png/28a745?text=Double+Deluxe',
                'quantity' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Suite Keluarga',
                'price' => 1200000.00,
                'description' => 'Suite dengan dua kamar tidur, ruang tamu terpisah, cocok untuk keluarga yang berlibur.',
                'image' => 'https://via.placeholder.com/640x480.png/ffc107?text=Suite+Keluarga',
                'quantity' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Kamar Ekonomi Twin',
                'price' => 280000.00,
                'description' => 'Pilihan hemat dengan dua tempat tidur single, fasilitas dasar, bersih dan nyaman.',
                'image' => 'https://via.placeholder.com/640x480.png/6c757d?text=Ekonomi+Twin',
                'quantity' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke tabel rooms
        foreach ($rooms as $roomData) {
            Room::create($roomData);
            // atau jika tidak menggunakan $fillable di model, bisa pakai:
            // DB::table('rooms')->insert($roomData);
        }
    }
}
