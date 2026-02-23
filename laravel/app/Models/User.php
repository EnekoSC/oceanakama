<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }
}
