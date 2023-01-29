@extends('layouts.coordinador')


@section('content')

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('dash.coordinador.nav.navi')

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('dash.coordinador.nav.navs')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Usuarios</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{App\Models\User::count()}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Contratistas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dataContratista[0]->contratista}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Proyectos
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{App\Models\Proyecto::where('status', 0)->count()}}</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="{{App\Models\Proyecto::count()/100}}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-building fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Archvios Subidos</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{App\Models\File::count()}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-upload fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->

                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg-12 mb-6">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Proyecto</h6>
                            </div>
                            <div class="card-body">

                                @isset($dataProyecto)
                                <?php $cont = 0 ?>
                                @for($m = 0; $m < count($dataProyecto) / 3; $m++) <div class="row">
                                    @for ($i = $cont; $i < count($dataProyecto); $i++) <div class="col-lg mb-4">
                                        <div class="card text-white shadow" style="background: {{$dataProyecto[$i][2]}}">
                                            <div class="card-body">
                                                {{$dataProyecto[$i][0]}}
                                                <div class="text-white-50 small"> {{$dataProyecto[$i][1]}}</div>
                                            </div>
                                        </div>
                            </div>
                            <?php $cont++ ?>
                            @if (($cont % 3) == 0)
                            @break
                            @endif
                            @endfor
                        </div>
                        @endfor
                        @endisset
                    </div>
                </div>

                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg-12 mb-6">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Control de Seguridad</h6>
                            </div>
                            <div class="card-body">
                                @isset($dataFiles)
                                @if(count($dataFiles) > 0)
                                <div class="col-12">
                                    <a href="{{ route('contratista.backup') }}" target="" class="btn btn-info" style="width: 10%;float: right;">
                                        <i class="fas fa-archive"></i>
                                    </a>
                                </div>
                                <form id="form-full-delete" action="{{route('contratista.remove.all')}}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" style="width: 10%;float:right;margin-right: 10px" onclick="return deleteFull()"><i class="far fa-trash-alt"></i></button>
                                </form>
                                @endif
                                @endisset

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>




    </div>


</div>
<!-- /.container-fluid -->


<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; SYLCO S.A.S 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>

<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">¿Desea salir y cerrar la sesion?.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{route('logout')}}">Salir</a>
            </div>
        </div>
    </div>
</div>




@endsection