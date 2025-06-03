<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Menambahkan kolom quantity setelah kolom 'image' (atau sesuaikan posisinya jika perlu)
            // Kita beri nilai default misalnya 5, asumsi setiap tipe kamar minimal ada 5 unit.
            // Anda bisa sesuaikan nilai default ini.
            $table->integer('quantity')->default(5)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
