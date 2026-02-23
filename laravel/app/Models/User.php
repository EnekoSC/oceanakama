<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, Billable;

    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'telefono',
        'certificacion',
        'num_inmersiones',
        'seguro_buceo',
        'idioma_pref',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'seguro_buceo' => 'boolean',
            'num_inmersiones' => 'integer',
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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
