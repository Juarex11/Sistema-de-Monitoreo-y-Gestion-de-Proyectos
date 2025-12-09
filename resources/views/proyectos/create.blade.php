@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Crear Proyecto</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('proyectos.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nombre del Proyecto</label>
                    <input type="text" name="nombre_proyecto" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Responsable del Proyecto</label>
                    <select name="responsable_id" class="form-select" required>
                        <option value="">Seleccione un responsable</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->rol }})</option>
                        @endforeach
                    </select>
                </div>

              

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Fecha Estimada Fin</label>
                        <input type="date" name="fecha_fin" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Prioridad</label>
                        <select name="prioridad" class="form-select">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Presupuesto Asignado (S/.)</label>
                    <input type="number" step="0.01" name="presupuesto_asignado" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Lugar</label>
                    <input type="text" name="lugar" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tipo de Proyecto</label>
                    <select name="tipo_proyecto" class="form-select">
                        <option value="consultoria">Consultoría</option>
                        <option value="capacitacion">Capacitación</option>
                        <option value="servicio">Servicio Técnico</option>
                        <option value="supervision">Supervisión</option>
                        <option value="obra">Obra</option>
                    </select>
                </div>

                <button class="btn btn-success">Guardar</button>
                <a href="{{ route('proyectos.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>

</div>
@endsection
