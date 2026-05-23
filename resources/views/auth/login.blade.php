<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 420px;">
        <h2 class="text-center mb-4">Iniciar sesión</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-info">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

</body>

</html>
