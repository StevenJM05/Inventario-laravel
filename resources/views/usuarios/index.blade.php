@extends('menu')

@section('content')
    <div class="container m-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>Usuarios en el sistema</h1>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <button class="btn btn text-white bg-dark mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar
                    Usuario</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol del usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->rol->name }}</td>
                                <td>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $user->id }}">
                                        <i class="fa-solid fa-gears" style="color: #B197FC;"></i>
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="fa-solid fa-rectangle-xmark" style="color: #ff0000;"></i>
                                    </button>
                                    <button class="btn btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#updatePasswordModal{{ $user->id }}">
                                        <i class='bx bx-shield-alt-2'></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal para actualizar usuario --}}
                            <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="updateModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="updateModalLabel{{ $user->id }}">Actualizar
                                                Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name{{ $user->id }}" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="name{{ $user->id }}"
                                                        name="name" value="{{ $user->name }}" required>
                                                    @error('name')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email{{ $user->id }}" class="form-label">Email</label>
                                                    <input type="email" class="form-control"
                                                        id="email{{ $user->id }}" name="email"
                                                        value="{{ $user->email }}" required>
                                                    @error('email')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rol{{ $user->id }}" class="form-label">Rol del
                                                        usuario</label>
                                                    <select name="rol_id" class="form-select">
                                                        @foreach ($roles as $rol)
                                                            <option value="{{ $rol->id }}"
                                                                @if ($user->rol_id == $rol->id) selected @endif>
                                                                {{ $rol->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('rol_id')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit"
                                                    class="btn btn text-white bg-dark">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal para eliminar usuario --}}
                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Eliminar
                                                usuario</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                            <div class="modal fade" id="updatePasswordModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="updatePasswordLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="updatePasswordLabel{{ $user->id }}">
                                                Actualizar Contraseña</h5>
                                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('users.updatePassword', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="new_password{{ $user->id }}" class="form-label">Nueva
                                                        Contraseña</label>
                                                    <input type="password" class="form-control"
                                                        id="new_password{{ $user->id }}" name="new_password"
                                                        required>
                                                    @error('new_password')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password_confirmation{{ $user->id }}"
                                                        class="form-label">Confirmar Nueva Contraseña</label>
                                                    <input type="password" class="form-control"
                                                        id="new_password_confirmation{{ $user->id }}"
                                                        name="new_password_confirmation" required>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn text-white bg-dark">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- Modal para crear nuevo usuario --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="createModalLabel">Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="name"
                                value="{{ old('name') }}" required>
                            @error('nombre')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rol_id" class="form-label">Rol del usuario</label>
                            <select name="rol_id" class="form-select" required>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn text-white bg-dark">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
