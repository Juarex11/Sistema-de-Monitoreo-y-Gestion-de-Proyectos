@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-person-plus-fill"></i> Registrar Cliente
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="row">
                  

                    <div class="col-md-6 mb-3">
                        <label>Tipo de Cliente</label>
                      <select name="tipo_cliente" class="form-control" required>
    <option value="persona">Natural</option>
    <option value="empresa">Jurídico</option>
</select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nombre Comercial</label>
                        <input type="text" name="nombre_comercial" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Razón Social</label>
                        <input type="text" name="razon_social" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>RUC / DNI</label>
                        <input type="text" name="ruc_dni" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Representante</label>
                        <input type="text" name="representante" class="form-control">
                    </div>
<div class="col-md-6 mb-3">
    <label>Contraseña <span class="text-danger">*</span></label>
    <input type="password" name="password" class="form-control" required>
</div>

                    <div class="col-md-6 mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Teléfono Alterno</label>
                        <input type="text" name="telefono_alt" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email Alterno</label>
                        <input type="email" name="email_alt" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>País</label>
                        <input type="text" name="pais" class="form-control" value="Perú">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Estado</label>
                        <select name="estado_cliente" class="form-control">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Actividad</label>
                       <input type="text" name="actividad" class="form-control">
                    </div>

                 
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar
                </button>

            </form>

        </div>
    </div>
</div>
@endsection
