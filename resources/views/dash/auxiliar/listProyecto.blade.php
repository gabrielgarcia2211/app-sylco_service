@extends('layouts.auxiliar')


@section('contentAux')

<?php
    $ruta = array(
        'CERTIFICACION ARL SG-SST',
        'MANUAL DEL SG SST',
        'HV',
        'INDUCCION Yo REINDUCCION',
        'CONDICIONES DE SALUD',
        'DOTACION Y EPP',
        'REGLAMENTOS',
        'AFI SS',
        'CAPACITACIONES',
        'INSPECCIONES',
        'INV AT-EL',
        'COPASST',
        'COVILA',
        'NOTIFICACIONES DE SEGURIDAD',
        'INFORMES MENSUALES',
        'MATRIZ IPEVR',
        'ALTO RIESGO',
        'PLAN DE EMERGENCIAS',
        'PAPSO',
        'REVISION DOCUMENTAL'
    );
?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('dash.auxiliar.nav.navi')

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('dash.auxiliar.nav.navs')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="shadow mb-4" style="border-radius: 5px;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Subir Archivo</h6>
                    </div>
                    <div class="card-body">
                        <form id="form-upload-contratista" action="{{ route('contratista.file.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                     <input id="proyecto" name="proyecto" type="hidden" value="{{$name}}"></input>
                                    <div class="form-group" style="padding: 10px; text-align: center;">
                                        <input type="text" class="form-control form-control-user" id="nombre" name="nombre" maxlength="50" aria-describedby="emailHelp" placeholder="Nombre">
                                    </div>

                                    <div class="form-group" style="padding: 10px; text-align: center;">
                                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion" maxlength="200" aria-describedby="emailHelp"></textarea>
                                    </div>

                                    <div class="form-group" style="padding: 10px; text-align: center;">
                                        <select class="form-control" id="carpeta" name="carpeta">
                                            <option value="">Carpeta...</option>
                                            <?php for ($m = 0; $m < count($ruta); $m++) : ?>
                                                <option value="<?php echo rtrim($ruta[$m]) ?>">
                                                <?php echo rtrim($ruta[$m]) ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    <div class="form-group" style="padding: 10px; text-align: center;">
                                        <input type="file" name="archivo" id="archivo" class="form-control-file" id="exampleFormControlFile1">
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
                </div>
                <br>
                <!-- Page Heading -->
                <p class="mb-4">Lista de Mis Archivos</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista <a onclick="reset()"><i class="fas fa-redo"></i></a></h6>
                        @isset($dataFiles)
                        @if(count($dataFiles) > 0)
                            <div class="col-12">
                                <a href="{{ route('contratista.backup') }}"  target="" class="btn btn-info" style="width: 10%;float: right;">
                                    <i class="fas fa-archive"></i>
                                </a>
                            </div>
                            <form id="form-full-delete" action="{{route('contratista.remove.all')}}">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="width: 10%;float:right;margin-right: 10px"  onclick="return deleteFull()"><i class="far fa-trash-alt"></i></button>
                            </form>
                        @endif
                        @endisset 
                    </div>
                    <div class="form-group" style="padding: 10px; text-align: center;">
                        <form id="form-filter-contratista" action="{{ route('contratista.file.filter') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <select class="form-control" id="carpeta_f" name="carpeta_f" onchange="carpeta_filter();">
                                <option value="">Filtrar por carpeta...</option>
                                <?php for ($m = 0; $m < count($ruta); $m++) : ?>
                                    <option value="<?php echo rtrim($ruta[$m]) ?>">
                                    <?php echo rtrim($ruta[$m]) ?></option>
                                <?php endfor; ?>
                            </select>
                            <input id="proyecto_f" name="proyecto_f" type="hidden" value="{{$name}}"></input>
                        </form>    
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
                                        <td><textarea disabled style="width: 100%; height: 180px;resize: none;">{{$dataFiles[$m]->descripcion}}</textarea></td>
                                        <td>{{$dataFiles[$m]->created_at}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="{{ route('file.download.auxiliar', [$dataFiles[$m]->file]) }}"  target="" class="btn btn-success" style="width: 80%"><i class="far fa-eye"></i></a>
                                                </div>
                                                <div class="col-6">
                                                    <form id="form-file-delete" action="{{route('contratista.file.delete')}}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" style="width: 80%"  onclick="return deleteFile('{{$dataFiles[$m]->id}}')"><i class="far fa-trash-alt"></i></button>
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