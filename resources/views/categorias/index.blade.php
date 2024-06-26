@extends('menu')

@section('content')
    <div class="card m-3">
        <div class="card-header text-white bg-dark">
            <h1>Categorias</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <button class="btn btn text-white bg-dark mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Crear
                    Categoría</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $categoria->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i> Actualizar
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $categoria->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i> Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar categoria-->
                            <div class="modal fade" id="updateModal{{ $categoria->id }}" tabindex="-1"
                                aria-labelledby="updateModalLabel{{ $categoria->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="updateModalLabel{{ $categoria->id }}">Actualizar
                                                Categoría</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                                        value="{{ $categoria->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion">{{ $categoria->descripcion }}</textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn text-white bg-dark">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para confirmar eliminación-->
                            <div class="modal fade" id="deleteModal{{ $categoria->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $categoria->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $categoria->id }}">Eliminar
                                                Categoría</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $categorias->links() }}
            </div>
        </div>

        <!-- Modal para crear categoria-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="createModalLabel">Crear Nueva Categoría</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categorias.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                            <button type="submit" class="btn btn text-white bg-dark">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
