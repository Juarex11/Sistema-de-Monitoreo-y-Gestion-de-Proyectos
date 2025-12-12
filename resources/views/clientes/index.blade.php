@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3><i class="bi bi-people"></i> Clientes</h3>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre Comercial</th>
                        <th>RUC / DNI</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                         <th>Creado el</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td>{{ $c->codigo }}</td>
                        <td>{{ $c->nombre_comercial }}</td>
                        <td>{{ $c->ruc_dni }}</td>
                        <td>{{ $c->telefono }}</td>
                        <td>{{ $c->email }}</td>
                         <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y') }}</td> 
                        <td>
                            <span class="badge bg-{{ $c->estado_cliente == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($c->estado_cliente) }}
                            </span>
                        </td>
                        <td class="d-flex gap-2">

                            <button class="btn btn-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal{{ $c->id }}">
                                <i class="bi bi-folder"></i>
                            </button>

                            <a href="{{ route('clientes.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('clientes.destroy', $c->id) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar cliente?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modal{{ $c->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Proyectos de {{ $c->nombre_comercial }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                   @if($c->proyectos && $c->proyectos->count() > 0)
    <div class="proyectos-container">
        @foreach($c->proyectos as $p)
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 12px; padding: 10px 15px; background-color: #f8f9fa; border-radius: 8px;">
                
                <!-- Código -->
                <div>
                    <small style="color: #6c757d;">Código</small><br>
                    <span style="background-color: #6c757d; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">
                        {{ $p->codigo }}
                    </span>
                </div>
                
                <!-- Nombre del proyecto -->
                <div style="flex: 1;">
                    <small style="color: #6c757d;">Nombre</small><br>
                    <strong>{{ $p->nombre_proyecto }}</strong>
                </div>
                
                <!-- Estado -->
                <div>
                    <small style="color: #6c757d;">Estado</small><br>
                    <span style="padding: 2px 6px; border-radius: 4px; color: #fff; background-color: {{ $p->estado == 'completado' ? '#198754' : '#ffc107' }};">
                        {{ ucfirst($p->estado) }}
                    </span>
                </div>
                
                <!-- Fecha de inicio -->
                @if($p->fecha_inicio)
                    <div>
                        <small style="color: #6c757d;">Fecha inicio</small><br>
                        <span style="color: #555;">{{ \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m/Y') }}</span>
                    </div>
                @endif
                
                <!-- Presupuesto asignado -->
                @if($p->presupuesto_asignado)
                    <div>
                        <small style="color: #6c757d;">Presupuesto</small><br>
                        <span style="color: #555;">S/ {{ number_format($p->presupuesto_asignado, 2) }}</span>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
@else
    <p class="text-muted">No tiene proyectos asignados</p>
@endif

                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection