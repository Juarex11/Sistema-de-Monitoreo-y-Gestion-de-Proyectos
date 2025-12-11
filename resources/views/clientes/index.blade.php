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
                        <th>Estado</th>
                        <th width="120">Acciones</th>
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
                        <td>
                            <span class="badge bg-{{ $c->estado_cliente == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($c->estado_cliente) }}
                            </span>
                        </td>
                        <td class="d-flex gap-2">

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
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
