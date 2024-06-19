<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-store-alt'></i>
            <span class="logo_name">Bendicion de Dios</span>
        </div>
        <ul class="nav-links">

            {{-- Se muestra si el usuario tiene rol: Administrador --}}
            @if(auth()->check() && auth()->user()->rol->name === 'Admin')
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('dashboard') }}">Dashboard</a></li>
                </ul>
            </li>
            @endif

            {{-- Se muestra si el usuario tiene rol: Administrador o gestor--}}
            @if(auth()->check() && in_array(auth()->user()->rol->name, ['Admin', 'Gestor']))
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Inventario</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Inventario</a></li>
                    <li><a href="{{ route('categorias.index') }}">Categorias</a></li>
                    <li><a href="{{ route('marcas.index') }}">Marcas</a></li>
                    <li><a href="{{ route('unidadesMedida.index') }}">Unidades de medida</a></li>
                    <li><a href="{{ route('impuestos.index') }}">Impuestos</a></li>
                    <li><a href="{{ route('productos.index') }}">Productos</a></li>
                </ul>
            </li>
            @endif

            {{-- Se muestra si el usuario tiene rol: Administrador --}}
            @if(auth()->check() && auth()->user()->rol->name === 'Admin')
            <li>
                <a href="{{ route('users.index') }}">
                    <i class='bx bxs-user-account'></i>
                    <span class="link_name">Usuarios</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('users.index') }}">Usuarios</a></li>
                </ul>
            </li>
            @endif

            {{-- Se muestra si el usuario tiene rol: Administrador o gestor--}}
            @if(auth()->check() && in_array(auth()->user()->rol->name, ['Admin', 'Gestor']))
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bxs-truck'></i>
                        <span class="link_name">Compras</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Compras</a></li>
                    <li><a href="{{ route('compras.create') }}">Realizar una compra</a></li>
                    <li><a href="{{ route('compras.index') }}">Ver compras</a></li>
                </ul>
            </li>
            @endif

            {{-- Se muestra si el usuario tiene rol: Administrador o Vendedor--}}
            @if(auth()->check() && in_array(auth()->user()->rol->name, ['Admin', 'Vendedor']))
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bxs-cart-add'></i>
                        <span class="link_name">Ventas</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Ventas</a></li>
                    <li><a href="{{ route('ventas.create') }}">Realizar Ventas</a></li>
                    <li><a href="{{ route('ventas.index') }}">Ver ventas</a></li>
                </ul>
            </li>
            @endif

            {{-- Se muestra si el usuario tiene rol: Administrador o gestor--}}
            @if(auth()->check() && in_array(auth()->user()->rol->name, ['Admin', 'Gestor']))
            <li>
                <a href="{{ route('kardex.index') }}">
                    <i class='bx bx-line-chart'></i>
                    <span class="link_name">Control de productos</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('kardex.index') }}">Control de productos</a></li>
                </ul>
            </li>
            @endif
            <li>
                <a href="{{ route('logout') }}">
                <i class='bx bx-log-out-circle'></i>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        @yield('content')
    </section>
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>

</html>
