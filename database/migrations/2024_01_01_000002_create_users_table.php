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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Relasi ke Role
            $table->foreignId('role_id')->constrained('roles');

            // Relasi Checker ke Organizer (Self-referencing)
            // Jika role = checker, maka field ini berisi ID Organizer-nya
            $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('cascade');

            // Data Profile Organizer (Bisa dikembangkan ke tabel terpisah jika data sangat banyak)
            $table->text('bio')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('profile_picture')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
