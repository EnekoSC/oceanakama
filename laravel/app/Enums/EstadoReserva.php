<?php

namespace App\Enums;

enum EstadoReserva: string
{
    case PendientePago = 'pendiente_pago';
    case Confirmada = 'confirmada';
    case Cancelada = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::PendientePago => __('Pendiente de pago'),
            self::Confirmada => __('Confirmada'),
            self::Cancelada => __('Cancelada'),
        };
    }
}
