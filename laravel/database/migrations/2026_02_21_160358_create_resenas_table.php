<?php

use App\Enums\EstadoResena;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->text('texto');
            $table->unsignedTinyInteger('puntuacion');
            $table->string('estado')->default(EstadoResena::Pendiente->value);
            $table->timestamps();

            $table->unique(['user_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
