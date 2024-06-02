@extends('menu')

@section('content')
<div class="container">
    <h1>Nueva Venta</h1>
    <hr>    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <input type="search" class="form-control" id="searchInput" placeholder="Buscar productos">
            <h1>Productos:</h1>
            <hr>
            <div id="products">
                
            </div>
        </div>
        <div class="col-md-4">
            <h1>Registros</h1>
            <div class="items"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
    $('#searchInput').on('input', function(){
        var query = $(this).val();
        $.ajax({
            url: "{{ route('search-products')}}",
            method: 'GET',
            data: {
                q : query
            },
            success:function(reponse){
                console.log(response);
                let results = reponse.data;
                $('#products').empty();
                if(results.length > 0){
                    results.forEach(item =>{
                        $('#products').append('<div class="result-products"><div class="card m-3"><div class="card-header"><h1>' 
                            + item.nombre + 'Codigo: ' + item.codigo + '</div> <div class="card-body"> Precio:'
                            + item.nombre + 'Marca:' + item.marca + '</div></div></div>')
                    })
                } else {
                    $('#products').append('<h1>No se encontraron resultados</h1>')
                }    
            }
        });
    });
});
</script>