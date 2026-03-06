<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eventos';

    protected $fillable = [
        'nombre',
        'descripcion_corta',
        'descripcion_larga',
        'poster_url',
        'fecha',
        'hora',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora'  => 'datetime:H:i',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    public function precios()
    {
        return $this->hasMany(Precio::class);
    }

    public function sectores()
    {
        return $this->belongsToMany(Sector::class, 'precios')
                    ->withPivot('precio', 'disponible')
                    ->withTimestamps();
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

    public function sectoresDisponibles()
    {
        return $this->sectores()
            ->where('sectores.activo', true)
            ->wherePivot('disponible', true)
            ->get();
    }

    public function precioDelSector($sectorId)
    {
        return $this->precios()
            ->where('sector_id', $sectorId)
            ->first();
    }

    public function sectorEstaDisponible($sectorId): bool
    {
        return $this->precios()
            ->where('sector_id', $sectorId)
            ->where('disponible', true)
            ->exists();
    }

    public function totalAsientosDisponibles(): int
    {
        $sectoresDisponibles = $this->sectoresDisponibles()->pluck('id');
        $totalAsientos = Asiento::whereIn('sector_id', $sectoresDisponibles)->count();
        $asientosOcupados = $this->estadoAsientos()->count();
        return $totalAsientos - $asientosOcupados;
    }

    public function totalEntradasVendidas(): int
    {
        return $this->entradas()->count();
    }

    public function yaPaso(): bool
    {
        return $this->fecha->isPast();
    }

    public function esHoy(): bool
    {
        return $this->fecha->isToday();
    }

    public function scopeFuturos($query)
    {
        return $query->where('fecha', '>=', now()->toDateString())
                     ->orderBy('fecha', 'asc');
    }

    public function scopePasados($query)
    {
        return $query->where('fecha', '<', now()->toDateString())
                     ->orderBy('fecha', 'desc');
    }

    public function scopeDelMes($query, $mes, $anio)
    {
        return $query->whereMonth('fecha', $mes)
                     ->whereYear('fecha', $anio);
    }
}
