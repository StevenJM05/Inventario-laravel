@extends('menu')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Nueva Venta</h1>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <input type="search" class="form-control" id="searchInput" placeholder="Buscar productos">
                        <h1>Productos:</h1>
                        <hr>
                        <div id="products" class="d-flex flex-wrap"></div>
                        <div id="pagination" class="mt-3"></div>
                    </div>
                    <div class="col-md-4">
                        <h1>Productos seleccionados:</h1>
                        <div class="items"></div>
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
                                        '<div class="card m-3" style="width: 18rem;">' +
                                        '<div class="card-header">' +
                                        '<h1>' + item.nombre + '</h1>' +
                                        '<p>Código: ' + item.codigo + '</p>' +
                                        '</div>' +
                                        '<div class="card-body">' +
                                        '<p>Precio: ' + item.nombre + '</p>' +
                                        '<p>Marca: ' + item.nombre + '</p>' +
                                        '<button class="btn btn-primary select-product" data-id="' +
                                        item.id + '" data-nombre="' + item.nombre +
                                        '" data-codigo="' + item.codigo + '" data-precio="' +
                                        item.nombre + '">Seleccionar</button>' +
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
                        pagination += '<button class="btn btn-secondary mr-2" data-page="' + (response.current_page -
                            1) + '">Anterior</button>';
                    }
                    if (response.current_page < response.last_page) {
                        pagination += '<button class="btn btn-secondary" data-page="' + (response.current_page + 1) +
                            '">Siguiente</button>';
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

                    $('.items').append(
                        '<div class="selected-product" data-id="' + productId + '">' +
                        '<p>Nombre: ' + productNombre + '</p>' +
                        '<p>Código: ' + productCodigo + '</p>' +
                        '<p>Precio: ' + productPrecio + '</p>' +
                        '<button class="btn btn-danger remove-product" data-id="' + productId +
                        '">Eliminar</button>' +
                        '</div>'
                    );
                });

                $(document).on('click', '.remove-product', function() {
                    let productId = $(this).data('id');
                    $('.selected-product[data-id="' + productId + '"]').remove();
                });
            });
        </script>
    @endsection
