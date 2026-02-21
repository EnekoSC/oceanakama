<?php

namespace App\Enums;

enum EstadoResena: string
{
    case Pendiente = 'pendiente';
    case Aprobada = 'aprobada';
    case Rechazada = 'rechazada';

    public function label(): string
    {
        return match ($this) {
            self::Pendiente => __('Pendiente'),
            self::Aprobada => __('Aprobada'),
            self::Rechazada => __('Rechazada'),
        };
    }
}
