<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectores';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    public function asientos()
    {
        return $this->hasMany(Asiento::class);
    }

    public function precios()
    {
        return $this->hasMany(Precio::class);
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'precios')
                    ->withPivot('precio', 'disponible')
                    ->withTimestamps();
    }

    // ============================================
    // MÉTODOS ÚTILES
    // ============================================

    public function estaActivo(): bool
    {
        return $this->activo;
    }

    public function totalAsientos(): int
    {
        return $this->asientos()->count();
    }

    public function asientosDisponiblesParaEvento($eventoId)
    {
        return $this->asientos()
            ->whereDoesntHave('estadoAsientos', function ($query) use ($eventoId) {
                $query->where('evento_id', $eventoId);
            })
            ->get();
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
