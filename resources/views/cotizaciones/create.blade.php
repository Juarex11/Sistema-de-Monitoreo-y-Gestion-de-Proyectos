@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Nueva Cotización</h4>
                    <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary btn-sm">
                        Volver
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('cotizaciones.store') }}" method="POST" id="formCotizacion">
                        @csrf

                        <!-- Información general -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Cliente *</label>
                                <select name="cliente_id" class="form-select" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre_comercial ?? $cliente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Descripción</label>
                                <input type="text" name="descripcion" class="form-control" 
                                       value="{{ old('descripcion') }}" 
                                       placeholder="Descripción general de la cotización">
                            </div>
                        </div>

                        <!-- Items de cotización -->
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Items de la Cotización</h5>
                                <button type="button" class="btn btn-success btn-sm" onclick="agregarItem()">
                                    + Agregar Item
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="items-container">
                                    <!-- Los items se agregarán aquí dinámicamente -->
                                </div>
                                
                                <div class="alert alert-info mt-3" id="noItemsAlert">
                                    <i class="bi bi-info-circle"></i> No hay items agregados. Haga clic en "Agregar Item" para comenzar.
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="row mb-3">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Total:</h5>
                                            <h4 class="mb-0 text-primary">S/ <span id="totalGeneral">0.00</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="text-end">
                            <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Guardar Cotización
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template para items (oculto) -->
<template id="itemTemplate">
    <div class="card mb-3 item-card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="mb-0">Item <span class="item-number"></span></h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarItem(this)">
                    Eliminar
                </button>
            </div>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Título *</label>
                    <input type="text" name="items[INDEX][titulo]" class="form-control" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Periodicidad *</label>
                    <select name="items[INDEX][periodicidad]" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="unico">Único</option>
                        <option value="mensual">Mensual</option>
                        <option value="anual">Anual</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="items[INDEX][descripcion]" class="form-control" rows="2"></textarea>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Precio Base *</label>
                    <div class="input-group">
                        <span class="input-group-text">S/</span>
                        <input type="number" name="items[INDEX][precio]" 
                               class="form-control precio-input" 
                               step="0.01" min="0" required 
                               onchange="calcularTotales()">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">IGV (18%)</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input igv-checkbox" 
                               type="checkbox" 
                               name="items[INDEX][igv]" 
                               value="1"
                               onchange="calcularTotales()">
                        <label class="form-check-label">Incluir IGV</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Total Item</label>
                    <div class="input-group">
                        <span class="input-group-text">S/</span>
                        <input type="text" class="form-control total-item" readonly value="0.00">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let itemIndex = 0;

function agregarItem() {
    const template = document.getElementById('itemTemplate');
    const clone = template.content.cloneNode(true);
    
    // Reemplazar INDEX con el índice actual
    const html = clone.querySelector('.item-card').outerHTML.replace(/INDEX/g, itemIndex);
    
    // Agregar al contenedor
    document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
    
    // Actualizar número de item
    const itemCards = document.querySelectorAll('.item-card');
    itemCards[itemCards.length - 1].querySelector('.item-number').textContent = itemIndex + 1;
    
    // Ocultar alerta de no items
    document.getElementById('noItemsAlert').style.display = 'none';
    
    itemIndex++;
    calcularTotales();
}

function eliminarItem(btn) {
    if (confirm('¿Está seguro de eliminar este item?')) {
        btn.closest('.item-card').remove();
        actualizarNumerosItems();
        calcularTotales();
        
        // Mostrar alerta si no hay items
        if (document.querySelectorAll('.item-card').length === 0) {
            document.getElementById('noItemsAlert').style.display = 'block';
        }
    }
}

function actualizarNumerosItems() {
    document.querySelectorAll('.item-card').forEach((card, index) => {
        card.querySelector('.item-number').textContent = index + 1;
    });
}

function calcularTotales() {
    let totalGeneral = 0;
    
    document.querySelectorAll('.item-card').forEach(card => {
        const precioInput = card.querySelector('.precio-input');
        const igvCheckbox = card.querySelector('.igv-checkbox');
        const totalItemInput = card.querySelector('.total-item');
        
        let precio = parseFloat(precioInput.value) || 0;
        let total = precio;
        
        if (igvCheckbox.checked) {
            total = precio * 1.18;
        }
        
        totalItemInput.value = total.toFixed(2);
        totalGeneral += total;
    });
    
    document.getElementById('totalGeneral').textContent = totalGeneral.toFixed(2);
}

// Validar al enviar el formulario
document.getElementById('formCotizacion').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.item-card');
    
    if (items.length === 0) {
        e.preventDefault();
        alert('Debe agregar al menos un item a la cotización');
        return false;
    }
    
    // Debug: mostrar qué se va a enviar
    console.log('Formulario enviado con', items.length, 'items');
});

// Agregar un item por defecto al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    agregarItem();
});
</script>

<style>
.item-card {
    border-left: 4px solid #0d6efd;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.card-header {
    background-color: #f8f9fa;
}
</style>
@endsection