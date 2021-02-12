<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PIZZAS</title>

    </head>
    <body>
        <h1>Quien quiere pizza?</h1>
    @foreach($pizzas as $pizza)
        <h2>{{$pizza["nombre"]}}<h2>
            Con los siguientes ingredientes:
            @foreach($pizza["ingredientes"] as $ingrediente)
                <p>"{{$ingrediente["tipo"]}}"{{$ingrediente["nombre"]}}</p>
            @endforeach
    @endforeach
    </body>
</html>
