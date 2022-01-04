@extends('layouts.auxiliar')


@section('contentAux')

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('dash.auxiliar.nav.navi')

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('dash.auxiliar.nav.navs')

            <!-- Begin Page Content -->
            <div class="container-fluid" >

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{$name}}</h1>
                <p class="mb-4">Gestion de Contratistas.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIT</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>NIT</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @isset($dataFiles)
                                    @for($m = 0; $m < count($dataFiles); $m++) <tr>
                                        <td>{{$dataFiles[$m]->nit}}</td>
                                        <td>{{$dataFiles[$m]->name}}</td>
                                        <td>{{$dataFiles[$m]->last_name}}</td>
                                        <td>{{$dataFiles[$m]->email}}</td>
                                        <td>
                                            <div class="row" style="justify-content: center;">
                                                <div class="col-4">
                                                    <form id="formu-contratista-show" action="{{route('contratista.proyecto.list')}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" style="margin:auto" id="btn-show-proyecto"  onclick="return findFilesUser('{{$dataFiles[$m]->nit}}', '{{$dataFiles[$m]->proyecto}}')"><i class="fas fa-info-circle"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                        @endfor
                                        @endisset
                                </tbody>
                            </table>
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


    @section('scriptAux')
    <script src="{{asset('js/auxiliar/index.js')}}"></script>
    @endsection