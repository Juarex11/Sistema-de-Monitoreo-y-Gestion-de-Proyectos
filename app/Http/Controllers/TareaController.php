<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
   public function store(Request $request)
{
    Tarea::create([
        'proyecto_id' => $request->proyecto_id,
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'estado' => 'pendiente'
    ]);

    return back()->with('success', 'Tarea agregada');
}


  public function updateEstado(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|in:pendiente,en_progreso,completa'
    ]);

    $tarea = Tarea::findOrFail($id);
    $tarea->estado = $request->estado;
    $tarea->save();

    return back();
}

public function update(Request $request, $id)
{
    $tarea = Tarea::findOrFail($id);

    $tarea->update([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion
    ]);

    return back();
}

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return back()->with('success', 'Tarea eliminada');
    }
}
