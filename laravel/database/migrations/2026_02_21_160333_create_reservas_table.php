<?php

use App\Enums\EstadoReserva;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('estado')->default(EstadoReserva::PendientePago->value);
            $table->string('metodo_pago')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->decimal('precio_pagado', 8, 2)->nullable();
            $table->timestamp('pagado_en')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
