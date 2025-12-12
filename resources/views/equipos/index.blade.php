@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            {{-- Header --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill"></i> Equipos de Trabajo
                    </h4>
                    <a href="{{ route('equipos.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nuevo Equipo
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Estadísticas --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center bg-primary text-white">
                        <div class="card-body">
                            <h3>{{ $equipos->count() }}</h3>
                            <p class="mb-0">Total Equipos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center bg-success text-white">
                        <div class="card-body">
                            <h3>{{ $equipos->where('estado', 'activo')->count() }}</h3>
                            <p class="mb-0">Activos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center bg-warning text-white">
                        <div class="card-body">
                            <h3>{{ $equipos->where('estado', 'inactivo')->count() }}</h3>
                            <p class="mb-0">Inactivos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center bg-secondary text-white">
                        <div class="card-body">
                            <h3>{{ $equipos->where('estado', 'finalizado')->count() }}</h3>
                            <p class="mb-0">Finalizados</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listado de equipos --}}
            @forelse($equipos as $equipo)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mb-0 me-2">
                                    <i class="bi bi-people-fill text-primary"></i>
                                    {{ $equipo->nombre }}
                                </h5>
                                <span class="badge bg-{{ $equipo->estado == 'activo' ? 'success' : ($equipo->estado == 'inactivo' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($equipo->estado) }}
                                </span>
                            </div>

                            <p class="text-muted mb-2">
                                <small><strong>Código:</strong> {{ $equipo->codigo }}</small>
                            </p>

                            @if($equipo->descripcion)
                            <p class="mb-2">{{ Str::limit($equipo->descripcion, 150) }}</p>
                            @endif

                            {{-- Información del proyecto --}}
                            @if($equipo->proyecto)
                            <div class="mb-2">
                                <i class="bi bi-folder text-info"></i>
                                <strong>Proyecto:</strong> {{ $equipo->proyecto->nombre_proyecto }}
                            </div>
                            @endif

                            {{-- Fechas --}}
                            <div class="row">
                                @if($equipo->fecha_inicio)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-check"></i> 
                                        Inicio: {{ $equipo->fecha_inicio->format('d/m/Y') }}
                                    </small>
                                </div>
                                @endif
                                @if($equipo->fecha_fin)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-x"></i> 
                                        Fin: {{ $equipo->fecha_fin->format('d/m/Y') }}
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            {{-- Líderes --}}
                            <div class="mb-3">
                                <strong class="d-block mb-2">
                                    <i class="bi bi-star-fill text-warning"></i> Líderes:
                                </strong>
                                @forelse($equipo->lideres as $lider)
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-danger me-1">
                                        {{ substr($lider->name, 0, 2) }}
                                    </span>
                                    <small>{{ $lider->name }}</small>
                                </div>
                                @empty
                                <small class="text-muted">Sin líderes asignados</small>
                                @endforelse
                            </div>

                            {{-- Contador de miembros --}}
                            <div class="mb-3">
                                <span class="badge bg-info">
                                    <i class="bi bi-people"></i> 
                                    {{ $equipo->cantidad_miembros }} miembros
                                    @if($equipo->capacidad_maxima)
                                        / {{ $equipo->capacidad_maxima }} máx
                                    @endif
                                </span>
                            </div>

                            {{-- Acciones --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" 
                                      onsubmit="return confirm('¿Eliminar este equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <h5 class="text-muted mt-3">No hay equipos registrados</h5>
                    <p class="text-muted">Haz clic en "Nuevo Equipo" para crear uno</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection