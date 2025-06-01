<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('ingredients'); // Menyimpan ingredients sebagai JSON
            $table->text('directions');
            $table->string('cooking_duration')->nullable();
            $table->string('image_path')->nullable(); // Path ke gambar
            // $table->json('categories')->nullable(); // Jika kategori disimpan sebagai JSON
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};