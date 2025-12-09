<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerfilEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    public function index()
    {
        $usuarios = User::with('perfil')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Verificar disponibilidad de email via AJAX
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $userId = $request->user_id;

        $exists = User::where('email', $email)
                      ->where('id', '!=', $userId)
                      ->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Validación con mensajes personalizados
      $validated = $request->validate([
    'name' => 'required|string|max:100',
    'email' => [
        'required',
        'email',
        'max:255',
        Rule::unique('users', 'email')->ignore($id)
    ],
    'rol' => 'required|in:administrador,supervisor,usuario',
    'estado' => 'required|in:activo,inactivo', // ← AQUI DEBE IR
    'password' => 'nullable|min:6',
], [
    'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
    'email.required' => 'El correo electrónico es obligatorio.',
    'email.email' => 'Debe proporcionar un correo electrónico válido.',
    'name.required' => 'El nombre es obligatorio.',
    'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
]);


        try {
            // Actualizar datos del usuario
            $usuario->name = $validated['name'];
            $usuario->email = $validated['email'];
            $usuario->rol = $validated['rol'];
$usuario->estado = $validated['estado'];

            // Actualizar contraseña SOLO si se proporcionó una nueva
            if ($request->filled('password') && !empty($request->password)) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();

            // Actualizar o crear perfil
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

            return redirect()->route('usuarios.index')
                             ->with('success', 'Usuario y perfil actualizados correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar errores de base de datos (como duplicados)
            if ($e->getCode() == 23000) {
                return redirect()->back()
                                 ->withInput()
                                 ->with('error', 'El correo electrónico ya está registrado por otro usuario.');
            }
            
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Ocurrió un error al actualizar el usuario.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Ocurrió un error inesperado. Por favor, intente nuevamente.');
        }
    }

    public function eliminar($id)
{
    // No permitir borrar al usuario principal ID 1
    if ($id == 1) {
        return redirect()->route('usuarios.index')
                       ->with('error', 'El usuario administrador principal no puede ser eliminado.');
    }

    try {
        // 🔹 Reasignar proyectos donde era responsable
        \App\Models\Project::where('responsable_id', $id)->update([
            'responsable_id' => 1
        ]);

        // 🔹 Reasignar proyectos donde era creador (opcional)
        \App\Models\Project::where('creado_por', $id)->update([
            'creado_por' => 1
        ]);

        // 🔹 Eliminar perfil asociado
        PerfilEmpleado::where('user_id', $id)->delete();

        // 🔹 Eliminar usuario
        User::destroy($id);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario eliminado y proyectos reasignados correctamente.');

    } catch (\Exception $e) {
        return redirect()->route('usuarios.index')
                         ->with('error', 'No se pudo eliminar el usuario.');
    }
}

}