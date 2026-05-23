<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Venta validada</title>
</head>

<body>
    <h2>Venta validada</h2>

    <p>Tu venta ha sido validada correctamente.</p>

    <p><strong>Producto vendido:</strong> {{ $venta->producto->nombre ?? 'N/A' }}</p>

    <h3>Datos del comprador</h3>
    <ul>
        <li>Nombre: {{ $venta->cliente->nombre ?? 'N/A' }} {{ $venta->cliente->apellidos ?? '' }}</li>
        <li>Correo: {{ $venta->cliente->correo ?? 'N/A' }}</li>
    </ul>

    <p>Total: ${{ number_format($venta->total, 2) }}</p>
</body>

</html>
