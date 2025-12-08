<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilEmpleado extends Model
{
    // 👇 ESTA LÍNEA FALTABA
    protected $table = 'perfil_empleados';

    protected $fillable = [
        'user_id', 'cargo', 'area', 'remuneracion', 'fecha_ingreso',
        'turno', 'celular', 'direccion', 'carrera', 'ciclo',
        'fecha_nacimiento', 'observaciones'
    ];

    // 👇 AGREGAR CAST PARA FECHA
    protected $casts = [
        'fecha_nacimiento' => 'date:Y-m-d',
        'fecha_ingreso' =>'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}