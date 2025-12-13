@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Equipo
                    </h4>
                    <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Información básica --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" value="{{ $equipo->codigo }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estado *</label>
                                <select name="estado" class="form-select" required>
                                    <option value="activo" {{ $equipo->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ $equipo->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="finalizado" {{ $equipo->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Nombre del Equipo *</label>
                                <input type="text" name="nombre" class="form-control" 
                                       value="{{ old('nombre', $equipo->nombre) }}" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                            </div>
                        </div>

                        {{-- Proyecto y fechas --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Proyecto Asignado</label>
                                <select name="proyecto_id" class="form-select">
                                    <option value="">Sin proyecto asignado</option>
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}" 
                                            {{ $equipo->proyecto_id == $proyecto->id ? 'selected' : '' }}>
                                            {{ $proyecto->nombre_proyecto }} ({{ $proyecto->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" 
                                       value="{{ old('fecha_inicio', $equipo->fecha_inicio?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" 
                                       value="{{ old('fecha_fin', $equipo->fecha_fin?->format('Y-m-d')) }}">
                            </div>
                        </div>

                        {{-- Configuración del equipo --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Capacidad Máxima</label>
                                <input type="number" name="capacidad_maxima" class="form-control" 
                                       value="{{ old('capacidad_maxima', $equipo->capacidad_maxima) }}" min="1">
                                <small class="text-muted">Dejar vacío para sin límite</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ubicación / Modalidad</label>
                                <select name="ubicacion" class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="oficina" {{ $equipo->ubicacion == 'oficina' ? 'selected' : '' }}>Oficina</option>
                                    <option value="remoto" {{ $equipo->ubicacion == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ $equipo->ubicacion == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Objetivos del Equipo</label>
                                <textarea name="objetivos" class="form-control" rows="3">{{ old('objetivos', $equipo->objetivos) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea name="notas" class="form-control" rows="3">{{ old('notas', $equipo->notas) }}</textarea>
                            </div>
                        </div>

                        {{-- Información de miembros (solo informativa) --}}
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Nota:</strong> Para agregar o remover miembros del equipo, hazlo desde la vista de detalle del equipo.
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Miembros Actuales</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Líderes:</strong>
                                        <ul class="list-unstyled mt-2">
                                            @forelse($equipo->lideres as $lider)
                                            <li>
                                                <i class="bi bi-star-fill text-warning"></i> 
                                                {{ $lider->name }}
                                            </li>
                                            @empty
                                            <li class="text-muted">Sin líderes asignados</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Miembros:</strong>
                                        <ul class="list-unstyled mt-2">
                                            @forelse($equipo->miembrosRegulares as $miembro)
                                            <li>
                                                <i class="bi bi-person"></i> 
                                                {{ $miembro->name }}
                                            </li>
                                            @empty
                                            <li class="text-muted">Sin miembros asignados</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="text-end">
                            <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection