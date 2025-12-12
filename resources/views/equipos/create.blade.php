@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill"></i> Crear Nuevo Equipo
                    </h4>
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">
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

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('equipos.store') }}" method="POST">
                        @csrf

                        {{-- Información básica --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Equipo *</label>
                                <input type="text" name="nombre" class="form-control" 
                                       value="{{ old('nombre') }}" required
                                       placeholder="Ej: Equipo de Desarrollo Web">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estado *</label>
                                <select name="estado" class="form-select" required>
                                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3" 
                                          placeholder="Describe el propósito y alcance del equipo">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        {{-- Proyecto y fechas --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Proyecto Asignado</label>
                                <select name="proyecto_id" class="form-select">
                                    <option value="">Sin proyecto asignado</option>
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}" {{ old('proyecto_id') == $proyecto->id ? 'selected' : '' }}>
                                            {{ $proyecto->nombre_proyecto }} ({{ $proyecto->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
                            </div>
                        </div>

                        {{-- Configuración del equipo --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Capacidad Máxima</label>
                                <input type="number" name="capacidad_maxima" class="form-control" 
                                       value="{{ old('capacidad_maxima') }}" min="1"
                                       placeholder="Número máximo de miembros">
                                <small class="text-muted">Dejar vacío para sin límite</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ubicación / Modalidad</label>
                                <select name="ubicacion" class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="oficina" {{ old('ubicacion') == 'oficina' ? 'selected' : '' }}>Oficina</option>
                                    <option value="remoto" {{ old('ubicacion') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ old('ubicacion') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Objetivos del Equipo</label>
                                <textarea name="objetivos" class="form-control" rows="3" 
                                          placeholder="Metas y objetivos que debe alcanzar el equipo">{{ old('objetivos') }}</textarea>
                            </div>
                        </div>

                        {{-- Selección de Líderes --}}
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-star-fill"></i> Líderes del Equipo *
                                </h5>
                                <small>Selecciona al menos un líder (Administrador o Supervisor)</small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($lideresDisponibles as $lider)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="lideres[]" value="{{ $lider->id }}" 
                                                   id="lider{{ $lider->id }}"
                                                   {{ in_array($lider->id, old('lideres', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="lider{{ $lider->id }}">
                                                <strong>{{ $lider->name }}</strong>
                                                <span class="badge bg-{{ $lider->rol == 'administrador' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($lider->rol) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $lider->email }}</small>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if($lideresDisponibles->isEmpty())
                                <div class="alert alert-warning">
                                    No hay líderes disponibles. Asegúrate de tener usuarios con rol de Administrador o Supervisor.
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Selección de Miembros --}}
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-people"></i> Miembros del Equipo
                                </h5>
                                <small>Selecciona los miembros que formarán parte del equipo</small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="text" id="buscarMiembro" class="form-control" 
                                           placeholder="Buscar por nombre o email...">
                                </div>
                                <div class="row" id="listaMiembros">
                                    @foreach($usuarios as $usuario)
                                    <div class="col-md-6 mb-2 miembro-item" 
                                         data-nombre="{{ strtolower($usuario->name) }}" 
                                         data-email="{{ strtolower($usuario->email) }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="miembros[]" value="{{ $usuario->id }}" 
                                                   id="miembro{{ $usuario->id }}"
                                                   {{ in_array($usuario->id, old('miembros', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="miembro{{ $usuario->id }}">
                                                <strong>{{ $usuario->name }}</strong>
                                                <span class="badge bg-info">{{ ucfirst($usuario->rol) }}</span>
                                                <br>
                                                <small class="text-muted">{{ $usuario->email }}</small>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Notas adicionales --}}
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea name="notas" class="form-control" rows="3" 
                                          placeholder="Cualquier información adicional relevante">{{ old('notas') }}</textarea>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="text-end">
                            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Crear Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Buscador de miembros
document.getElementById('buscarMiembro').addEventListener('input', function() {
    const termino = this.value.toLowerCase();
    const items = document.querySelectorAll('.miembro-item');
    
    items.forEach(item => {
        const nombre = item.dataset.nombre;
        const email = item.dataset.email;
        
        if (nombre.includes(termino) || email.includes(termino)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

<style>
.form-check-label {
    cursor: pointer;
}

.form-check {
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa;
}
</style>
@endsection