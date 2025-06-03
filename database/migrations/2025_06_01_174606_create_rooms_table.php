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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->string('type'); // Misal: 'Single', 'Double', 'Suite'
            $table->decimal('price', 10, 2); // Harga per malam
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Path ke gambar kamar
            // $table->boolean('availability_status')->default(true); // Kita akan kelola ini secara dinamis nanti
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
