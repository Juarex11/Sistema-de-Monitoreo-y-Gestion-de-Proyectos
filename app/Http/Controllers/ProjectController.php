<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $proyectos = Project::with('tareas')->latest()->get();
        return view('proyectos.index', compact('proyectos'));
    }

public function create()
{
    $usuarios = \App\Models\User::where('estado', 'activo')->get();

    return view('proyectos.create', compact('usuarios'));
}
public function showData($id)
{
    $proyecto = Project::with('responsable')->findOrFail($id);
    return response()->json($proyecto);
}
    public function store(Request $request)
{
    $request->validate([
        'nombre_proyecto' => 'required',
        'descripcion' => 'nullable|string',
        'responsable_id' => 'required|exists:users,id',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
        'presupuesto_asignado' => 'nullable|numeric',
        'lugar' => 'nullable|string|max:255',
        'tipo_proyecto' => 'nullable|string|max:100',
        'prioridad' => 'nullable|string|max:50',
    ]);

    // Crear proyecto
    $proyecto = Project::create([
        'codigo' => 'PRJ-' . time(),
        'nombre_proyecto' => $request->nombre_proyecto,
        'descripcion' => $request->descripcion,
        'estado' => 'pendiente',
        'creado_por' => Auth::id(),
        'responsable_id' => $request->responsable_id,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'presupuesto_asignado' => $request->presupuesto_asignado,
        'lugar' => $request->lugar,
        'tipo_proyecto' => $request->tipo_proyecto,
        'prioridad' => $request->prioridad,
    ]);

    // Crear tareas predeterminadas
    $tareasDefault = [
        'Inicio',
        'Planificación',
        'Ejecución',
        'Monitoreo y Control',
        'Cierre'
    ];

    foreach ($tareasDefault as $t) {
        ProjectTask::create([
            'proyecto_id' => $proyecto->id,
            'titulo' => $t,
            'estado' => 'pendiente'
        ]);
    }

    return redirect()->route('proyectos.index')
        ->with('success', 'Proyecto creado correctamente con sus tareas base.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'nombre_proyecto' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'responsable_id' => 'required|exists:users,id',
        'cliente_id' => 'nullable|integer',
        'estado' => 'nullable|string',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date',
        'fecha_cierre_real' => 'nullable|date',
        'presupuesto_asignado' => 'nullable|numeric',
        'presupuesto_ejecutado' => 'nullable|numeric',
        'lugar' => 'nullable|string|max:255',
        'tipo_proyecto' => 'nullable|string|max:100',
        'prioridad' => 'nullable|string|max:50',
    ]);

    $proyecto = Project::findOrFail($id);

    $proyecto->update([
        'nombre_proyecto' => $request->nombre_proyecto,
        'descripcion' => $request->descripcion,
        'responsable_id' => $request->responsable_id,
        'cliente_id' => $request->cliente_id,
        'estado' => $request->estado,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'fecha_cierre_real' => $request->fecha_cierre_real,
        'presupuesto_asignado' => $request->presupuesto_asignado,
        'presupuesto_ejecutado' => $request->presupuesto_ejecutado,
        'lugar' => $request->lugar,
        'tipo_proyecto' => $request->tipo_proyecto,
        'prioridad' => $request->prioridad,
        'actualizado_por' => auth()->id(),
    ]);

    return response()->json(['message' => 'Proyecto actualizado correctamente']);
}


public function destroy(Project $proyecto)
{
    try {
        // Eliminar tareas asociadas primero
        $proyecto->tareas()->delete();

        // Luego eliminar el proyecto
        $proyecto->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    } catch (\Exception $e) {
        return redirect()->route('proyectos.index')
            ->with('error', 'No se pudo eliminar el proyecto.');
    }
}

}
