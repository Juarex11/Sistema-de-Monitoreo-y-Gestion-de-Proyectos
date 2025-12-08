@extends('layouts.app')

@section('content')
<h2>Gestión de Usuarios</h2>

{{-- Mensajes de éxito --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Mensajes de error --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Errores de validación --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i>
        <strong>Por favor corrija los siguientes errores:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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

                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $u->id }}">
                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                @if($u->id == 1)
                    <button class="btn btn-secondary btn-sm" disabled>No eliminar</button>
                @else
                    <a href="{{ route('usuarios.eliminar', $u->id) }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Deseas eliminar al usuario y su perfil asociado?');">
                       <i class="bi bi-trash-fill"></i> Eliminar
                    </a>
                @endif

              <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDocumentos{{ $u->id }}">
    <i class="bi bi-file-earmark-pdf-fill"></i> Documentos
</button>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- MODALES DE EDICIÓN --}}
@foreach($usuarios as $u)
<div class="modal fade" id="modalEditar{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('usuarios.update', $u->id) }}" method="POST" class="form-usuario" data-user-id="{{ $u->id }}" data-current-email="{{ $u->email }}">
                @csrf
                @method('PUT')

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Editar Usuario y Perfil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Alertas dentro del modal --}}
                    <div class="alert alert-danger d-none error-alert" role="alert"></div>

                    {{-- DATOS DEL USUARIO --}}
                    <h5 class="fw-bold mb-3">Datos del Usuario</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                            <div class="invalid-feedback">El nombre es obligatorio</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Correo <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control email-input" value="{{ $u->email }}" required>
                            <div class="invalid-feedback email-error">Ingrese un correo válido</div>
                            <small class="text-muted d-none email-checking">
                                <i class="bi bi-hourglass-split"></i> Verificando disponibilidad...
                            </small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Contraseña <small class="text-muted">(dejar en blanco para no cambiar)</small></label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control password-input" placeholder="Nueva contraseña">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Mínimo 6 caracteres</div>
                            <small class="text-muted">Deje vacío si no desea cambiar la contraseña</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Rol <span class="text-danger">*</span></label>
                            <select name="rol" class="form-control" required>
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
                            <input type="date" name="fecha_ingreso" class="form-control" value="{{ $p?->fecha_ingreso?->format('Y-m-d') ?? '' }}">
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
                            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $p?->fecha_nacimiento?->format('Y-m-d') ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Observaciones</label>
                            <input type="text" name="observaciones" class="form-control" value="{{ $p->observaciones ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-guardar">
                        <i class="bi bi-save"></i> Guardar Todo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- MODALES DE INFORMACIÓN --}}
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
                            {{ $p?->remuneracion ? 'S/ '.$p->remuneracion : '---' }}
                        </div>

                        <div class="col-md-4 mb-3">
                            <strong>Fecha Ingreso:</strong><br>
                            {{ $p?->fecha_ingreso?->format('d/m/Y') ?? '---' }}
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
                            {{ $p?->fecha_nacimiento?->format('d/m/Y') ?? '---' }}
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

{{-- MODAL DE DOCUMENTOS --}}
@foreach($usuarios as $u)
<div class="modal fade" id="modalDocumentos{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                    Documentos de {{ $u->name }} 
                    <span class="badge bg-light text-dark ms-2">{{ $u->documents->count() }}</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- FORMULARIO PARA SUBIR NUEVO DOCUMENTO --}}
              <form action="{{ route('usuarios.documentos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $u->id }}">

    <div class="row g-3 mb-3">

        {{-- Nombre del documento --}}
        <div class="col-md-3">
            <label>Nombre del Documento</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Código único --}}
        <div class="col-md-3">
            <label>Código único</label>
            <input type="text" name="code" id="codeInput{{ $u->id }}" class="form-control" readonly required>

         <button type="button" class="btn btn-secondary btn-sm mt-1 gen-code-btn"
        data-user-id="{{ $u->id }}" data-user-name="{{ $u->name }}">
    Generar Código
</button>

        </div>

        {{-- Archivo PDF --}}
        <div class="col-md-3">
            <label>Archivo PDF</label>
            <input type="file" name="file" class="form-control" accept=".pdf" required>
        </div>

        {{-- Fecha --}}
        <div class="col-md-3">
            <label>Fecha</label>
            <input type="date" name="date" class="form-control" required>
        </div>

    </div>

    <button class="btn btn-success mb-3">
        <i class="bi bi-upload"></i> Subir Documento
    </button>
</form>


                {{-- LISTA DE DOCUMENTOS --}}
                <table class="table table-bordered table-striped">
                    
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Fecha</th>
                            <th>Subido por</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($u->documents as $doc)
                        <tr>
                            <td>{{ $doc->name }}</td>
                             <td>{{ $doc->code }}</td>
                            <td>{{ \Carbon\Carbon::parse($doc->date)->format('d/m/Y') }}</td>
                            <td>{{ $doc->uploaded_by }}</td>
                            <td>
                                <a href="{{ asset('storage/'.$doc->file) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('usuarios.documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este documento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($u->documents->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No hay documentos subidos</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if(session('qr'))
    <div class="mt-3">
        <p>QR del documento:</p>
        <img src="data:image/png;base64,{{ session('qr') }}" alt="QR del documento">
        <p>Código: {{ session('code') }}</p>
    </div>
@endif

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.gen-code-btn');

    // Función para generar cadena aleatoria de letras y números
    function generarCodigo(longitud = 8) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < longitud; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {
            const userId = this.dataset.userId;

            if (!userId) return;

            // Código final: solo aleatorio
            const code = generarCodigo(8); // puedes cambiar 8 por cualquier longitud

            // Poner en input correspondiente
            const input = document.getElementById('codeInput' + userId);
            if (input) input.value = code;

            console.log('Código generado:', code);
        });
    });
});
</script>

@endforeach






@endsection


@push('scripts')
<script>
$(document).ready(function() {


    // =========================
    // VALIDACIÓN DE EMAIL
    // =========================
    let emailTimeout;
    $('.email-input').on('input', function() {
        const $input = $(this);
        const $form = $input.closest('.form-usuario');
        const email = $input.val().trim();
        const currentEmail = $form.data('current-email');
        const userId = $form.data('user-id');
        const $feedback = $input.siblings('.email-error');
        const $checking = $input.siblings('.email-checking');

        clearTimeout(emailTimeout);

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            $input.removeClass('is-valid is-invalid');
            $checking.addClass('d-none');
            return;
        }

        if (!emailRegex.test(email)) {
            $input.addClass('is-invalid').removeClass('is-valid');
            $feedback.text('Ingrese un correo válido');
            $checking.addClass('d-none');
            return;
        }

        if (email === currentEmail) {
            $input.addClass('is-valid').removeClass('is-invalid');
            $checking.addClass('d-none');
            return;
        }

        $checking.removeClass('d-none');
        $input.removeClass('is-valid is-invalid');

        emailTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("usuarios.check-email") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    user_id: userId
                },
                success: function(response) {
                    $checking.addClass('d-none');
                    if (response.available) {
                        $input.addClass('is-valid').removeClass('is-invalid');
                    } else {
                        $input.addClass('is-invalid').removeClass('is-valid');
                        $feedback.text('Este correo ya está registrado por otro usuario');
                    }
                },
                error: function() {
                    $checking.addClass('d-none');
                    $input.removeClass('is-valid is-invalid');
                }
            });
        }, 500);
    });

    // =========================
    // TOGGLE PASSWORD
    // =========================
    $('.toggle-password').on('click', function() {
        const $btn = $(this);
        const $input = $btn.closest('.input-group').find('.password-input');
        const $icon = $btn.find('i');
        
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // =========================
    // VALIDACIÓN FORMULARIO
    // =========================
    $('.form-usuario').on('submit', function(e) {
        const $form = $(this);
        const $emailInput = $form.find('.email-input');
        const $passwordInput = $form.find('.password-input');
        const $btnGuardar = $form.find('.btn-guardar');
        let isValid = true;

        if ($emailInput.hasClass('is-invalid')) {
            e.preventDefault();
            $emailInput.focus();
            isValid = false;
        }

        const password = $passwordInput.val();
        if (password && password.length < 6) {
            e.preventDefault();
            $passwordInput.addClass('is-invalid');
            $passwordInput.focus();
            isValid = false;
        } else {
            $passwordInput.removeClass('is-invalid');
        }

        if (!isValid) {
            const $alert = $form.find('.error-alert');
            $alert.removeClass('d-none').text('Por favor corrija los errores antes de continuar');
            
            setTimeout(function() {
                $alert.addClass('d-none');
            }, 3000);
            
            return false;
        }

        $btnGuardar.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Guardando...');
    });

    // =========================
    // VALIDACIÓN PASSWORD TIEMPO REAL
    // =========================
    $('.password-input').on('input', function() {
        const $input = $(this);
        const password = $input.val();
        
        if (password === '') {
            $input.removeClass('is-valid is-invalid');
        } else if (password.length < 6) {
            $input.addClass('is-invalid').removeClass('is-valid');
        } else {
            $input.addClass('is-valid').removeClass('is-invalid');
        }
    });

    // =========================
    // AUTO-CERRAR ALERTAS
    // =========================
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

});
</script>
@endpush
