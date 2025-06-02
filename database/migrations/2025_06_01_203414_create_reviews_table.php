<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang memberi review
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->string('image_path')->nullable(); // Foto untuk review (opsional)
            $table->timestamps();

            $table->unique(['recipe_id', 'user_id']); // Opsional: User hanya bisa review 1x per resep
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};