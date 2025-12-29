<div class="row">


    <div class="col-md-4 mb-3">
        <label>Tipo Cliente</label>
        <select name="tipo_cliente" class="form-control" required>
            <option value="persona" {{ (isset($cliente) && $cliente->tipo_cliente=='persona') ? 'selected' : '' }}>Persona</option>
            <option value="empresa" {{ (isset($cliente) && $cliente->tipo_cliente=='empresa') ? 'selected' : '' }}>Empresa</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Nombre Comercial</label>
        <input type="text" name="nombre_comercial" class="form-control"
               value="{{ $cliente->nombre_comercial ?? '' }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Razon Social</label>
        <input type="text" name="razon_social" class="form-control"
               value="{{ $cliente->razon_social ?? '' }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>RUC / DNI</label>
        <input type="text" name="ruc_dni" class="form-control"
               value="{{ $cliente->ruc_dni ?? '' }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Representante</label>
        <input type="text" name="representante" class="form-control"
               value="{{ $cliente->representante ?? '' }}">
    </div>
<div class="col-md-6 mb-3">
    <label>Nueva Contraseña</label>
    <input type="password" name="password" class="form-control">
    <small class="text-muted">
        Déjalo vacío para mantener la contraseña actual
    </small>
</div>

    <div class="col-md-4 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ $cliente->email ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Email Alterno</label>
        <input type="email" name="email_alt" class="form-control"
               value="{{ $cliente->email_alt ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-control"
               value="{{ $cliente->telefono ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Teléfono Alterno</label>
        <input type="text" name="telefono_alt" class="form-control"
               value="{{ $cliente->telefono_alt ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Actividad</label>
        <input type="text" name="actividad" class="form-control"
               value="{{ $cliente->actividad ?? '' }}">
    </div>

    <div class="col-md-12 mb-3">
        <label>Dirección</label>
        <input type="text" name="direccion" class="form-control"
               value="{{ $cliente->direccion ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Ciudad</label>
        <input type="text" name="ciudad" class="form-control"
               value="{{ $cliente->ciudad ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>País</label>
        <input type="text" name="pais" class="form-control"
               value="{{ $cliente->pais ?? '' }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Estado</label>
        <select name="estado_cliente" class="form-control">
            <option value="activo" {{ isset($cliente) && $cliente->estado_cliente=='activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ isset($cliente) && $cliente->estado_cliente=='inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

   

</div>
