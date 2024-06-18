@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Ventas</h5>
                    <p class="card-text">${{ number_format($totalVentas, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Compras</h5>
                    <p class="card-text">${{ number_format($totalCompras, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Productos Disponibles</h5>
                    <p class="card-text">{{ $productosCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <p class="card-text">{{ $usuariosCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
