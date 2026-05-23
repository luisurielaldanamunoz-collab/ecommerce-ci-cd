<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    @php
        $homeRoute = auth()->check() && auth()->user()->esAdministrador() ? route('dashboard') : route('ventas.index');
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ $homeRoute }}">Mi Sistema Laravel</a>

            @auth
                <div class="d-flex gap-2 flex-wrap">
                    @can('viewDashboard', App\Models\Usuario::class)
                        <a class="btn btn-outline-light btn-sm" href="{{ route('dashboard') }}">Dashboard</a>
                    @endcan

                    @can('create', App\Models\Usuario::class)
                        <a class="btn btn-outline-light btn-sm" href="{{ route('usuarios.create') }}">Usuarios</a>
                    @endcan

                    <a class="btn btn-outline-light btn-sm" href="{{ route('productos.index') }}">Productos</a>

                    @if (in_array(auth()->user()->rol, ['administrador', 'gerente']))
                        <a class="btn btn-outline-light btn-sm" href="{{ route('categorias.index') }}">Categorías</a>
                    @endif

                    @can('viewAny', App\Models\Venta::class)
                        <a class="btn btn-outline-light btn-sm" href="{{ route('ventas.index') }}">Ventas</a>
                    @endcan

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <div class="container py-4">
        @auth
            <div class="alert alert-secondary shadow-sm">
                <strong>Usuario:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}
                <br>
                <strong>Rol:</strong> {{ ucfirst(auth()->user()->rol) }}
            </div>
        @endauth

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
