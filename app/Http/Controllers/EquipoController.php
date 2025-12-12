<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with(['proyecto', 'lideres', 'miembros', 'creador'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $proyectos = Project::where('estado', '!=', 'cancelado')->get();
        $usuarios = User::where('estado', 'activo')->get();
        $lideresDisponibles = User::where('estado', 'activo')
            ->whereIn('rol', ['administrador', 'supervisor'])
            ->get();
        
        return view('equipos.create', compact('proyectos', 'usuarios', 'lideresDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'estado' => 'required|in:activo,inactivo,finalizado',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'objetivos' => 'nullable|string',
            'capacidad_maxima' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string',
            'lideres' => 'required|array|min:1',
            'lideres.*' => 'exists:users,id',
            'miembros' => 'nullable|array',
            'miembros.*' => 'exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Crear equipo
            $equipo = Equipo::create([
                'codigo' => 'EQ-' . date('Ymd') . '-' . time(),
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'proyecto_id' => $request->proyecto_id,
                'estado' => $request->estado,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'objetivos' => $request->objetivos,
                'capacidad_maxima' => $request->capacidad_maxima,
                'ubicacion' => $request->ubicacion,
                'notas' => $request->notas,
                'creado_por' => Auth::id(),
            ]);

            // Asignar líderes
            foreach ($request->lideres as $liderId) {
                $equipo->miembros()->attach($liderId, [
                    'rol_equipo' => 'lider',
                    'fecha_asignacion' => now(),
                    'activo' => true,
                ]);
            }

            // Asignar miembros regulares
            if ($request->has('miembros')) {
                foreach ($request->miembros as $miembroId) {
                    // Evitar duplicados si un líder también está en miembros
                    if (!in_array($miembroId, $request->lideres)) {
                        $equipo->miembros()->attach($miembroId, [
                            'rol_equipo' => 'miembro',
                            'fecha_asignacion' => now(),
                            'activo' => true,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('equipos.index')
                ->with('success', 'Equipo creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el equipo: ' . $e->getMessage());
        }
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['proyecto', 'lideres', 'miembrosRegulares', 'creador', 'proyectos']);
        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $proyectos = Project::where('estado', '!=', 'cancelado')->get();
        $usuarios = User::where('estado', 'activo')->get();
        $lideresDisponibles = User::where('estado', 'activo')
            ->whereIn('rol', ['administrador', 'supervisor'])
            ->get();
        
        return view('equipos.edit', compact('equipo', 'proyectos', 'usuarios', 'lideresDisponibles'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'estado' => 'required|in:activo,inactivo,finalizado',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'objetivos' => 'nullable|string',
            'capacidad_maxima' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string',
        ]);

        $equipo->update($request->all());

        return redirect()->route('equipos.show', $equipo)
            ->with('success', 'Equipo actualizado exitosamente');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado exitosamente');
    }

    // Agregar miembro al equipo
    public function agregarMiembro(Request $request, Equipo $equipo)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rol_equipo' => 'required|in:lider,miembro',
        ]);

        if ($equipo->estaLleno()) {
            return back()->with('error', 'El equipo ha alcanzado su capacidad máxima');
        }

        if ($equipo->esMiembro($request->user_id)) {
            return back()->with('error', 'Este usuario ya es miembro del equipo');
        }

        $equipo->miembros()->attach($request->user_id, [
            'rol_equipo' => $request->rol_equipo,
            'fecha_asignacion' => now(),
            'activo' => true,
        ]);

        return back()->with('success', 'Miembro agregado exitosamente');
    }

    // Remover miembro del equipo
    public function removerMiembro(Equipo $equipo, User $user)
    {
        $equipo->miembros()->detach($user->id);

        return back()->with('success', 'Miembro removido del equipo');
    }

    // Cambiar rol de miembro
    public function cambiarRol(Request $request, Equipo $equipo, User $user)
    {
        $request->validate([
            'rol_equipo' => 'required|in:lider,miembro',
        ]);

        $equipo->miembros()->updateExistingPivot($user->id, [
            'rol_equipo' => $request->rol_equipo,
        ]);

        return back()->with('success', 'Rol actualizado exitosamente');
    }
}