<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_events_table.php
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Relasi ke Organizer
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');

            // TAMBAHKAN INI: Relasi ke Kategori
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->decimal('price', 12, 0);
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->integer('quota')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
