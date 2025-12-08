<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <h2 class="text-center mb-4">Menú Principal</h2>

    <div class="row justify-content-center">

        <!-- Tarjeta 1 -->
        <div class="col-md-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Registrarse / Login</h5>
                    <p class="card-text">Accede al sistema con tu cuenta o regístrate.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Ingresar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Opción 2</h5>
                    <p class="card-text">Aquí puedes poner otra función del sistema.</p>
                    <a href="#" class="btn btn-secondary w-100">Entrar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-md-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Opción 3</h5>
                    <p class="card-text">Aquí irá una tercera funcionalidad.</p>
                    <a href="#" class="btn btn-secondary w-100">Entrar</a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
