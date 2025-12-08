<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
{
    $usuarios = User::with('empleado')->get(); // carga datos extra si existen

   return view('admin.usuarios.index', compact('usuarios'));

}

    // Vista del formulario de creación
    public function create() {

        if(Auth::user()->rol !== 'administrador') {
            abort(403, 'No tienes permisos.');
        }

        return view('users.create');
    }

    // Guardar el usuario
public function store(Request $request) {

    if(Auth::user()->rol !== 'administrador') {
        abort(403, 'No tienes permisos.');
    }

    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'rol' => 'required|in:administrador,supervisor,usuario',
    ]);

    // Crear usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol' => $request->rol
    ]);

    // Crear perfil automáticamente
    $user->empleado()->create([
        'cargo' => null,
        'area' => null,
        'remuneracion' => null,
        'fecha_ingreso' => now(),
        'turno' => null,
        'celular' => null,
        'direccion' => null,
        'carrera' => null,
        'ciclo' => null,
        'fecha_nacimiento' => null,
        'observaciones' => null,
    ]);

  return redirect()->route('usuarios.index')
    ->with('success', 'Usuario creado correctamente con perfil asociado.');

}

}
