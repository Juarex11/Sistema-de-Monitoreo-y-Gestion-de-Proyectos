<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'proyecto_id',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'objetivos',
        'capacidad_maxima',
        'ubicacion',
        'notas',
        'creado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación con proyecto principal
    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }

    // Relación con proyectos adicionales - ✨ CORREGIDO
    public function proyectos()
    {
        return $this->belongsToMany(
            Project::class,           // Modelo relacionado
            'equipo_proyecto',        // Tabla pivot
            'equipo_id',              // Foreign key de este modelo (Equipo)
            'proyecto_id'             // Foreign key del otro modelo (Project) ← IMPORTANTE
        )
        ->withTimestamps()
        ->withPivot('fecha_asignacion');
    }

    // Todos los miembros del equipo (líderes + miembros) - ✨ CORREGIDO
    public function miembros()
    {
        return $this->belongsToMany(
            User::class,
            'equipo_user',
            'equipo_id',
            'user_id'
        )
        ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
        ->withTimestamps()
        ->wherePivot('activo', true);
    }

    // Solo los líderes del equipo - ✨ CORREGIDO
    public function lideres()
    {
        return $this->belongsToMany(
            User::class,
            'equipo_user',
            'equipo_id',
            'user_id'
        )
        ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
        ->withTimestamps()
        ->wherePivot('rol_equipo', 'lider')
        ->wherePivot('activo', true);
    }

    // Solo los miembros regulares (sin líderes) - ✨ CORREGIDO
    public function miembrosRegulares()
    {
        return $this->belongsToMany(
            User::class,
            'equipo_user',
            'equipo_id',
            'user_id'
        )
        ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
        ->withTimestamps()
        ->wherePivot('rol_equipo', 'miembro')
        ->wherePivot('activo', true);
    }

    // Usuario que creó el equipo
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Verificar si un usuario es líder del equipo
    public function esLider($userId)
    {
        return $this->lideres()->where('users.id', $userId)->exists();
    }

    // Verificar si un usuario es miembro del equipo
    public function esMiembro($userId)
    {
        return $this->miembros()->where('users.id', $userId)->exists();
    }

    // Obtener cantidad de miembros activos
    public function getCantidadMiembrosAttribute()
    {
        return $this->miembros()->count();
    }

    // Verificar si el equipo está lleno
    public function estaLleno()
    {
        if (!$this->capacidad_maxima) {
            return false;
        }
        return $this->cantidad_miembros >= $this->capacidad_maxima;
    }

    // Scope para equipos activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    // Scope para equipos de un proyecto específico
    public function scopeDeProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }
}