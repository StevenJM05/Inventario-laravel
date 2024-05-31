@extends('menu')

@section('content')
    <div class="card m-3">
        <div class="card-header text-white" style="background-color: rgb(0, 0, 0)">
            <h1>Unidades de Medida</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <button class="btn btn text-white bg-dark mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Crear Unidad de Medida</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unidadesMedida as $unidadMedida)
                            <tr>
                                <td>{{ $unidadMedida->id }}</td>
                                <td>{{ $unidadMedida->nombre }}</td>
                                <td>{{ $unidadMedida->prefijo }}</td>
                                <td>
                                    <button class="btn btn bg-dark text-white"  data-bs-toggle="modal" data-bs-target="#updateModal{{ $unidadMedida->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i> Actualizar
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $unidadMedida->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i> Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar unidad de medida-->
                            <div class="modal fade" id="updateModal{{ $unidadMedida->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $unidadMedida->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-white bg-dark">
                                            <h5 class="modal-title" id="updateModalLabel{{ $unidadMedida->id }}">Actualizar Unidad de Medida</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('unidadesMedida.update', $unidadMedida->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $unidadMedida->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="prefijo" class="form-label">Prefijo</label>
                                                    <input type="text" class="form-control" id="prefijo" name="prefijo" value="{{ $unidadMedida->prefijo }}" required>
                                                </div>
                                                <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para confirmar eliminación-->
                            <div class="modal fade" id="deleteModal{{ $unidadMedida->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $unidadMedida->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-white bg-dark">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $unidadMedida->id }}">Eliminar Unidad de Medida</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar esta unidad de medida?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('unidadesMedida.destroy', $unidadMedida->id) }}" method="POST">
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
                
                {{ $unidadesMedida->links() }} {{-- Es para la paginacion --}}
            </div>
        </div>

        <!-- Modal para crear unidad de medida-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title" id="createModalLabel">Crear Nueva Unidad de Medida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('unidadesMedida.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="prefijo" class="form-label">Prefijo</label>
                                <input type="text" class="form-control" id="prefijo" name="prefijo" required>
                            </div>
                            <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
