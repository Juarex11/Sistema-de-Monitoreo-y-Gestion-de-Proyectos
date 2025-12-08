<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('es');

        // Fecha de hoy (según tu zona horaria)
        $hoy = Carbon::now(); // si quieres fijo Peru: Carbon::now('America/Lima');
        $mesActual = $hoy->month;
        $diaActual = $hoy->day;

        // 1) Cumpleaños del mes (lista general)
        $cumpleanios = User::with('perfil')
            ->whereHas('perfil', function ($q) use ($mesActual) {
                $q->whereMonth('fecha_nacimiento', $mesActual);
            })
            ->get()
            ->filter(function ($u) {
                return $u->perfil && $u->perfil->fecha_nacimiento;
            })
            ->sortBy(function ($u) {
                return Carbon::parse($u->perfil->fecha_nacimiento)->day;
            });

        // 2) Cumpleaños de HOY (consulta directa a la BD)
        $cumplenHoy = User::with('perfil')
            ->whereHas('perfil', function ($q) use ($mesActual, $diaActual) {
                $q->whereMonth('fecha_nacimiento', $mesActual)
                  ->whereDay('fecha_nacimiento', $diaActual);
            })
            ->get();

        return view('dashboard', compact('cumpleanios', 'cumplenHoy', 'mesActual'));
    }
}
