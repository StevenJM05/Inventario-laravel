<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Factura</h1>
        <p><strong>Cliente:</strong> {{ $factura->cliente }}</p>
        <p><strong>Número de factura:</strong> {{ $factura->numero_factura }}</p>
        <p><strong>Fecha:</strong> {{ $factura->fecha }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unidad</th>
                <th>Impuesto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->ventas_items as $item)
                <tr>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->precio_unidad }}</td>
                    <td>{{ $item->impuesto }}%</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Subtotal:</strong> {{ number_format($venta->subtotal, 2) }}</p>
    <p><strong>Descuentos Totales:</strong> {{ number_format($venta->descuentos_totales, 2) }}</p>
    <p><strong>Impuestos:</strong> {{ number_format($venta->total_impuestos, 2) }}</p>
    <p><strong>Total:</strong> {{ $venta->total }}</p>
</body>

</html>
