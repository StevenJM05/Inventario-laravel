@extends('menu')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Nueva Venta</h1>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <input type="search" class="form-control" id="searchInput" placeholder="Buscar productos">
                        <h1>Productos:</h1>
                        <hr>
                        <div id="products" class="d-flex flex-wrap"></div>
                        <div id="pagination" class="mt-3"></div>
                    </div>
                    <div class="col-md-6 border">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nombrecliente" class="form-label">Nombre del cliente</label>
                                <input type="text" class="form-control" placeholder="Nombre del cliente" id="nombrecliente">
                            </div>
                            <h5>Productos seleccionados:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unidad</th>
                                        <th>Impuesto</th>
                                        <th>Total</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody class="items">
                                </tbody>
                            </table>
                            <div>Total: $<span id="total">0.00</span></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    function fetchProducts(query, page = 1) {
        $.ajax({
            url: "{{ route('search-products') }}",
            method: 'GET',
            data: {
                q: query,
                page: page
            },
            success: function(response) {
                console.log(response);

                let results = response.data;
                $('#products').empty();
                if (results.length > 0) {
                    results.forEach(item => {
                        $('#products').append(
                            '<div class="result-products">' +
                            '<div class="card m-3" style="width: 14rem;">' +
                            '<div class="card-header bg-dark text-white">' +
                            '<h3>' + item.nombre + '</h3>' +
                            '</div>' +
                            '<div class="card-body">' +
                            '<p>Código: ' + item.codigo + '</p>' +
                            '<p>Precio: ' + item.precio + '</p>' +
                            '<p>Marca: ' + item.marca.nombre + '</p>' +
                            '<p>Impuesto: ' + item.impuestos.porcentaje + '%</p>' +
                            '<p>Cantidad existente: ' + item.stock + '</p>' +
                            '<button class="btn btn-primary select-product" data-id="' + item.id +
                            '" data-nombre="' + item.nombre + '" data-codigo="' + item.codigo +
                            '" data-precio="' + item.precio + '" data-impuesto="' + item.impuestos.porcentaje + 
                            '">Seleccionar</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                    renderPagination(response);
                } else {
                    $('#products').append('<h1>No se encontraron resultados</h1>');
                }
            }
        });
    }

    function renderPagination(response) {
        let pagination = '';
        if (response.current_page > 1) {
            pagination += '<button class="btn btn-secondary mr-2" data-page="' + (response.current_page - 1) + '">Anterior</button>';
        }
        if (response.current_page < response.last_page) {
            pagination += '<button class="btn btn-secondary" data-page="' + (response.current_page + 1) + '">Siguiente</button>';
        }
        $('#pagination').html(pagination);
    }

    $('#searchInput').on('input', function() {
        var query = $(this).val();
        fetchProducts(query);
    });

    $(document).on('click', '#pagination button', function() {
        var page = $(this).data('page');
        var query = $('#searchInput').val();
        fetchProducts(query, page);
    });

    $(document).on('click', '.select-product', function() {
        let productId = $(this).data('id');
        let productNombre = $(this).data('nombre');
        let productCodigo = $(this).data('codigo');
        let productPrecio = $(this).data('precio');
        let impuesto = $(this).data('impuesto');

        // Verificar si el producto ya está en la tabla
        let existingRow = $('.items tr[data-id="' + productId + '"]');

        if (existingRow.length > 0) {
            // Si el producto ya está en la tabla, aumentar la cantidad
            let quantityInput = existingRow.find('.quantity');
            let newQuantity = parseInt(quantityInput.val()) + 1;
            quantityInput.val(newQuantity);

            // Actualizar el total para esa fila con impuesto
            let totalWithoutTax = newQuantity * productPrecio;
            let totalWithTax = totalWithoutTax * (1 + impuesto / 100);
            existingRow.find('.total').text(totalWithTax.toFixed(2));
        } else {
            // Si el producto no está en la tabla, añadir una nueva fila
            let totalWithoutTax = productPrecio;
            let totalWithTax = totalWithoutTax * (1 + impuesto / 100);

            $('.items').append(
                '<tr class="selected-product" data-id="' + productId + '">' +
                '<td>' + productNombre + '</td>' +
                '<td><input type="number" class="form-control quantity" min="1" value="1" data-precio="' + productPrecio + '" data-impuesto="' + impuesto + '"></td>' +
                '<td>' + productPrecio + '</td>' +
                '<td>' + impuesto + '%</td>' +
                '<td class="total">' + totalWithTax.toFixed(2) + '</td>' +
                '<td><button class="btn btn-danger remove-product" data-id="' + productId + '">Eliminar</button></td>' +
                '</tr>'
            );
        }

        updateTotal();
    });

    $(document).on('click', '.remove-product', function() {
        let productId = $(this).data('id');
        $('.selected-product[data-id="' + productId + '"]').remove();
        updateTotal();
    });

    $(document).on('input', '.quantity', function() {
        let quantity = $(this).val();
        let price = $(this).data('precio');
        let impuesto = $(this).data('impuesto');
        let totalWithoutTax = quantity * price;
        let totalWithTax = totalWithoutTax * (1 + impuesto / 100);
        $(this).closest('tr').find('.total').text(totalWithTax.toFixed(2));
        updateTotal();
    });

    function updateTotal() {
        let total = 0;
        $('.total').each(function() {
            total += parseFloat($(this).text());
        });
        $('#total').text(total.toFixed(2));
    }
});
</script>
@endsection
