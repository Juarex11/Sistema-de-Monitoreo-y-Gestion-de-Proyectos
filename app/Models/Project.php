<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'codigo',
        'nombre_proyecto',
        'descripcion',
        'responsable_id',
        'cliente_id',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'fecha_cierre_real',
        'presupuesto_asignado',
        'presupuesto_ejecutado',
        'lugar',
        'tipo_proyecto',
        'prioridad',
        'creado_por',
        'actualizado_por',
    ];

    public function tareas()
    {
        return $this->hasMany(ProjectTask::class, 'proyecto_id');
    }
    public function responsable()
{
    return $this->belongsTo(User::class, 'responsable_id');
}

}
