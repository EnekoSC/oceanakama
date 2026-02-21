<?php

namespace App\Enums;

enum EstadoCurso: string
{
    case Proximo = 'proximo';
    case EnCurso = 'en_curso';
    case Completado = 'completado';
    case Cancelado = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::Proximo => __('Próximo'),
            self::EnCurso => __('En curso'),
            self::Completado => __('Completado'),
            self::Cancelado => __('Cancelado'),
        };
    }
}
