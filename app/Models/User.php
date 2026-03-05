<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    public function estadoAsientos()
    {
        return $this->hasMany(EstadoAsiento::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    // Comprueba si el usuario es administrador
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

}