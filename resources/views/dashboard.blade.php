@extends('layouts.app')

@section('content')

@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
    $nombreMes = Carbon::create(null, $mesActual)->translatedFormat('F');
@endphp
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="bi bi-person-circle"></i> 
                        Bienvenido, <strong>{{ Auth::user()->name }}</strong>
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-info fs-6">
                            <i class="bi bi-shield-check"></i> Rol: {{ Auth::user()->rol }}
                        </span>
                    </div>

                    {{-- ACCESOS RÁPIDOS SEGÚN ROL --}}
                    <div class="mt-4">
                          {{-- Cumpleaños del Mes --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">🎂 Cumpleaños del Mes: {{ ucfirst($nombreMes) }}</h4>
        </div>
        <div class="card-body">

            {{-- Mensaje especial de cumpleaños HOY --}}
            @if($cumplenHoy->count() > 0)
                @foreach($cumplenHoy as $c)
                    @php
                        $edad = Carbon::parse($c->perfil->fecha_nacimiento)->age;
                    @endphp
                    <div class="alert alert-success">
                        🎉 <strong>¡FELIZ CUMPLEAÑOS, {{ strtoupper($c->name) }}! 🎉</strong><br>
                        Hoy cumples <strong>{{ $edad }} años</strong>.  
                        Te deseamos muchos éxitos, salud y prosperidad. 🌟
                    </div>
                @endforeach
            @endif

            {{-- Lista de cumpleaños del mes --}}
            <h5 class="mt-3">Lista de Cumpleaños del Mes</h5>
            @forelse($cumpleanios as $u)
                <p class="mb-1">
                    <strong>{{ $u->name }}</strong> — 🎂
                    {{ Carbon::parse($u->perfil->fecha_nacimiento)->translatedFormat('d \d\e F') }}
                </p>
            @empty
                <p class="text-muted mb-0">No hay cumpleaños registrados este mes.</p>
            @endforelse

        </div>
    </div>
                        <h5><i class="bi bi-lightning-fill"></i> Accesos Rápidos</h5>
                        <ul class="list-group">

                            @if(Auth::user()->rol === 'administrador')
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('usuarios.index') }}" class="text-decoration-none">
                                        <i class="bi bi-people"></i> Lista de Usuarios
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Admin</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
    <a href="{{ route('usuarios.create') }}" class="text-decoration-none">
        <i class="bi bi-person-plus"></i> Crear Usuario
    </a>
    <span class="badge bg-primary rounded-pill">Admin</span>
</li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-pc-display"></i> Equipos
                                    </a>
                                    <span class="badge bg-success rounded-pill">Próximamente</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('proyectos.index') }}" class="text-decoration-none">
            <i class="bi bi-folder2-open"></i> Lista de Proyectos
        </a>
        <span class="badge bg-primary rounded-pill">Admin</span>
    </li>
<li class="list-group-item d-flex justify-content-between align-items-center">
    <a href="{{ route('clientes.index') }}" class="text-decoration-none">
        <i class="bi bi-people-fill"></i> Lista de Clientes
    </a>
    <span class="badge bg-primary rounded-pill">Admin</span>
</li>

                            @elseif(Auth::user()->rol === 'supervisor')
                                <li class="list-group-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-pc-display"></i> Equipos
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-folder"></i> Proyectos
                                    </a>
                                </li>

                            @else
                                <li class="list-group-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-person-circle"></i> Mi Perfil
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-folder"></i> Mis Proyectos
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6><i class="bi bi-info-circle"></i> Información del Sistema</h6>
                        <p class="mb-1"><strong>Usuario:</strong> {{ Auth::user()->email }}</p>
                        <p class="mb-1"><strong>Último acceso:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                        <p class="mb-0"><strong>Estado:</strong> <span class="badge bg-success">Activo</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
