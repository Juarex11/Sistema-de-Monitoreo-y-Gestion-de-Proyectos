@extends('layouts.app')

@section('content')
<h2>Gestión de Usuarios</h2>

<table class="table table-striped mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
           
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

@foreach($usuarios as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->rol }}</td>
       

      <td>
   <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalInfo{{ $u->id }}">
    <i class="bi bi-eye-fill"></i> Info
</button>

    <button
    class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#modalEditar{{ $u->id }}">
    Editar
</button>
    @if($u->id == 1)
        <button class="btn btn-secondary btn-sm" disabled>No eliminar</button>
    @else
        <a href="{{ route('admin.usuarios.eliminar', $u->id) }}"
           class="btn btn-danger btn-sm"
           onclick="return confirm('¿Deseas eliminar al usuario y su perfil asociado?');">
           Eliminar
        </a>
    @endif
</td>

    </tr>
@endforeach

    </tbody>
</table>

@endsection
@foreach($usuarios as $u)

<div class="modal fade" id="modalEditar{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form action="{{ route('admin.usuarios.update', $u->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Editar Usuario y Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- DATOS DEL USUARIO --}}
                    <h5 class="fw-bold mb-3">Datos del Usuario</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $u->name }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Correo</label>
                            <input type="email" name="email" class="form-control" value="{{ $u->email }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Rol</label>
                            <select name="rol" class="form-control">
                                <option value="administrador" {{ $u->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="supervisor" {{ $u->rol == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="usuario" {{ $u->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    {{-- PERFIL DEL EMPLEADO --}}
                    <h5 class="fw-bold mb-3">Perfil del Empleado</h5>

                    @php $p = $u->perfil; @endphp

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Cargo</label>
                            <input type="text" name="cargo" class="form-control" value="{{ $p->cargo ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Área</label>
                            <input type="text" name="area" class="form-control" value="{{ $p->area ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Remuneración</label>
                            <input type="number" step="0.01" name="remuneracion" class="form-control" value="{{ $p->remuneracion ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" value="{{ $p->fecha_ingreso ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Turno</label>
                            <input type="text" name="turno" class="form-control" value="{{ $p->turno ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Celular</label>
                            <input type="text" name="celular" class="form-control" value="{{ $p->celular ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control" value="{{ $p->direccion ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Carrera</label>
                            <input type="text" name="carrera" class="form-control" value="{{ $p->carrera ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Ciclo</label>
                            <input type="text" name="ciclo" class="form-control" value="{{ $p->ciclo ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $p->fecha_nacimiento ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Observaciones</label>
                            <input type="text" name="observaciones" class="form-control" value="{{ $p->observaciones ?? '' }}">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Todo</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endforeach
@foreach($usuarios as $u)

<div class="modal fade" id="modalInfo{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Información del Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @php $p = $u->perfil; @endphp

                {{-- DATOS GENERALES --}}
                <div class="p-3 rounded-3 mb-4 bg-light">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-person-badge me-2 text-primary"></i>
                        Datos Generales
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nombre:</strong><br>
                            {{ $u->name }}
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Correo:</strong><br>
                            {{ $u->email }}
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Rol:</strong><br>
                            <span class="badge bg-dark">{{ $u->rol }}</span>
                        </div>
                    </div>
                </div>

                {{-- PERFIL DEL EMPLEADO --}}
                <div class="p-3 rounded-3 bg-light">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-briefcase-fill me-2 text-primary"></i>
                        Perfil del Empleado
                    </h5>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <strong>Cargo:</strong><br>
                            {{ $p->cargo ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Área:</strong><br>
                            {{ $p->area ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Remuneración:</strong><br>
                            {{ $p->remuneracion ? 'S/ '.$p->remuneracion : '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Fecha Ingreso:</strong><br>
                            {{ $p->fecha_ingreso ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Turno:</strong><br>
                            {{ $p->turno ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Celular:</strong><br>
                            {{ $p->celular ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Dirección:</strong><br>
                            {{ $p->direccion ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Carrera:</strong><br>
                            {{ $p->carrera ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Ciclo:</strong><br>
                            {{ $p->ciclo ?? '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Fecha Nacimiento:</strong><br>
                            {{ $p->fecha_nacimiento ?? '---' }}
                        </div>

                        <div class="col-md-12 mb-3">
                            <strong>Observaciones:</strong><br>
                            {{ $p->observaciones ?? '---' }}
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

@endforeach
