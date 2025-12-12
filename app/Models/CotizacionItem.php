<?php
// app/Models/CotizacionItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionItem extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $table = 'cotizacion_items';

    protected $fillable = [
        'cotizacion_id',
        'titulo',
        'descripcion',
        'precio',
        'tipo_pago',      // ← Cambiar de 'periodicidad' a 'tipo_pago'
        'aplica_igv',     // ← Cambiar de 'igv' a 'aplica_igv'
        'total'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function precioTotal()
    {
        if ($this->aplica_igv) {
            return $this->precio * 1.18;
        }
        return $this->precio;
    }
}
