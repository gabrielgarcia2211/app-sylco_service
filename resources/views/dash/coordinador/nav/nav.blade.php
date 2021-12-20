<header class="navbar sticky-top flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" style="font-family: 'Staatliches', cursive; font-size: 25px;">SYLCO SAS</a>
    <button style="border-color: #ffba08;" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg style="color: #ffba08;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
    </button>
    <div class="form-control w-100"></div>
    <div class="navbar-nav">
        <div class="text-nowrap">
            <a class="nav-link px-3" href="index.html">Cerrar Sesion</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-4">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('coordinador.contratista.list')}}">
                            <span data-feather="home"></span> Contratistas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('coordinador.contratista.file')}}">
                            <span data-feather="shopping-cart"></span> Archivos
                        </a>
                    </li>
                    <!-- Divider -->
                    <hr class="my-3">

                    <li class="nav-item">
                        <a class="nav-link" href="agproyecto.html">
                            <span data-feather="file"></span> Agregar Proyecto
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="proyectos.html">
                            <span data-feather="file"></span> Listado Proyectos
                        </a>
                    </li>
                    <!-- Divider -->
                    <hr class="my-3">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="usuario.html">
                            <span data-feather="bar-chart-2"></span> Agregar usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listado.html">
                            <span data-feather="users"></span> Listado Usuarios
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </div>
</div>