<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->json('titulo');
            $table->string('slug')->unique();
            $table->json('extracto')->nullable();
            $table->json('contenido');
            $table->string('imagen_url')->nullable();
            $table->string('estado')->default('borrador');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
