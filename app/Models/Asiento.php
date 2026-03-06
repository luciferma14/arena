<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;

    protected $table = 'asientos';

    protected $fillable = [
        'sector_id',
        'fila',
        'numero',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function estadoAsientos()
    {
        return $this->hasMany(EstadoAsiento::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    // ============================================
    // MÉTODOS ÚTILES
    // ============================================

    public function nombreCompleto(): string
    {
        return "{$this->sector->nombre} - Fila {$this->fila} - Asiento {$this->numero}";
    }

    public function estaDisponibleParaEvento($eventoId): bool
    {
        return !$this->estadoAsientos()
            ->where('evento_id', $eventoId)
            ->exists();
    }

    public function estaReservadoParaEvento($eventoId): bool
    {
        return $this->estadoAsientos()
            ->where('evento_id', $eventoId)
            ->where('estado', 'bloqueado')
            ->exists();
    }

    public function estaVendidoParaEvento($eventoId): bool
    {
        return $this->estadoAsientos()
            ->where('evento_id', $eventoId)
            ->where('estado', 'vendido')
            ->exists();
    }

    public function estadoParaEvento($eventoId)
    {
        return $this->estadoAsientos()
            ->where('evento_id', $eventoId)
            ->first();
    }
}
