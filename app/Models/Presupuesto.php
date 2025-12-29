<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $fillable = [
        'proyecto_id',
        'nombre',
        'precio',
        'tipo_pago',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }
}
