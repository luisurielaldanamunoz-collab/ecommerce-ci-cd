<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificacion 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 420px;">
        <h2 class="text-center mb-3">Verificacion 2FA</h2>
        <p class="text-muted text-center">Ingresa el codigo de 6 digitos enviado a tu correo.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf

            <div class="mb-3">
                <label for="codigo" class="form-label">Codigo de verificacion</label>
                <input type="text" name="codigo" id="codigo" class="form-control" maxlength="6"
                    inputmode="numeric" pattern="[0-9]{6}" value="{{ old('codigo') }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Validar codigo</button>
        </form>

        <a href="{{ route('login') }}" class="btn btn-link mt-3">Volver al login</a>
    </div>

</body>

</html>
