<?php

namespace App\Enums;

enum NivelCurso: string
{
    case Principiante = 'principiante';
    case Intermedio = 'intermedio';
    case Avanzado = 'avanzado';
    case Profesional = 'profesional';

    public function label(): string
    {
        return match ($this) {
            self::Principiante => __('Principiante'),
            self::Intermedio => __('Intermedio'),
            self::Avanzado => __('Avanzado'),
            self::Profesional => __('Profesional'),
        };
    }
}
