<?php

use App\Enums\EstadoCurso;
use App\Enums\NivelCurso;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->json('nombre');
            $table->string('slug')->unique();
            $table->string('nivel')->default(NivelCurso::Principiante->value);
            $table->string('duracion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->string('certificacion_ssi')->nullable();
            $table->unsignedInteger('plazas_max');
            $table->unsignedInteger('plazas_disponibles');
            $table->string('estado')->default(EstadoCurso::Proximo->value);
            $table->json('descripcion')->nullable();
            $table->string('imagen_url')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
