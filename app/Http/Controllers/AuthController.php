<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView() {
        return view('auth.login');
    }

   public function login(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // 1. Buscar usuario por correo
    $user = \App\Models\User::where('email', $request->email)->first();

    // 2. Verificar si existe
    if (!$user) {
        return back()->with('error', 'Credenciales incorrectas');
    }

    // 3. Verificar si está INACTIVO
    if ($user->estado === 'inactivo') {
        return back()->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
    }

    // 4. Intentar login
    if(Auth::attempt($request->only('email', 'password'))) {
        return redirect()->route('dashboard');
    }

    // 5. Error de password
    return back()->with('error', 'Credenciales incorrectas');
}


    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
