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

                <strong>Tareas:</strong>
                <ul>
                    @foreach($p->tareas as $t)
                        <li>{{ $t->titulo }}</li>
                    @endforeach
                </ul>
                 <div class="d-flex justify-content-between align-items-center mt-2">

    <form action="{{ route('proyectos.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este proyecto?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Eliminar</button>
    </form>
</div>
            </div>
            
        </div>
       

    @endforeach

</div>
@endsection
