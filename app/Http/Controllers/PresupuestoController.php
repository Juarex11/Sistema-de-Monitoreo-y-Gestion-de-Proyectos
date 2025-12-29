<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;
use App\Models\Project;

class PresupuestoController extends Controller
{

     private function actualizarPresupuestoEjecutado($proyecto_id)
{
    $total = Project::find($proyecto_id)
        ->presupuestos()
        ->sum('precio');

    Project::where('id', $proyecto_id)->update([
        'presupuesto_ejecutado' => $total
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'proyecto_id' => 'required|exists:proyectos,id',
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'tipo_pago' => 'required',
        'fecha_inicio' => 'required|date',
    ]);

    // 🔹 calcular fecha_fin
    $fechaFin = $this->calcularFechaFin(
        $request->fecha_inicio,
        $request->tipo_pago
    );

    $presupuesto = Presupuesto::create([
        'proyecto_id' => $request->proyecto_id,
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'tipo_pago' => $request->tipo_pago,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $fechaFin,
        'estado' => 'activo'
    ]);

    $this->actualizarPresupuestoEjecutado($presupuesto->proyecto_id);

    return back()->with('success', 'Presupuesto agregado.');
}

private function calcularFechaFin($fecha, $tipoPago)
{
    $fecha = \Carbon\Carbon::parse($fecha);

    return match ($tipoPago) {
        'mensual' => $fecha->addMonth(),
        'bimestral' => $fecha->addMonths(2),
        'trimestral' => $fecha->addMonths(3),
        'semestral' => $fecha->addMonths(6),
        'anual' => $fecha->addYear(),
        default => null, // pago único
    };
}



  public function destroy($id)
{
    $presupuesto = Presupuesto::findOrFail($id);
    $proyecto_id = $presupuesto->proyecto_id;

    $presupuesto->delete();

    // 🔥 Actualizar total
    $this->actualizarPresupuestoEjecutado($proyecto_id);

    return back()->with('success', 'Presupuesto eliminado.');
}

   
}
