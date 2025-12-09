<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $table = 'tareas'; // 👈 Importante
    protected $fillable = [
        'proyecto_id',
        'titulo',
        'descripcion',
        'estado'
    ];
}