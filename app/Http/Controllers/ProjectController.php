<?php
namespace App\Http\Controllers;
use App\Models\DocumentoProyecto;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\DB; 
use App\Models\Project;
use App\Models\Cotizacion;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProjectController extends Controller
{
public function index()
{
    $proyectos = Project::with('tareas')->latest()->get();

    foreach ($proyectos as $p) {
        $total = $p->tareas->count();
        $completadas = $p->tareas->where('estado', 'completada')->count(); // ← aquí
        $p->avance = $total > 0 ? round(($completadas / $total) * 100) : 0;
    }

    return view('proyectos.index', compact('proyectos'));
}


public function create()
{
    $usuarios = \App\Models\User::where('estado', 'activo')->get();

    return view('proyectos.create', compact('usuarios'));
}
public function showData($id)
{
    $proyecto = Project::with('responsable', 'creador', 'actualizador')->findOrFail($id);
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
public function addCliente(Request $request)
{
 $request->validate([
    'proyecto_id' => 'required|exists:proyectos,id', // en lugar de projects
    'cliente_id' => 'required|exists:clientes,id',
]);


    $proyecto = Project::findOrFail($request->proyecto_id);
    $proyecto->clientes()->syncWithoutDetaching($request->cliente_id);

    return back()->with('success', 'Cliente agregado al proyecto.');
}

public function removeCliente($proyectoId, $clienteId)
{
    $proyecto = Project::findOrFail($proyectoId);
    $proyecto->clientes()->detach($clienteId);

    return back()->with('success', 'Cliente removido del proyecto.');
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

public function addCotizacion(Request $request, Project $proyecto)
    {
        $request->validate([
            'cotizacion_id' => 'required|exists:cotizaciones,id'
        ]);

        // Verificar que no esté ya asociada
        if ($proyecto->cotizaciones()->where('cotizacion_id', $request->cotizacion_id)->exists()) {
            return back()->with('error', 'Esta cotización ya está asociada al proyecto');
        }

        // Asociar la cotización al proyecto
        $proyecto->cotizaciones()->attach($request->cotizacion_id);

        return back()->with('success', 'Cotización agregada al proyecto correctamente');
    }

    /**
     * Subir documento al proyecto
     */
public function subirDocumento(Request $request, Project $proyecto)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $nombreArchivo = time() . '_' . str_replace(' ', '_', $archivo->getClientOriginalName());
        
        $ruta = $archivo->storeAs('archivos_proyecto', $nombreArchivo, 'public');

        $documento = $proyecto->documentos()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'ruta' => $ruta,
            'tipo' => DocumentoProyecto::determinarTipo($extension),
            'extension' => $extension,
            'tamanio' => $archivo->getSize(),
            'subido_por' => Auth::id(),
        ]);

        return back()->with('success', 'Documento subido correctamente');
    }

    /**
     * Actualizar documento
     */
    public function actualizarDocumento(Request $request, DocumentoProyecto $documento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|max:10240',
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ];

        // Si hay nuevo archivo, reemplazar
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior
            if (Storage::disk('public')->exists($documento->ruta)) {
                Storage::disk('public')->delete($documento->ruta);
            }

            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = time() . '_' . str_replace(' ', '_', $archivo->getClientOriginalName());
            
            $ruta = $archivo->storeAs('archivos_proyecto', $nombreArchivo, 'public');

            $datos['ruta'] = $ruta;
            $datos['tipo'] = DocumentoProyecto::determinarTipo($extension);
            $datos['extension'] = $extension;
            $datos['tamanio'] = $archivo->getSize();
        }

        $documento->update($datos);

        return back()->with('success', 'Documento actualizado correctamente');
    }

    /**
     * Eliminar documento
     */
    public function eliminarDocumento(DocumentoProyecto $documento)
    {
        // Eliminar archivo físico
        if (Storage::disk('public')->exists($documento->ruta)) {
            Storage::disk('public')->delete($documento->ruta);
        }

        $documento->delete();

        return back()->with('success', 'Documento eliminado correctamente');
    }

/**
     * Remover una cotización del proyecto
     */
    public function removeCotizacion(Project $proyecto, Cotizacion $cotizacion)
    {
        $proyecto->cotizaciones()->detach($cotizacion->id);

        return back()->with('success', 'Cotización removida del proyecto');
    }


}
