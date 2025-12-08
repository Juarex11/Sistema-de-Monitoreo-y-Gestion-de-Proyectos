<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>

<h2>Crear cuenta</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Registrar</button>
</form>

<a href="{{ route('login') }}">Ir al login</a>

</body>
</html>
