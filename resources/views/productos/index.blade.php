@extends('menu')

@section('content')
    <div class="card m-3">
        <div class="card-header text-white bg-dark">
            <h1>Productos</h1>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <button class="btn btn text-white bg-dark" data-bs-toggle="modal" data-bs-target="#createModal">Crear
                    Producto</button>
                <hr>
                <table class="table table-bordered">
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
                            <th>Precio</th>
                            <th>Precio total</th>
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
                                <td>{{ $producto->marca?->nombre ?? 'N/A' }}</td>
                                <td>{{ $producto->categorias?->nombre ?? 'N/A' }}</td>
                                <td>{{ $producto->unidad_medida?->nombre ?? 'N/A' }}</td>
                                <td>{{ $producto->is_available ? 'Sí' : 'No' }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>{{ $producto->impuestos?->nombre ?? 'N/A' }}-({{ $producto->impuestos?->porcentaje ?? 'N/A' }}%)
                                </td>
                                <td>{{ $producto->precio}}</td>
                                <td> {{ $producto->precio + ($producto->precio * ($producto->impuestos->porcentaje / 100))}}</td>
                                <td>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $producto->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i>
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $producto->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal para actualizar producto-->
                            <div class="modal fade" id="updateModal{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="updateModalLabel{{ $producto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="updateModalLabel{{ $producto->id }}">Actualizar
                                                Producto</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="codigo" class="form-label">Código</label>
                                                            <input type="text" class="form-control" id="codigo"
                                                                name="codigo" value="{{ $producto->codigo }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nombre" class="form-label">Nombre</label>
                                                            <input type="text" class="form-control" id="nombre"
                                                                name="nombre" value="{{ $producto->nombre }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descripcion" class="form-label">Descripción</label>
                                                            <textarea class="form-control" id="descripcion" name="descripcion">{{ $producto->descripcion }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="marca_id" class="form-label">Marca</label>
                                                            <select class="form-control" id="marca_id" name="marca_id"
                                                                required>
                                                                @foreach ($marcas as $marca)
                                                                    <option value="{{ $marca->id }}"
                                                                        {{ $marca->id == $producto->marca_id ? 'selected' : '' }}>
                                                                        {{ $marca->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="precio" class="form-label">Precio</label>
                                                            <input class="form-control" type="number" step="0.01" name="precio" id="precio" value="{{ $producto->precio}}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="categorias_id" class="form-label">Categoría</label>
                                                            <select class="form-control" id="categorias_id"
                                                                name="categorias_id" required>
                                                                @foreach ($categorias as $categoria)
                                                                    <option value="{{ $categoria->id }}"
                                                                        {{ $categoria->id == $producto->categorias_id ? 'selected' : '' }}>
                                                                        {{ $categoria->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="unidad_medida_id" class="form-label">Unidad de
                                                                Medida</label>
                                                            <select class="form-control" id="Unidad_medida_id"
                                                                name="unidad_medida_id" required>
                                                                @foreach ($unidad_medida as $unidadMedida)
                                                                    <option value="{{ $unidadMedida->id }}"
                                                                        {{ $unidadMedida->id == $producto->unidad_medida_id ? 'selected' : '' }}>
                                                                        {{ $unidadMedida->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="impuesto_id" class="form-label">Impuesto</label>
                                                            <select class="form-control" id="impuesto_id" name="impuesto_id"
                                                                required>
                                                                @foreach ($impuestos as $impuesto)
                                                                    <option value="{{ $impuesto->id }}"
                                                                        {{ $impuesto->id == $producto->impuesto_id ? 'selected' : '' }}>
                                                                        {{ $impuesto->nombre }}
                                                                        ({{ $impuesto->porcentaje }}%)
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="is_available"
                                                                class="form-label">Disponibilidad</label>
                                                            <select class="form-control" id="is_available"
                                                                name="is_available" required>
                                                                <option value="1"
                                                                    {{ $producto->is_available ? 'selected' : '' }}>Sí
                                                                </option>
                                                                <option value="0"
                                                                    {{ !$producto->is_available ? 'selected' : '' }}>No
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="stock" class="form-label">Stock</label>
                                                            <input type="number" class="form-control" id="stock"
                                                                name="stock" value="{{ $producto->stock }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-dark">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para eliminar producto-->
                            <div class="modal fade" id="deleteModal{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $producto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $producto->id }}">Eliminar
                                                Producto</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <p>¿Está seguro de que desea eliminar este producto?</p>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $productos->links()}}
            </div>
        </div>
    </div>

    <!-- Modal para crear producto-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="createModalLabel">Crear Producto</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
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
                                    <label for="precio" class="form-label">Precio</label>
                                    <input class="form-control" type="number" step="0.01" name="precio" id="precio">
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                    <select class="form-control" id="unidad_medida_id" name="Unidad_medida_id" required>
                                        @foreach ($unidad_medida as $unidadMedida)
                                            <option value="{{ $unidadMedida->id }}">{{ $unidadMedida->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="impuesto_id" class="form-label">Impuesto</label>
                                    <select class="form-control" id="impuesto_id" name="impuesto_id" required>
                                        @foreach ($impuestos as $impuesto)
                                            <option value="{{ $impuesto->id }}">{{ $impuesto->nombre }}
                                                ({{ $impuesto->porcentaje }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="is_available" class="form-label">Disponibilidad</label>
                                    <select class="form-control" id="is_available" name="is_available" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
