<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerfilEmpleado;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index()
    {
        $usuarios = User::with('perfil')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function info($id)
    {
        $usuario = User::with('perfil')->findOrFail($id);
        return view('admin.usuarios.info', compact('usuario'));
    }

  public function edit($id)
{
    $usuario = User::with('perfil')->findOrFail($id);
    return view('admin.usuarios.edit', compact('usuario'));
}


public function update(Request $request, $id)
{
    $usuario = User::findOrFail($id);

    // Actualizar datos del usuario
    $usuario->update([
        'name' => $request->name,
        'email' => $request->email,
        'rol' => $request->rol
    ]);

    // Datos del perfil (TODOS los que realmente existen)
    $perfilData = $request->only([
        'cargo',
        'area',
        'remuneracion',
        'fecha_ingreso',
        'turno',
        'celular',
        'direccion',
        'carrera',
        'ciclo',
        'fecha_nacimiento',
        'observaciones'
    ]);

    PerfilEmpleado::updateOrCreate(
        ['user_id' => $id],
        $perfilData
    );

    return back()->with('success', 'Datos actualizados correctamente');
}



   public function delete($id)
{
    // No permitir borrar al usuario principal ID 1
    if ($id == 1) {
        return back()->with('error', 'El usuario administrador principal no puede ser eliminado.');
    }

    // Eliminar perfil asociado
    PerfilEmpleado::where('user_id', $id)->delete();

    // Eliminar usuario
    User::destroy($id);

    return back()->with('success', 'Usuario y perfil eliminados correctamente.');
}

}
