<h2>Bienvenido {{ Auth::user()->name }}</h2>
<p>Rol: <strong>{{ Auth::user()->rol }}</strong></p>

@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
    $nombreMes = Carbon::create(null, $mesActual)->translatedFormat('F');
@endphp


<div class="container mt-4">

    
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




    {{-- PANEL NORMAL --}}
    @if(Auth::user()->rol === 'administrador')

        <div class="alert alert-primary">Panel Administrador</div>
        <ul>
            <li><a href="{{ route('usuarios.create') }}">Crear Usuario</a></li>
            <li><a href="{{ route('usuarios.index') }}">Lista de Usuarios</a></li>
            <li><a href="#">Equipos</a></li>
            <li><a href="#">Proyectos</a></li>
        </ul>

    @elseif(Auth::user()->rol === 'supervisor')

        <div class="alert alert-warning">Panel Supervisor</div>
        <ul>
            <li><a href="#">Equipos</a></li>
            <li><a href="#">Proyectos</a></li>
        </ul>

    @elseif(Auth::user()->rol === 'usuario')

        <div class="alert alert-success">Panel Usuario</div>
        <ul>
            <li><a href="#">Proyectos</a></li>
        </ul>

    @endif

</div>

<a href="{{ route('logout') }}" class="btn btn-danger mt-3">Cerrar sesión</a>
