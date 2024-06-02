@extends('menu')

@section('content')
    <div class="card m-3">
        <div class="card-header text-white bg-dark">
            <h1>Impuestos</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <button class="btn btn text-white bg-dark" data-bs-toggle="modal" data-bs-target="#createModal">Crear Impuesto</button>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Porcentaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($impuestos as $impuesto)
                            <tr>
                                <td>{{ $impuesto->id }}</td>
                                <td>{{ $impuesto->nombre }}</td>
                                <td>{{ $impuesto->porcentaje }}%</td>
                                <td>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal" data-bs-target="#updateModal{{ $impuesto->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i> Actualizar
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $impuesto->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i> Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar impuesto-->
                            <div class="modal fade" id="updateModal{{ $impuesto->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $impuesto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="updateModalLabel{{ $impuesto->id }}">Actualizar Impuesto</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('impuestos.update', $impuesto->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$impuesto->nombre}}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="porcentaje" class="form-label">Porcentaje</label>
                                                    <input type="number" class="form-control" id="porcentaje" name="porcentaje" step='0.01' value="{{ $impuesto->porcentaje }}" required>
                                                </div>
                                                <button type="submit" class="btn btn text-white bg-dark">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para confirmar eliminación-->
                            <div class="modal fade" id="deleteModal{{ $impuesto->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $impuesto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $impuesto->id }}">Eliminar Impuesto</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este impuesto?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('impuestos.destroy', $impuesto->id) }}" method="POST">
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
                
                {{ $impuestos->links() }} <!-- Agregar enlaces de paginación -->

                
            </div>
        </div>

        <!-- Modal para crear impuesto-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="createModalLabel">Crear Nuevo Impuesto</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('impuestos.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="porcentaje" class="form-label">Porcentaje</label>
                                <input type="number" class="form-control" id="porcentaje" name="porcentaje" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn text-white bg-dark">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
