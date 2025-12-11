<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $fillable = [
        'proyecto_id',
        'nombre',
        'precio'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }
}
