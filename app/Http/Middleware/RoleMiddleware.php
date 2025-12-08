<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * $roles puede venir como 'administrador' o 'administrador|supervisor'
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $rolesArray = explode('|', $roles);

        if (!in_array($user->rol, $rolesArray)) {
            // puedes personalizar: redirigir al dashboard con mensaje
            return redirect()->route('dashboard')->with('error', 'No tienes permisos.');
        }

        return $next($request);
    }
}
