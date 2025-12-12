@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-file-earmark-text"></i> Detalle de Cotización
            </h4>

            <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Info general -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3 text-primary"><strong>{{ $cotizacion->codigo }}</strong></h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong><br>
                        {{ $cotizacion->cliente->nombre_comercial ?? $cotizacion->cliente->name }}
                    </p>
                </div>

                <div class="col-md-3">
                    <p>
                        <strong>Fecha:</strong><br>
                        {{ $cotizacion->created_at->format('d/m/Y') }}
                    </p>
                </div>

                <div class="col-md-3">
                    <p>
                        <strong>Estado:</strong><br>
                        <span class="badge bg-{{ 
                            $cotizacion->estado == 'pendiente' ? 'warning' : 
                            ($cotizacion->estado == 'aprobada' ? 'success' : 'danger')
                        }}">
                            {{ ucfirst($cotizacion->estado) }}
                        </span>
                    </p>
                </div>
            </div>

            @if($cotizacion->descripcion)
                <p><strong>Descripción:</strong><br>{{ $cotizacion->descripcion }}</p>
            @endif
        </div>
    </div>

    <!-- Items -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Items de la Cotización</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Tipo Pago</th>
                            <th>Precio</th>
                            <th>IGV</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                  <tbody>
    @foreach($cotizacion->items as $i => $item)
    <tr>
        <form action="{{ route('cotizacion_items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <td>{{ $i + 1 }}</td>

            <td style="min-width: 220px;">
                <input 
                    type="text" 
                    name="titulo" 
                    class="form-control form-control-sm mb-1"
                    value="{{ $item->titulo }}" 
                    required
                >

                <textarea 
                    name="descripcion" 
                    class="form-control form-control-sm" 
                    rows="2"
                >{{ $item->descripcion }}</textarea>
            </td>

            <td>
                <select name="tipo_pago" class="form-select form-select-sm">
                    <option value="unico" {{ $item->tipo_pago == 'unico' ? 'selected' : '' }}>Único</option>
                    <option value="mensual" {{ $item->tipo_pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
                    <option value="anual" {{ $item->tipo_pago == 'anual' ? 'selected' : '' }}>Anual</option>
                </select>
            </td>

            <td>
                <input 
                    type="number" 
                    name="precio" 
                    class="form-control form-control-sm text-end"
                    value="{{ $item->precio }}" 
                    step="0.01" 
                    required
                >
            </td>

            <td class="text-center">
                <input 
                    type="checkbox" 
                    name="aplica_igv" 
                    {{ $item->aplica_igv ? 'checked' : '' }}
                >
            </td>

            <td class="fw-bold text-primary">
                S/ {{ number_format($item->total, 2) }}
            </td>

            <td class="text-center">
                <button class="btn btn-success btn-sm" type="submit">
                    <i class="bi bi-save"></i>
                </button>
        </form>

        <form action="{{ route('cotizacion_items.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar ítem?')">
                <i class="bi bi-trash"></i>
            </button>
        </form>
            </td>
    </tr>
    @endforeach
</tbody>


                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">TOTAL GENERAL:</th>
                            <th class="text-primary">
                                S/ {{ number_format($cotizacion->total, 2) }}
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-secondary text-white">
        <strong>Agregar Ítem</strong>
    </div>

    <div class="card-body">
        <form action="{{ route('cotizaciones.items.agregar', $cotizacion->id) }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1" value="1" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tipo de Pago</label>
                    <select name="tipo_pago" class="form-select" required>
                        <option value="unico">Único</option>
                        <option value="mensual">Mensual</option>
                        <option value="anual">Anual</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label d-block">Aplica IGV</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="aplica_igv" value="1">
                    </div>
                </div>

            </div>

            <button class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agregar Ítem
            </button>

        </form>
    </div>
</div>

    <div class="text-end mt-3">
        <a href="{{ route('cotizaciones.pdf', $cotizacion->id) }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Descargar PDF
        </a>
    </div>

</div>

@endsection
