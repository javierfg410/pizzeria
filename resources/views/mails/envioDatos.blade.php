<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>
    <p>Saludos! Se ha confirmado el pedido</p>
    <p>Este es un resumen de su pedido:</p>
    @foreach ($enviar["pizza"] as $pizza)
    
    <ul>
        <li>Nombre: {{ $pizza["id"] }}</li>
        <li>Precio: {{ $pizza["precio"] }}</li>
        <li>Cantidad: {{ $pizza["cantidad"] }}</li>
    </ul>
    @endforeach
    <p>Precio Total:{{ $enviar["total"] }}</p>
</body>
</html>