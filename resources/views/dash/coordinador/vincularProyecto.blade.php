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

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Vincular</h1>
                <p class="mb-4">Gestion de Proyectos.</p>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Bucar</h6>
                    </div>
                    <form action="{{route('proyect.vincular')}}" class="user" id="form-user-rol" method="POST" onsubmit="return findUser()">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-user" id="usuarioRol" name="usuario" maxlength="50" aria-describedby="emailHelp" placeholder="Digite Nit del Usuario">
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Vincular Proyecto</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-12" style="text-align: center;  display: flex; justify-content: center;">
                                <table class="table" style="width:80%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Proyectos</th>
                                            <th scope="col">Vincular</th>
                                        </tr>
                                    </thead>
                                    @if(!empty($JString))
                                    <tbody>
                                        @for($m = 0; $m < count($JString['agregar']); $m++) <tr>
                                            <td>{{$JString['agregar'][$m]->name}}</td>
                                            <td>
                                                <div class="row" style="display: flex;justify-content: center;">
                                                    <div class="col-4">
                                                        <form id="form-user-vinc" action="{{route('proyect.user.vincular')}}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning" style="width: 70%" id="btn-edit-proyecto" onclick="return vincularProyectoUser('{{$JString['agregar'][$m]->name}}')"><i class="fas fa-plus"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                            @endfor
                                    </tbody>
                                    @else
                                    <tbody>
                                        <tr>
                                            <td>N/A</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <br>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Desvincular Proyecto</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-12" style="text-align: center;  display: flex; justify-content: center;">
                                <table class="table" style="width:80%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Proyectos</th>
                                            <th scope="col">Desvincular</th>
                                        </tr>
                                    </thead>
                                    @if(!empty($JString))
                                    <tbody>
                                        @for($m = 0; $m < count($JString['eliminar']); $m++) <tr>
                                            <td>{{$JString['eliminar'][$m]->name}}</td>
                                            <td>
                                                <div class="row" style="display: flex;justify-content: center;">
                                                    <div class="col-4">
                                                    <form id="form-user-desv" action="{{route('proyect.user.desvincular')}}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger" style="width: 70%" id="btn-edit-proyecto" onclick="return desVincularProyectoUser('{{$JString['eliminar'][$m]->name}}')"><i class="far fa-trash-alt"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                            @endfor
                                    </tbody>
                                    @else
                                    <tbody>
                                        <tr>
                                            <td>N/A</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <!-- /.container-fluid -->


        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span style="color:black">Copyright &copy; SYLCO S.A.S 2021</span>
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


    @section('script')
    <script src="{{asset('js/coordinador/index.js')}}"></script>
    @endsection