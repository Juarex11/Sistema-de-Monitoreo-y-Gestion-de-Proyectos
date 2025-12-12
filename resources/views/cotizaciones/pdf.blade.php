<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cotización {{ $cotizacion->codigo }}</title>

<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 0;
        padding: 0;
        background: #f5f6fa;
        color: #333;
        font-size: 13px;
    }

    .container {
        margin: 20px;
        background: white;
        padding: 25px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .header {
        text-align: center;
        padding-bottom: 15px;
        border-bottom: 3px solid #0d6efd;
    }

    .header h2 {
        margin: 0;
        color: #0d6efd;
        font-size: 24px;
    }

    .sub {
        text-align: center;
        margin-top: 5px;
        font-size: 14px;
        color: #555;
    }

    .section-title {
        font-size: 16px;
        margin-top: 20px;
        margin-bottom: 8px;
        font-weight: bold;
        color: #0d6efd;
        border-left: 5px solid #0d6efd;
        padding-left: 10px;
    }

    .box {
        background: #f1f3f5;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 13px;
    }

    table thead tr {
        background: #0d6efd;
        color: white;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .total-box {
        text-align: right;
        margin-top: 15px;
        padding: 12px;
        font-size: 18px;
        font-weight: bold;
        background: #e7f1ff;
        border-left: 5px solid #0d6efd;
    }

</style>
</head>
<body>

<div class="container">

    <div class="header">
        <h2>COTIZACIÓN</h2>
        <div class="sub">Código: {{ $cotizacion->codigo }}</div>
        <div class="sub">Estado: {{ ucfirst($cotizacion->estado) }}</div>
    </div>

    <!-- Cliente -->
    <div class="section-title">Cliente</div>
    <div class="box">
        {{ $cotizacion->cliente->nombre_comercial ?? $cotizacion->cliente->name }}
    </div>

    <!-- Fecha -->
    <div class="section-title">Fecha de creación</div>
    <div class="box">
        {{ $cotizacion->created_at->format('d/m/Y') }}
    </div>

    <!-- Descripción -->
    <div class="section-title">Descripción</div>
    <div class="box">
        {{ $cotizacion->descripcion }}
    </div>

    <!-- Ítems -->
    <div class="section-title">Ítems incluidos</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Tipo Pago</th>
                <th>Precio</th>
                <th>IGV</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotizacion->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->titulo }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ ucfirst($item->tipo_pago) }}</td>
                    <td>S/ {{ number_format($item->precio, 2) }}</td>
                    <td>{{ $item->aplica_igv ? 'Sí' : 'No' }}</td>
                    <td><strong>S/ {{ number_format($item->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total General -->
    <div class="total-box">
        Total General: S/ {{ number_format($cotizacion->total, 2) }}
    </div>

</div>

</body>
</html>
