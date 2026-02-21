<?php

namespace App\Models;

use App\Enums\EstadoCurso;
use App\Enums\NivelCurso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Curso extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'cursos';

    public array $translatable = ['nombre', 'descripcion'];

    protected $fillable = [
        'nombre',
        'slug',
        'nivel',
        'duracion',
        'precio',
        'certificacion_ssi',
        'plazas_max',
        'plazas_disponibles',
        'estado',
        'descripcion',
        'imagen_url',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected function casts(): array
    {
        return [
            'nivel' => NivelCurso::class,
            'estado' => EstadoCurso::class,
            'precio' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }

    public function tieneDisponibilidad(): bool
    {
        return $this->plazas_disponibles > 0;
    }
}
