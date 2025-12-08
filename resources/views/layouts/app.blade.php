<!DOCTYPE html>
<html>
<head>
    <title>Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>

        <div class="d-flex">
            <span class="text-white me-3">{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">Salir</a>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>
@if (session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
