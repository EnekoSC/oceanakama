<?php

namespace App\Models;

use App\Enums\EstadoReserva;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'curso_id',
        'estado',
        'metodo_pago',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'precio_pagado',
        'pagado_en',
    ];

    protected function casts(): array
    {
        return [
            'estado' => EstadoReserva::class,
            'precio_pagado' => 'decimal:2',
            'pagado_en' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}
