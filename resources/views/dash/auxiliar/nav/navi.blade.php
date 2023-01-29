<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #1F5E09;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{asset('/img/logo.png')}}" class="img-fluid" alt="..." width="90" height="50">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-house-user"></i>
            <span>Inicio</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-file"></i>
            <span>Documentos</span></a>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nombres:</h6>
                <?php $proyectos = App\Models\Proyecto::select('proyectos.name')->join('proyecto_users', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
                    ->join('users', 'users.nit', '=', 'proyecto_users.user_nit')
                    ->where('proyectos.status', '0')
                    ->where('users.nit', auth()->user()->nit)
                    ->get() ?>

                @isset($proyectos)
                @foreach ($proyectos as $p)
                    <a class="collapse-item" href="{{route('contratista.file.upload',[$p->name])}}">{{$p->name}}</a>
                @endforeach
                @endisset

            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-building"></i>
            <span>Proyectos</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nombres:</h6>
                <?php $proyectos = App\Models\Proyecto::select('proyectos.name')->join('proyecto_users', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
                    ->join('users', 'users.nit', '=', 'proyecto_users.user_nit')
                    ->where('users.nit', auth()->user()->nit)
                    ->get() ?>

                @isset($proyectos)
                @foreach ($proyectos as $p)
                    <a class="collapse-item" href="{{route('contratista.showProyecto',[$p->name])}}">{{$p->name}}</a>
                @endforeach
                @endisset

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>