<?php

namespace App\Models;

use App\Enums\EstadoPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'posts';

    public array $translatable = ['titulo', 'extracto', 'contenido'];

    protected $fillable = [
        'titulo',
        'slug',
        'extracto',
        'contenido',
        'imagen_url',
        'estado',
        'published_at',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'estado' => EstadoPost::class,
            'published_at' => 'datetime',
        ];
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
