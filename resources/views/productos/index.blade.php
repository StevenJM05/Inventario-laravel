@extends('menu')

@section('content')
    <div class="card">
        <div class="card-header text-white" style="background-color: blueviolet">
            <h1>Productos</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Categoría</th>
                            <th>Unidad de Medida</th>
                            <th>Disponibilidad</th>
                            <th>Stock</th>
                            <th>Impuesto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->marca->nombre }}</td>
                                <td>{{ $producto->categorias->nombre }}</td>
                                <td>{{ $producto->unidad_medida->nombre }}</td>
                                <td>{{ $producto->is_available ? 'Sí' : 'No' }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>{{ $producto->impuestos->nombre }}</td>
                                <td>
                                    <button class="btn btn" style="border-color: blueviolet" data-bs-toggle="modal" data-bs-target="#updateModal{{ $producto->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i> Actualizar
                                    </button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $producto->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i> Eliminar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar producto-->
                            <div class="modal fade" id="updateModal{{ $producto->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $producto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel{{ $producto->id }}">Actualizar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código</label>
                                                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $producto->codigo }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion">{{ $producto->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="marca_id" class="form-label">Marca</label>
                                                    <select class="form-control" id="marca_id" name="marca_id" required>
                                                        @foreach ($marcas as $marca)
                                                            <option value="{{ $marca->id }}" {{ $marca->id == $producto->marca_id ? 'selected' : '' }}>{{ $marca->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="categorias_id" class="form-label">Categoría</label>
                                                    <select class="form-control" id="categorias_id" name="categorias_id" required>
                                                        @foreach ($categorias as $categoria)
                                                            <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->categorias_id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="unidad_medida_id" class="form-label">Unidad de Medida</label>
                                                    <select class="form-control" id="unidad_medida_id" name="unidad_medida_id" required>
                                                        @foreach ($unidadesMedida as $unidad)
                                                            <option value="{{ $unidad->id }}" {{ $unidad->id == $producto->unidad_medida_id ? 'selected' : '' }}>{{ $unidad->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="is_available" class="form-label">Disponibilidad</label>
                                                    <select class="form-control" id="is_available" name="is_available">
                                                        <option value="1" {{ $producto->is_available ? 'selected' : '' }}>Sí</option>
                                                        <option value="0" {{ !$producto->is_available ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="stock" class="form-label">Stock</label>
                                                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $producto->stock }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="impuestos_id" class="form-label">Impuesto</label>
                                                    <select class="form-control" id="impuestos_id" name="impuestos_id" required>
                                                        @foreach ($impuestos as $impuesto)
                                                            <option value="{{ $impuesto->id }}" {{ $impuesto->id == $producto->impuestos_id ? 'selected' : '' }}>{{ $impuesto->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para confirmar eliminación-->
                            <div class="modal fade" id="deleteModal{{ $producto->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $producto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $producto->id }}">Eliminar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este producto?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
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
                
                {{ $productos->links() }} {{-- Es para la paginacion --}}

                <button class="btn btn text-white" data-bs-toggle="modal" data-bs-target="#createModal" style="background-color: blueviolet">Crear Producto</button>
            </div>
        </div>

        <!-- Modal para crear producto-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Nuevo Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('productos.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="marca_id" class="form-label">Marca</label>
                                <select class="form-control" id="marca_id" name="marca_id" required>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="categorias_id" class="form-label">Categoría</label>
                                <select class="form-control" id="categorias_id" name="categorias_id" required>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="unidad_medida_id" class="form-label">Unidad de Medida</label>
                                <select class="form-control" id="unidad_medida_id" name="unidad_medida_id" required>
                                    @foreach ($unidadesMedida as $unidad)
                                        <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="is_available" class="form-label">Disponibilidad</label>
                                <select class="form-control" id="is_available" name="is_available">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="impuestos_id" class="form-label">Impuesto</label>
                                <select class="form-control" id="impuestos_id" name="impuestos_id" required>
                                    @foreach ($impuestos as $impuesto)
                                        <option value="{{ $impuesto->id }}">{{ $impuesto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn text-white" style="background-color: blueviolet">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
