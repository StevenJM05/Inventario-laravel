@extends('menu')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white bg-dark">
                <h1>Control de productos</h1>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('kardex.index') }}">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Buscar producto"
                            value="{{ request()->input('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th>Tipo Movimiento</th>
                            <th>Stock Anterior</th>
                            <th>Stock Actual</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kardexEntries as $entry)
                            <tr>
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->producto->nombre }}</td>
                                <td>{{ $entry->cantidad }}</td>
                                <td>{{ $entry->precio_unitario }}</td>
                                <td>{{ $entry->total }}</td>
                                <td>{{ $entry->tipo_movimiento }}</td>
                                <td>{{ $entry->stock_anterior }}</td>
                                <td>{{ $entry->stock_actual }}</td>
                                <td>{{ $entry->fecha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $kardexEntries->links() }}
            </div>
        </div>
    </div>
@endsection
