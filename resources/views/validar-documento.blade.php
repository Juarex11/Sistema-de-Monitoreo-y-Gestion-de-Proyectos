<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validador de Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Validador de Documentos</h2>

    {{-- Formulario --}}
    <form action="{{ route('validar.documento.post') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="code" class="form-control" placeholder="Ingrese el código del documento" required
                   value="{{ $code ?? '' }}">
            <button class="btn btn-success">Validar</button>
        </div>
    </form>

    {{-- Resultado --}}
    @if(isset($document))
        @if($document)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-success">Documento encontrado ✅</h5>
                    <p><strong>Nombre:</strong> {{ $document->name }}</p>
                    <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::parse($document->date)->format('d/m/Y') }}</p>
                    <p><strong>Subido por:</strong> {{ $document->uploaded_by }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <iframe src="{{ asset('storage/' . $document->file) }}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center">
                Certificado no encontrado ❌<br>
                Código ingresado: <strong>{{ $code }}</strong>
            </div>
        @endif
    @elseif(isset($code))
        <div class="alert alert-danger text-center">
            Certificado no encontrado ❌<br>
            Código ingresado: <strong>{{ $code }}</strong>
        </div>
    @endif
</div>

</body>
</html>
