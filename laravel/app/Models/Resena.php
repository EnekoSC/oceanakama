<?php

namespace App\Models;

use App\Enums\EstadoResena;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resenas';

    protected $fillable = [
        'user_id',
        'curso_id',
        'texto',
        'puntuacion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'estado' => EstadoResena::class,
            'puntuacion' => 'integer',
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
