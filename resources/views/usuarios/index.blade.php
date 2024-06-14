@extends('menu')

@section('content')
    <div class="container m-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Usuarios en el sistema
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol del usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
