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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Musik, Workshop
            $table->string('slug')->unique(); // Untuk URL yang SEO-friendly
            $table->string('icon')->nullable(); // Nama class Bootstrap Icon, misal: bi-music-note
            $table->string('color')->nullable(); // Nama class Bootstrap Icon, misal: bi-music-note
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
