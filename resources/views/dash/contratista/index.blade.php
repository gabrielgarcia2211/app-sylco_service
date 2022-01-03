@extends('layouts.contratista')


@section('contentContra')

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('dash.contratista.nav.navi')

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('dash.contratista.nav.navs')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="shadow mb-4" style="display: flex; justify-content: center; border-radius: 5px;">
                    <form id="form-file-contratista" action="{{route('file.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div style="margin-top:14%">
                                    <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }} form-control-user" value="{{ old('nombre') }}" id="nombre" name="nombre" maxlength="50" aria-describedby="emailHelp" placeholder="Nombre">
                                    @if ($errors->has('nombre'))
                                    <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="padding: 10px; text-align: center;">
                                    <label for="exampleFormControlFile1">Seleccionar archivo</label>
                                    <input type="file" name="archivo" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div style="text-align: center; padding-bottom: 10px;">
                                    <button type="submit" class="btn btn-primary" style="width: 200px;" onclick="return addFile();">Cargar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Subida</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Subida</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @isset($dataFiles)
                                    @for($m = 0; $m < count($dataFiles); $m++) <tr>
                                        <td>{{$dataFiles[$m]->name}}</td>
                                        <td><textarea disabled style="width: 100%; height: 180px;">{{$dataFiles[$m]->descripcion}}</textarea></td>
                                        <td>{{$dataFiles[$m]->created_at}}</td>
                                        <div class="row">
                                            <div class="col-6">
                                                <form id="" action="">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" style="width: 100%" id="btn-edit-proyecto" value="" onclick=""><i class="fas fa-edit"></i></button>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                <form id="" action="">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="width: 100%" id="btn-delete-proyecto" value="" onclick=""><i class="far fa-trash-alt"></i></button>
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
                <div style="display: flex; justify-content: center;margin:20px">
                    <button type="button" class="btn btn-primary" style="width: 200px;">Enviar Correo</button>
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



    @section('scriptContra')
    <script src="{{asset('js/contratista/index.js')}}"></script>
    @endsection