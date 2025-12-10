@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Lista de Proyectos</h3>
        <a href="{{ route('proyectos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Proyecto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

@foreach($proyectos as $p)
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <h5>{{ $p->nombre_proyecto }}</h5>
                                <p>{{ $p->descripcion }}</p>

                                <p><strong>Responsable:</strong> {{ $p->responsable->name ?? 'Sin responsable asignado' }}</p>
<div class="d-flex gap-2 mb-2">

<button 
    class="btn btn-info btn-sm"
    onclick="cargarProyecto({{ $p->id }})"
    data-bs-toggle="modal"
    data-bs-target="#modalProyecto"
>
    <i class="bi bi-eye"></i> Ver info
</button>


</div>

                                <hr>
                                <h6><i class="bi bi-list-check"></i> Checklist de Tareas</h6>

                                <ul class="list-group mb-3">
                                    @foreach($p->tareas as $t)
                                <li class="list-group-item d-flex justify-content-between align-items-center">

                        {{-- Cambiar estado --}}
                        <form action="{{ route('tareas.updateEstado', $t->id) }}" method="POST" class="d-flex align-items-center w-auto me-3">
                            @csrf
                            @method('PUT')

                            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pendiente" {{ $t->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_progreso" {{ $t->estado === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                                <option value="completada" {{ $t->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                            </select>
                        </form>

                        <div class="flex-grow-1">

                            {{-- EDITAR TÍTULO Y DESCRIPCIÓN --}}
                            <form action="{{ route('tareas.update', $t->id) }}" method="POST" class="w-100">
                                @csrf
                                @method('PUT')

                                <input 
                                    type="text" 
                                    name="titulo"
                                    class="form-control form-control-sm mb-1"
                                    value="{{ $t->titulo }}"
                                    onchange="this.form.submit()"
                                >

                                <input 
                                    type="text" 
                                    name="descripcion"
                                    class="form-control form-control-sm text-muted"
                                    value="{{ $t->descripcion }}"
                                    placeholder="Descripción (opcional)"
                                    onchange="this.form.submit()"
                                >
                            </form>

                        </div>

                        {{-- Botón eliminar --}}
                        <form action="{{ route('tareas.destroy', $t->id) }}" method="POST" onsubmit="return confirm('¿Eliminar tarea?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger ms-2">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>

                    </li>


                @endforeach
            </ul>

            {{-- Agregar nueva tarea --}}
            <form action="{{ route('tareas.store') }}" method="POST" class="d-flex mb-3">
                @csrf
                <input type="hidden" name="proyecto_id" value="{{ $p->id }}">
<div class="d-flex gap-2 w-100">
    <input type="text" name="titulo" class="form-control" placeholder="Título de la tarea" required>
    <input type="text" name="descripcion" class="form-control" placeholder="Descripción (opcional)">
    <button class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
    </button>
</div>

            </form>

            <div class="d-flex justify-content-end">
                <form action="{{ route('proyectos.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este proyecto?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar proyecto</button>
                </form>
            </div>

        </div>
    </div>
@endforeach
<!-- MODAL ÚNICO -->
<div class="modal fade" id="modalProyecto" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="formProyecto" class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Editar Proyecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row g-3">

        <!-- SOLO LECTURA -->
        <div class="col-md-4">
            <label>ID</label>
            <input id="id" class="form-control" readonly>
        </div>

        <div class="col-md-4">
            <label>Código</label>
            <input id="codigo" class="form-control" readonly>
        </div>

        <!-- nombre_proyecto -->
        <div class="col-md-12">
            <label>Nombre del Proyecto</label>
            <input id="nombre_proyecto" name="nombre_proyecto" class="form-control" required>
        </div>

        <!-- descripcion -->
        <div class="col-md-12">
            <label>Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
        </div>

        <!-- responsable -->
        <div class="col-md-6">
            <label>Responsable</label>
            <select id="responsable_id" name="responsable_id" class="form-select">
                @foreach(\App\Models\User::where('estado','activo')->get() as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- cliente_id -->
        <div class="col-md-6">
            <label>ID Cliente</label>
            <input id="cliente_id" name="cliente_id" class="form-control">
        </div>

        <!-- estado -->
        <div class="col-md-4">
            <label>Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="pendiente">Pendiente</option>
                <option value="en_progreso">En progreso</option>
                <option value="finalizado">Finalizado</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>

        <!-- fechas -->
        <div class="col-md-4">
            <label>Fecha Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Fecha Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Fecha Cierre Real</label>
            <input type="date" id="fecha_cierre_real" name="fecha_cierre_real" class="form-control">
        </div>

        <!-- presupuesto -->
        <div class="col-md-4">
            <label>Presupuesto Asignado</label>
            <input type="number" id="presupuesto_asignado" name="presupuesto_asignado" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Presupuesto Ejecutado</label>
            <input type="number" id="presupuesto_ejecutado" name="presupuesto_ejecutado" class="form-control">
        </div>

        <!-- lugar -->
        <div class="col-md-6">
            <label>Lugar</label>
            <input id="lugar" name="lugar" class="form-control">
        </div>

        <!-- tipo_proyecto -->
        <div class="col-md-6">
            <label>Tipo de Proyecto</label>
            <input id="tipo_proyecto" name="tipo_proyecto" class="form-control">
        </div>

        <!-- prioridad -->
        <div class="col-md-6">
            <label>Prioridad</label>
            <select id="prioridad" name="prioridad" class="form-select">
                <option value="alta">Alta</option>
                <option value="media">Media</option>
                <option value="baja">Baja</option>
            </select>
        </div>

        <!-- creado por & actualizado por -->
        <div class="col-md-6">
            <label>Creado Por</label>
            <input id="creado_por" class="form-control" readonly>
        </div>

        <div class="col-md-6">
            <label>Actualizado Por</label>
            <input id="actualizado_por" class="form-control" readonly>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>

    </form>
  </div>
</div>

<script>
function cargarProyecto(id) {
    fetch(`/proyectos/${id}/data`)
        .then(res => res.json())
        .then(p => {

            document.getElementById('id').value = p.id;
            document.getElementById('codigo').value = p.codigo;

            document.getElementById('nombre_proyecto').value = p.nombre_proyecto;
            document.getElementById('descripcion').value = p.descripcion ?? "";

            document.getElementById('responsable_id').value = p.responsable_id;
            document.getElementById('cliente_id').value = p.cliente_id ?? "";

            document.getElementById('estado').value = p.estado;

            document.getElementById('fecha_inicio').value = p.fecha_inicio ?? "";
            document.getElementById('fecha_fin').value = p.fecha_fin ?? "";
            document.getElementById('fecha_cierre_real').value = p.fecha_cierre_real ?? "";

            document.getElementById('presupuesto_asignado').value = p.presupuesto_asignado ?? "";
            document.getElementById('presupuesto_ejecutado').value = p.presupuesto_ejecutado ?? "";

            document.getElementById('lugar').value = p.lugar ?? "";
            document.getElementById('tipo_proyecto').value = p.tipo_proyecto ?? "";
            document.getElementById('prioridad').value = p.prioridad ?? "";

            document.getElementById('creado_por').value = p.creado_por;
            document.getElementById('actualizado_por').value = p.actualizado_por ?? "";
        });
}

document.getElementById('formProyecto').addEventListener('submit', function(e) {
    e.preventDefault();

    let id = document.getElementById('id').value;
    let formData = new FormData(this);

    fetch(`/proyectos/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
    })
    .then(res => res.json())
    .then(resp => {
        alert(resp.message);
        location.reload();
    });
});
</script>


</div>
@endsection
