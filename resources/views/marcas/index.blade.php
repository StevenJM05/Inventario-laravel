@extends('menu')

@section('content')
    <div class="card">
        <div class="card-header text-white" style="background-color: blueviolet">
            <h1>Marcas</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <button class="btn btn text-white mb-3" data-bs-toggle="modal" data-bs-target="#createModal" style="background-color: blueviolet">Crear Marca</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $marca)
                            <tr>
                                <td>{{ $marca->id }}</td>
                                <td>{{ $marca->nombre }}</td>
                                <td>
                                    <button class="btn btn" style="border-color: blueviolet" data-bs-toggle="modal" data-bs-target="#updateModal{{ $marca->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i> Actualizar
                                    </button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $marca->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i> Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar categoria-->
                            <div class="modal fade" id="updateModal{{ $marca->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $marca->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel{{ $marca->id }}">Actualizar Marca</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('marcas.update', $marca->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $marca->nombre }}" required>
                                                </div>
                                                <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para confirmar eliminación-->
                            <div class="modal fade" id="deleteModal{{ $marca->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $marca->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $marca->id }}">Eliminar Marca</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar esta marca?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{$marcas->links()}}
            </div>
        </div>

        <!-- Modal para crear categoria-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Nueva Marca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('marcas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
