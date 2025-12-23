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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

            // Data Tiket & Keamanan
            // ticket_code harus unik dan acak untuk mencegah manipulasi ID (Cybersecurity)
            $table->string('ticket_code')->unique();
            $table->decimal('price', 12, 0);

            // Status Pembayaran: pending, paid, cancelled
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('payment_proof')->nullable(); // Path foto bukti transfer

            // Logika Scanner (Checker)
            $table->boolean('is_scanned')->default(false);
            $table->timestamp('scanned_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
