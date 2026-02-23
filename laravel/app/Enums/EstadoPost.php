<?php

namespace App\Enums;

enum EstadoPost: string
{
    case Borrador = 'borrador';
    case Publicado = 'publicado';
    case Archivado = 'archivado';

    public function label(): string
    {
        return match ($this) {
            self::Borrador => __('Borrador'),
            self::Publicado => __('Publicado'),
            self::Archivado => __('Archivado'),
        };
    }
}
