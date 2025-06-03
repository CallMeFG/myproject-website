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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key ke tabel users
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // Foreign Key ke tabel rooms
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('total_nights')->nullable(); // Akan dihitung
            $table->decimal('total_price', 10, 2)->nullable(); // Akan dihitung
            $table->string('status')->default('Pending'); // Misal: 'Pending', 'Confirmed', 'Cancelled', 'Completed'
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};