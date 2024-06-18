@extends('menu')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Compras realizadas</h1>
            </div>
            <div class="card-body">
                <!-- Formulario de búsqueda -->
                <form action="{{ route('compras.buscar') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_fin" class="form-label">Fecha de fin:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
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
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Productos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>{{ $compra->id }}</td>
                                <td>{{ $compra->cantidad }}</td>
                                <td>{{ $compra->subtotal }}</td>
                                <td>{{ $compra->descuento }}</td>
                                <td>{{ $compra->total }}</td>
                                <td>
                                    <button type="button" class="btn btn-success show-products" data-id="{{ $compra->id }}" data-bs-toggle="modal" data-bs-target="#productsModal">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $compras->appends(request()->input())->links() }} <!-- Mantener los parámetros de búsqueda al paginar -->
            </div>
        </div>

        <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title" id="productsModalLabel">Productos de la compra</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Producto</td>
                                    <td>Cantidad</td>
                                    <td>Precio Unidad</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody id="modal-products-body">
                                <!-- Los productos de la compra se insertarán aquí -->
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
            var compraId = $(this).data('id');
            $.ajax({
                url: '/compras/' + compraId,
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
                                    '<td>' + item.precio_unitario + '</td>' +
                                    '<td>' + item.total + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        productsBody.append('<tr><td colspan="4" class="text-center">No hay productos</td></tr>');
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
