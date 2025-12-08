<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'perfil_empleados';

    protected $fillable = [
        'user_id','cargo','area','remuneracion','fecha_ingreso','turno',
        'celular','direccion','carrera','ciclo','fecha_nacimiento','observaciones'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
