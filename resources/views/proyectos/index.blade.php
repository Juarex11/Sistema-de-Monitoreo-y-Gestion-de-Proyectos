@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Lista de Proyectos</h3>
        <a href="{{ route('proyectos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Proyecto
        </a>
    </div>
<input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar proyectos...">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

@foreach($proyectos as $p)
                        <div class="card shadow mb-3 proyecto-card"   data-nombre="{{ $p->nombre_proyecto }}" 
         data-codigo="{{ $p->codigo }}">

                            <div class="card-body">
                                   <h5 class="card-title d-flex justify-content-between align-items-center">
    {{ $p->nombre_proyecto }}
  
    <small class="text-muted">
        {{ $p->avance }}%
    </small>
</h5>
<p>  {{ $p->codigo }}</p>
<div class="progress mb-3" style="height: 8px;">
    <div class="progress-bar 
        @if($p->avance < 40) bg-danger
        @elseif($p->avance < 70) bg-warning
        @else bg-success
        @endif"
        role="progressbar"
        style="width: {{ $p->avance }}%;">
    </div>
</div>


            <p class="card-text text-muted mb-3">
                {{ $p->descripcion }}
            </p>


                               <div class="row mb-3">

                <div class="col-md-6 mb-2">
                    <span class="fw-bold">Estado:</span>
                    <span class="badge bg-primary">
                        {{ ucfirst($p->estado) }}
                    </span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="fw-bold">Prioridad:</span>
                    <span class="badge bg-danger">
                        {{ ucfirst($p->prioridad ?? '—') }}
                    </span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="fw-bold">Fecha inicio:</span>
                    {{ $p->fecha_inicio ?? '—' }}
                </div>

                <div class="col-md-6 mb-2">

    <span class="fw-bold">Presupuesto asignado:</span>
    S/ {{ number_format($p->presupuesto_asignado ?? 0, 2) }}
    <br>

    <span class="fw-bold">Presupuesto ejecutado:</span>
    S/ {{ number_format($p->presupuesto_ejecutado ?? 0, 2) }}
    <br>

    <span class="fw-bold text-primary">Total presupuesto:</span>
    <span class="text-primary">
        S/ {{ number_format(($p->presupuesto_asignado ?? 0) + ($p->presupuesto_ejecutado ?? 0), 2) }}
    </span>

</div>


            </div>
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
                                <div class="accordion mb-3" id="accordion-{{ $p->id }}">
{{-- ACCORDION: CLIENTES --}}
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#clientes-{{ $p->id }}">
            <i class="bi bi-people me-2"></i> Clientes
        </button>
    </h2>

    <div id="clientes-{{ $p->id }}" class="accordion-collapse collapse">
        <div class="accordion-body">

            <ul class="list-group mb-3" id="lista-clientes-{{ $p->id }}">
                @foreach($p->clientes as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $c->nombre_comercial ?? $c->razon_social }}
                        <form action="{{ route('proyectos.removeCliente', [$p->id, $c->id]) }}" method="POST" 
                              onsubmit="return confirm('¿Eliminar cliente del proyecto?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>

            {{-- Agregar nuevo cliente con buscador --}}
            <form action="{{ route('proyectos.addCliente') }}" method="POST" id="form-add-cliente-{{ $p->id }}">
                @csrf
                <input type="hidden" name="proyecto_id" value="{{ $p->id }}">
                
                <div class="d-flex gap-2">
                    <div class="flex-grow-1 position-relative">
                        {{-- Input de búsqueda --}}
                        <input type="text" 
                               class="form-control cliente-search" 
                               id="search-cliente-{{ $p->id }}"
                               placeholder="Buscar cliente por nombre, RUC o código..."
                               autocomplete="off">
                        
                        {{-- Input oculto con el ID seleccionado --}}
                        <input type="hidden" name="cliente_id" id="cliente-id-{{ $p->id }}" required>
                        
                        {{-- Resultados de búsqueda --}}
                        <div class="search-results position-absolute w-100 bg-white border rounded shadow-sm" 
                             id="results-{{ $p->id }}" 
                             style="display: none; max-height: 300px; overflow-y: auto; z-index: 1000;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
.search-results {
    max-height: 300px;
    overflow-y: auto;
}

.search-result-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}

.search-result-item:hover {
    background-color: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.client-info {
    font-size: 0.9rem;
}

.client-code {
    color: #6c757d;
    font-size: 0.85rem;
}

.no-results {
    padding: 15px;
    text-align: center;
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función de búsqueda con debounce
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Configurar buscador para cada proyecto
    const searchInput = document.getElementById('search-cliente-{{ $p->id }}');
    const resultsDiv = document.getElementById('results-{{ $p->id }}');
    const hiddenInput = document.getElementById('cliente-id-{{ $p->id }}');
    const clientesAsignados = @json($p->clientes->pluck('id'));

    if (searchInput) {
        // Búsqueda con debounce
        const buscarClientes = debounce(function(termino) {
            if (termino.length < 2) {
                resultsDiv.style.display = 'none';
                return;
            }

            fetch(`/api/clientes/buscar?q=${encodeURIComponent(termino)}&excluir=${clientesAsignados.join(',')}`)
                .then(response => response.json())
                .then(data => {
                    mostrarResultados(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsDiv.innerHTML = '<div class="no-results">Error al buscar clientes</div>';
                    resultsDiv.style.display = 'block';
                });
        }, 300);

        searchInput.addEventListener('input', function() {
            buscarClientes(this.value);
        });

        // Mostrar resultados
        function mostrarResultados(clientes) {
            if (clientes.length === 0) {
                resultsDiv.innerHTML = '<div class="no-results">No se encontraron clientes</div>';
                resultsDiv.style.display = 'block';
                return;
            }

            let html = '';
            clientes.forEach(cliente => {
                html += `
                    <div class="search-result-item" data-id="${cliente.id}" data-nombre="${cliente.nombre_comercial || cliente.razon_social}">
                        <div class="fw-bold">${cliente.nombre_comercial || cliente.razon_social}</div>
                        <div class="client-info">
                            <span class="client-code">${cliente.codigo}</span>
                            ${cliente.ruc_dni ? ` | RUC/DNI: ${cliente.ruc_dni}` : ''}
                            ${cliente.ciudad ? ` | ${cliente.ciudad}` : ''}
                        </div>
                    </div>
                `;
            });

            resultsDiv.innerHTML = html;
            resultsDiv.style.display = 'block';

            // Agregar eventos de clic a cada resultado
            resultsDiv.querySelectorAll('.search-result-item').forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    
                    hiddenInput.value = id;
                    searchInput.value = nombre;
                    resultsDiv.style.display = 'none';
                });
            });
        }

        // Cerrar resultados al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                resultsDiv.style.display = 'none';
            }
        });

        // Limpiar al hacer focus
        searchInput.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                resultsDiv.style.display = 'block';
            }
        });
    }
});
</script>

    {{-- ACCORDION: TAREAS --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#tareas-{{ $p->id }}">
                <i class="bi bi-list-check me-2"></i> Checklist de Tareas
            </button>
        </h2>

        <div id="tareas-{{ $p->id }}" class="accordion-collapse collapse">
            <div class="accordion-body">

                <ul class="list-group mb-3">
                    @foreach($p->tareas as $t)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{-- Cambiar estado --}}
                            <form action="{{ route('tareas.updateEstado', $t->id) }}" 
                                  method="POST" class="d-flex align-items-center me-3">
                                @csrf
                                @method('PUT')
                                <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pendiente" {{ $t->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_progreso" {{ $t->estado === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                                    <option value="completada" {{ $t->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                                </select>
                            </form>

                            <div class="flex-grow-1">
                                <form action="{{ route('tareas.update', $t->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="titulo" class="form-control form-control-sm mb-1"
                                           value="{{ $t->titulo }}" onchange="this.form.submit()">
                                    <input type="text" name="descripcion" class="form-control form-control-sm text-muted"
                                           value="{{ $t->descripcion }}" onchange="this.form.submit()">
                                </form>
                            </div>

                            <form action="{{ route('tareas.destroy', $t->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Eliminar tarea?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                {{-- Nueva Tarea --}}
                <form action="{{ route('tareas.store') }}" method="POST" class="d-flex mb-3 gap-2">
                    @csrf
                    <input type="hidden" name="proyecto_id" value="{{ $p->id }}">
                    <input type="text" name="titulo" class="form-control" placeholder="Título de la tarea" required>
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción (opcional)">
                    <button class="btn btn-success">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- ACCORDION: PRESUPUESTOS --}}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#pres-{{ $p->id }}">
                <i class="bi bi-cash-coin me-2"></i> Presupuestos
            </button>
        </h2>

        <div id="pres-{{ $p->id }}" class="accordion-collapse collapse">
            <div class="accordion-body">

                @php
                    $total = $p->presupuestos->sum('precio');
                @endphp

                <ul class="list-group mb-3">
                    @foreach($p->presupuestos as $pres)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong>{{ $pres->nombre }}</strong><br>
                                <span class="text-muted">S/ {{ number_format($pres->precio, 2) }}</span>
                            </div>

                            <form action="{{ route('presupuestos.destroy', $pres->id) }}" 
                                  method="POST" onsubmit="return confirm('¿Eliminar presupuesto?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <div class="alert alert-primary d-flex justify-content-between">
                    <strong>Total:</strong>
                    <span>S/ {{ number_format($total, 2) }}</span>
                </div>

                {{-- Nuevo presupuesto --}}
                <form action="{{ route('presupuestos.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="proyecto_id" value="{{ $p->id }}">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                    <button class="btn btn-success">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

</div>

                           
    

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
    <input type="number" id="presupuesto_ejecutado" name="presupuesto_ejecutado" 
           class="form-control" readonly>
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
document.getElementById('buscador').addEventListener('input', function() {
    const texto = this.value.toLowerCase();
    document.querySelectorAll('.proyecto-card').forEach(card => {
        const nombre = card.dataset.nombre.toLowerCase();
        const codigo = card.dataset.codigo.toLowerCase();
        card.style.display = (nombre.includes(texto) || codigo.includes(texto)) ? '' : 'none';
    });
});

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

           document.getElementById('creado_por').value = p.creador ? p.creador.name : "";
document.getElementById('actualizado_por').value = p.actualizador ? p.actualizador.name : "";

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
