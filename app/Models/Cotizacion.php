<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'codigo',
        'cliente_id',
        'descripcion',
        'total',
        'estado',
    ];

    public function items()
    {
        return $this->hasMany(CotizacionItem::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,
            'cotizacion_proyecto',
            'cotizacion_id',
            'proyecto_id'
        )->withTimestamps();
    }

    // Calcular total automáticamente desde los items
    public function calcularTotal()
    {
        return $this->items->sum(function($item) {
            return $item->precioTotal();
        });
    }
}