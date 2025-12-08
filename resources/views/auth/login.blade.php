<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Iniciar sesión</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Entrar</button>
</form>

<p>Si necesitas una cuenta, pídele al administrador que te registre.</p>


</body>
</html>
