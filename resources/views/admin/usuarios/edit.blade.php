@extends('layouts.app')

@section('content')
<h2>Editar Usuario</h2>

<!-- BOTÓN PARA ABRIR EL MODAL -->
<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar">
    Editar Usuario
</button>

<!-- MODAL -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Editar Usuario y Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <h5 class="fw-bold">Datos del Usuario</h5>
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $usuario->name }}">
                        </div>

                        <div class="col-md-6">
                            <label>Correo</label>
                            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}">
                        </div>

                        <div class="col-md-6">
                            <label>Rol</label>
                            <select name="rol" class="form-control">
                                <option value="admin" {{ $usuario->rol=='admin'?'selected':'' }}>Admin</option>
                                <option value="empleado" {{ $usuario->rol=='empleado'?'selected':'' }}>Empleado</option>
                            </select>
                        </div>

                    </div>

                    <hr>

                    <h5 class="fw-bold">Datos del Perfil (perfil_empleados)</h5>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label>DNI</label>
                            <input type="text" name="dni" class="form-control"
                                   value="{{ $usuario->perfil->dni ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control"
                                   value="{{ $usuario->perfil->direccion ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control"
                                   value="{{ $usuario->perfil->telefono ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label>Cargo</label>
                            <input type="text" name="cargo" class="form-control"
                                   value="{{ $usuario->perfil->cargo ?? '' }}">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
