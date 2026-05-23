<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Compra validada</title>
</head>

<body>
    <h2>Tu compra fue validada</h2>

    <p>La venta de tu producto fue validada exitosamente.</p>

    <p><strong>Producto:</strong> {{ $venta->producto->nombre ?? 'N/A' }}</p>
    <p><strong>Correo del vendedor:</strong> {{ $venta->vendedor->correo ?? 'N/A' }}</p>

    <p><strong>Instruccion de contacto:</strong> Ponte en contacto con el vendedor por correo para coordinar entrega,
        horario o dudas del pedido.</p>
</body>

</html>
