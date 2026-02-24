<?php

namespace App\Enums;

enum EstadoReserva: string
{
    case Pendiente = 'pendiente';
    case PendientePago = 'pendiente_pago';
    case Confirmada = 'confirmada';
    case Cancelada = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::Pendiente => __('Pendiente de confirmación'),
            self::PendientePago => __('Pendiente de pago'),
            self::Confirmada => __('Confirmada'),
            self::Cancelada => __('Cancelada'),
        };
    }
}
