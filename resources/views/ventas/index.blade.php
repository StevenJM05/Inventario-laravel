@extends('menu')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Ventas realizadas</h1>
            </div>
            <div class="card-body">
                <!-- Formulario de búsqueda -->
                <form action="{{ route('ventas.buscar') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_fin" class="form-label">Fecha de fin:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="codigo_factura" class="form-label">Código de factura:</label>
                            <input type="text" id="codigo_factura" name="codigo_factura" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary mt-4">Buscar</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vendedor</th>
                            <th>Cantidad de productos</th>
                            <th>Subtotal</th>
                            <th>Descuentos Totales</th>
                            <th>Impuestos</th>
                            <th>Total</th>
                            <th>Productos</th>
                            <th>Factura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->user->name }}</td>
                                <td>{{ $venta->cantidad_total }}</td>
                                <td>{{ $venta->subtotal }}</td>
                                <td>{{ $venta->descuentos_totales }}</td>
                                <td>{{ $venta->total_impuestos }}</td>
                                <td>{{ $venta->total }}</td>
                                <td>
                                    <button type="button" class="btn btn-success show-products" data-id="{{ $venta->id }}" data-bs-toggle="modal" data-bs-target="#productsModal">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('ventas.factura.pdf', $venta->id) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-receipt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $ventas->appends(request()->input())->links() }} <!-- Mantener los parámetros de búsqueda al paginar -->
            </div>
        </div>

        <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title" id="productsModalLabel">Productos de la venta</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Producto</td>
                                    <td>Cantidad</td>
                                    <td>Precio Unidad</td>
                                    <td>Impuesto</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody id="modal-products-body">
                                <!-- Los productos de la venta se insertarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.show-products').on('click', function() {
            var ventaId = $(this).data('id');
            $.ajax({
                url: '/ventas/' + ventaId,
                method: 'GET',
                success: function(response) {
                    console.log(response); 
                    var productsBody = $('#modal-products-body');
                    productsBody.empty();
                    if (response.length > 0) {
                        response.forEach(function(item) {
                            productsBody.append(
                                '<tr>' +
                                    '<td>' + item.nombre_producto + '</td>' +
                                    '<td>' + item.cantidad + '</td>' +
                                    '<td>' + item.precio_unidad + '</td>' +
                                    '<td>' + item.impuesto + '%</td>' +
                                    '<td>' + item.total + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        productsBody.append('<tr><td colspan="5" class="text-center">No hay productos</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); 
                }
            });
        });
    });
</script>
@endsection
