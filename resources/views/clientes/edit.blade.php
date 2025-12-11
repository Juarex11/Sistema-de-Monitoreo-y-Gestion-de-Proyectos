@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3><i class="bi bi-pencil-square"></i> Editar Cliente</h3>

    <div class="card shadow mt-3">
        <div class="card-body">

            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('clientes.form')

                <button class="btn btn-success mt-3">
                    <i class="bi bi-check-circle"></i> Actualizar
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
