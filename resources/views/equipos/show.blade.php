@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            {{-- Header --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill"></i> {{ $equipo->nombre }}
                    </h4>
                    <div>
                        <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Información General --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Código</label>
                                    <h5>{{ $equipo->codigo }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Estado</label>
                                    <h5>
                                        <span class="badge bg-{{ $equipo->estado == 'activo' ? 'success' : ($equipo->estado == 'inactivo' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($equipo->estado) }}
                                        </span>
                                    </h5>
                                </div>
                            </div>

                            @if($equipo->descripcion)
                            <div class="mb-3">
                                <label class="text-muted small">Descripción</label>
                                <p>{{ $equipo->descripcion }}</p>
                            </div>
                            @endif

                            @if($equipo->objetivos)
                            <div class="mb-3">
                                <label class="text-muted small">Objetivos</label>
                                <p>{{ $equipo->objetivos }}</p>
                            </div>
                            @endif

                            <div class="row mb-3">
                                @if($equipo->fecha_inicio)
                                <div class="col-md-6">
                                    <label class="text-muted small">Fecha Inicio</label>
                                    <p><i class="bi bi-calendar-check"></i> {{ $equipo->fecha_inicio->format('d/m/Y') }}</p>
                                </div>
                                @endif
                                @if($equipo->fecha_fin)
                                <div class="col-md-6">
                                    <label class="text-muted small">Fecha Fin</label>
                                    <p><i class="bi bi-calendar-x"></i> {{ $equipo->fecha_fin->format('d/m/Y') }}</p>
                                </div>
                                @endif
                            </div>

                            @if($equipo->ubicacion)
                            <div class="mb-3">
                                <label class="text-muted small">Ubicación / Modalidad</label>
                                <p>
                                    <span class="badge bg-info">{{ ucfirst($equipo->ubicacion) }}</span>
                                </p>
                            </div>
                            @endif

                            @if($equipo->notas)
                            <div class="mb-3">
                                <label class="text-muted small">Notas</label>
                                <p class="text-muted">{{ $equipo->notas }}</p>
                            </div>
                            @endif

                            <div class="text-muted small">
                                <p class="mb-1">
                                    <strong>Creado por:</strong> 
                                    {{ $equipo->creador->name ?? 'N/A' }}
                                </p>
                                <p class="mb-0">
                                    <strong>Fecha de creación:</strong> 
                                    {{ $equipo->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    {{-- Proyecto asignado --}}
                    @if($equipo->proyecto)
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-folder"></i> Proyecto Principal
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6>{{ $equipo->proyecto->nombre_proyecto }}</h6>
                            <small class="text-muted">{{ $equipo->proyecto->codigo }}</small>
                        </div>
                    </div>
                    @endif

                    {{-- Estadísticas --}}
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-graph-up"></i> Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Miembros:</span>
                                <strong>{{ $equipo->cantidad_miembros }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Líderes:</span>
                                <strong>{{ $equipo->lideres->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Miembros:</span>
                                <strong>{{ $equipo->miembrosRegulares->count() }}</strong>
                            </div>
                            @if($equipo->capacidad_maxima)
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Capacidad Máxima:</span>
                                <strong>{{ $equipo->capacidad_maxima }}</strong>
                            </div>
                            <div class="progress mt-2" style="height: 20px;">
                                <div class="progress-bar {{ $equipo->estaLleno() ? 'bg-danger' : 'bg-success' }}" 
                                     style="width: {{ ($equipo->cantidad_miembros / $equipo->capacidad_maxima) * 100 }}%">
                                    {{ round(($equipo->cantidad_miembros / $equipo->capacidad_maxima) * 100) }}%
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Líderes del Equipo --}}
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <i class="bi bi-star-fill"></i> Líderes del Equipo
                        <span class="badge bg-dark">{{ $equipo->lideres->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($equipo->lideres->count() > 0)
                    <div class="row">
                        @foreach($equipo->lideres as $lider)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $lider->name }}</h6>
                                            <p class="text-muted mb-1">{{ $lider->email }}</p>
                                            <span class="badge bg-danger">{{ ucfirst($lider->rol) }}</span>
                                            <span class="badge bg-warning text-dark">Líder</span>
                                            @if($lider->pivot->fecha_asignacion)
                                            <p class="text-muted small mt-2 mb-0">
                                                <i class="bi bi-calendar-plus"></i> 
                                                Desde: {{ \Carbon\Carbon::parse($lider->pivot->fecha_asignacion)->format('d/m/Y') }}
                                            </p>
                                            @endif
                                        </div>
                                        <div>
                                            <form action="{{ route('equipos.removerMiembro', [$equipo->id, $lider->id]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Remover a {{ $lider->name }} del equipo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0">No hay líderes asignados</p>
                    @endif
                </div>
            </div>

            {{-- Miembros del Equipo --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-people"></i> Miembros del Equipo
                        <span class="badge bg-dark">{{ $equipo->miembrosRegulares->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($equipo->miembrosRegulares->count() > 0)
                    <div class="row">
                        @foreach($equipo->miembrosRegulares as $miembro)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $miembro->name }}</h6>
                                            <p class="text-muted mb-1 small">{{ $miembro->email }}</p>
                                            <span class="badge bg-info">{{ ucfirst($miembro->rol) }}</span>
                                            @if($miembro->pivot->fecha_asignacion)
                                            <p class="text-muted small mt-2 mb-0">
                                                <i class="bi bi-calendar-plus"></i> 
                                                {{ \Carbon\Carbon::parse($miembro->pivot->fecha_asignacion)->format('d/m/Y') }}
                                            </p>
                                            @endif
                                        </div>
                                        <div class="btn-group-vertical btn-group-sm">
                                            @if($miembro->puedeSeLider())
                                            <form action="{{ route('equipos.cambiarRol', [$equipo->id, $miembro->id]) }}" 
                                                  method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="rol_equipo" value="lider">
                                                <button type="submit" class="btn btn-sm btn-warning" 
                                                        title="Promover a líder">
                                                    <i class="bi bi-star"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('equipos.removerMiembro', [$equipo->id, $miembro->id]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Remover a {{ $miembro->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0">No hay miembros asignados</p>
                    @endif
                </div>
            </div>

            {{-- Agregar nuevo miembro --}}
            @if(!$equipo->estaLleno())
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus"></i> Agregar Miembro
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipos.agregarMiembro', $equipo->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Seleccionar Usuario</label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    @foreach(\App\Models\User::where('estado', 'activo')
                                        ->whereNotIn('id', $equipo->miembros->pluck('id'))
                                        ->get() as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Rol en el Equipo</label>
                                <select name="rol_equipo" class="form-select" required>
                                    <option value="miembro">Miembro</option>
                                    <option value="lider">Líder</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-plus-circle"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> El equipo ha alcanzado su capacidad máxima de {{ $equipo->capacidad_maxima }} miembros.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection