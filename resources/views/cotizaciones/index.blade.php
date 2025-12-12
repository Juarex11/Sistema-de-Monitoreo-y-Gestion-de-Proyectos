@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Cotizaciones</h4>
                    <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nueva Cotización
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ $cotizaciones->count() }}</h3>
                            <p class="text-muted mb-0">Total Cotizaciones</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning">{{ $cotizaciones->where('estado', 'pendiente')->count() }}</h3>
                            <p class="text-muted mb-0">Pendientes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ $cotizaciones->where('estado', 'aprobada')->count() }}</h3>
                            <p class="text-muted mb-0">Aprobadas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-danger">{{ $cotizaciones->where('estado', 'rechazada')->count() }}</h3>
                            <p class="text-muted mb-0">Rechazadas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de cotizaciones -->
            <div class="card">
                <div class="card-body p-0">
                    @if($cotizaciones->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <h5 class="text-muted mt-3">No hay cotizaciones registradas</h5>
                            <p class="text-muted">Haz clic en "Nueva Cotización" para crear una</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="12%">Código</th>
                                        <th width="20%">Cliente</th>
                                        <th width="15%">Fecha</th>
                                        <th width="8%" class="text-center">Items</th>
                                        <th width="12%" class="text-end">Total</th>
                                        <th width="13%" class="text-center">Estado</th>
                                        <th width="20%" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cotizaciones as $cotizacion)
                                    <tr>
                                        <td>
                                            <strong>{{ $cotizacion->codigo }}</strong>
                                        </td>
                                        <td>
                                            {{ $cotizacion->cliente->nombre_comercial ?? $cotizacion->cliente->name }}
                                            @if($cotizacion->cliente->ruc ?? false)
                                                <br><small class="text-muted">RUC: {{ $cotizacion->cliente->ruc }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $cotizacion->created_at->format('d/m/Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $cotizacion->created_at->format('H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $cotizacion->items->count() }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-primary">S/ {{ number_format($cotizacion->total, 2) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cotizaciones.updateEstado', $cotizacion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="estado" 
                                                        class="form-select form-select-sm estado-select estado-{{ $cotizacion->estado }}" 
                                                        onchange="this.form.submit()">
                                                    <option value="pendiente" {{ $cotizacion->estado == 'pendiente' ? 'selected' : '' }}>
                                                        Pendiente
                                                    </option>
                                                    <option value="aprobada" {{ $cotizacion->estado == 'aprobada' ? 'selected' : '' }}>
                                                        Aprobada
                                                    </option>
                                                    <option value="rechazada" {{ $cotizacion->estado == 'rechazada' ? 'selected' : '' }}>
                                                        Rechazada
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                       <td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" 
           class="btn btn-info"
           title="Ver detalle">
            <i class="bi bi-eye"></i> Ver
        </a>

        <a href="{{ route('cotizaciones.pdf', $cotizacion->id) }}" 
           class="btn btn-danger"
           title="Descargar PDF">
            <i class="bi bi-file-pdf"></i> PDF
        </a>

        <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger" title="Eliminar">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table tbody tr {
    transition: background-color 0.2s;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.estado-select {
    font-weight: 600;
    border: none;
    cursor: pointer;
}

.estado-pendiente {
    background-color: #ffc107;
    color: #000;
}

.estado-aprobada {
    background-color: #198754;
    color: #fff;
}

.estado-rechazada {
    background-color: #dc3545;
    color: #fff;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.badge {
    font-size: 0.9rem;
    padding: 0.4em 0.7em;
}
</style>
@endsection