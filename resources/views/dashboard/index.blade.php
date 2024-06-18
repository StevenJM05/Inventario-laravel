@extends('menu')

@section('content')
    <div class="container mt-4 justify-content-center">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Dashboard</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #021D40">
                                <h5 class="card-title">Total Ventas</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">${{ number_format($totalVentas, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #053959">
                                <h5 class="card-title">Total Compras</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">${{ number_format($totalCompras, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #032859">
                                <h5 class="card-title">Productos Disponibles</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $productosCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #021D40">
                                <h5 class="card-title">Usuarios Registrados</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $usuariosCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <canvas id="ventasComprasChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title">Productos Recién Agregados</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productosRecientes as $producto)
                                            <tr>
                                                <th scope="row">{{ $producto->id }}</th>
                                                <td>{{ $producto->nombre }}</td>
                                                <td>${{ $producto->precio }}</td>
                                                <td>{{ $producto->stock }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('ventasComprasChart').getContext('2d');
            var ventasComprasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Ventas', 'Compras'],
                    datasets: [{
                        label: 'Total en USD',
                        data: [{{ $totalVentas }}, {{ $totalCompras }}],
                        backgroundColor: [
                            'rgba(31, 25, 149, 0.4)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
