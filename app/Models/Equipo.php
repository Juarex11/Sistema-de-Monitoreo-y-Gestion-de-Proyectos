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

    // Relación con proyectos adicionales
    public function proyectos()
    {
        return $this->belongsToMany(Project::class, 'equipo_proyecto')
                    ->withTimestamps()
                    ->withPivot('fecha_asignacion');
    }

    // Todos los miembros del equipo (líderes + miembros)
    public function miembros()
    {
        return $this->belongsToMany(User::class, 'equipo_user')
                    ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
                    ->withTimestamps()
                    ->where('equipo_user.activo', true);
    }

    // Solo los líderes del equipo
    public function lideres()
    {
        return $this->belongsToMany(User::class, 'equipo_user')
                    ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
                    ->withTimestamps()
                    ->where('equipo_user.rol_equipo', 'lider')
                    ->where('equipo_user.activo', true);
    }

    // Solo los miembros regulares (sin líderes)
    public function miembrosRegulares()
    {
        return $this->belongsToMany(User::class, 'equipo_user')
                    ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
                    ->withTimestamps()
                    ->where('equipo_user.rol_equipo', 'miembro')
                    ->where('equipo_user.activo', true);
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