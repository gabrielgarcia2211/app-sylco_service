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
                    <h1 class="h3 mb-2 text-gray-800">Archivo</h1>
                    <p class="mb-4">Gestion de Usuarios.</p>

                    <div class="card">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Carga de Usuarios</h6>
                        </div>
                        <div class="card-body">

                            <div style="border-top: 3px solid #3c8dbc; background-color: white; padding-bottom: 10px;">
                                <br>
                                <h6 style="padding-left: 10px;">Seleccionar Archivo</h6>
                                <form action="{{ route('file.upload.user') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="input-group mb-3" style="padding-right: 10px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01">Cargar</span>
                                        </div>
                                        <div class="custom-file">
                                            <input onchange="validarExtension()" type="file" style="display:none"
                                                class="custom-file-input" id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01" name="file">
                                            <label class="custom-file-label" for="inputGroupFile01">
                                                <p class="nameArchivo">...</p>
                                            </label>
                                        </div>
                                    </div>


                                    <button type="submit" id="guardaExcel" class=" btn btn-primary mr-2"
                                        style="display:inline-block; background-color: #dd4b39; border-color: #dd4b39;">Guardar</button>

                                    <a href="" style="display:inline-block; text-decoration: none" type="button"
                                        class="btn btn-success mr-2">Descargar Formato</a>
                                    <a onclick="return info(event)" href=""><i class="fas fa-question"></i></a>



                                    <div style="display:none; text-align:center; padding:10px ; margin-top:15px" id="alert"
                                        class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <p class="respuesta" id="respuesta"></p>
                                    </div>
                                    <div style="display:none; text-align:center; padding:10px ; margin-top:15px" id="alert2"
                                        class="alert alert-success" role="alert">
                                        <p class="respCarga"></p>
                                    </div>

                                </form>
                            </div>

                            <div style="padding: 20px; margin-top:20px" class="container">
                                @if (session()->has('failures'))

                                    <table id="error" class="table table-danger">
                                        <tr>
                                            <th>Fila</th>
                                            <th>Campo</th>
                                            <th>Error</th>
                                            <th>Valor</th>
                                        </tr>
                                        @foreach (session()->get('failures') as $validation)
                                            <tr>
                                                <td>{{ $validation->row() }}</td>
                                                <td>{{ $validation->attribute() }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($validation->errors() as $e)
                                                            <li>{{ $e }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{ $validation->values()[$validation->attribute()] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                @endif
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                        <a class="btn btn-primary" href="{{ route('logout') }}">Salir</a>
                    </div>
                </div>
            </div>
        </div>




    @endsection


    @section('script')
        <script src="{{ asset('js/coordinador/index.js') }}"></script>
    @endsection
