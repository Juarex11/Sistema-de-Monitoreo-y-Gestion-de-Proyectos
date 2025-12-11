<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $fillable = [
    'codigo',
    'tipo_cliente',
    'nombre_comercial',
    'razon_social',
    'ruc_dni',
    'representante',
    'telefono',
    'telefono_alt',
    'email',
    'email_alt',
    'direccion',
    'ciudad',
    'pais',
    'actividad',     
    'estado_cliente',
    'creado_por',
    'actualizado_por'
];

}
