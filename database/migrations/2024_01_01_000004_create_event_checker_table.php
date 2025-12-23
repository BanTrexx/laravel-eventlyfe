<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2025_01_02_000000_create_event_checker_table.php
    public function up(): void
    {
        // Pastikan filenya bertanggal SETELAH file events
        Schema::create('event_checker', function (Blueprint $table) {
            $table->id();
            // Harus foreignId agar otomatis BigInteger
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('checker_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_checker');
    }
};
