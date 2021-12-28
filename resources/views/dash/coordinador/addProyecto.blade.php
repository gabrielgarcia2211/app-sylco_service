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

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Añadir Proyecto</h1>
                                    </div>
                                    <form action="{{route('proyect.store')}}" class="user" id="form-proyecto" method="POST" onsubmit="return guardarProyecto()">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }} form-control-user" value="{{ old('nombre') }}" id="nombre" name="nombre" maxlength="50" aria-describedby="emailHelp" placeholder="Nombre">
                                                @if ($errors->has('nombre'))
                                                <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('nombre') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                            <input type="text" class="form-control {{ $errors->has('ubicacion') ? ' is-invalid' : '' }} form-control-user" value="{{ old('ubicacion') }}" id="ubicacion" name="ubicacion" maxlength="50" aria-describedby="emailHelp" placeholder="Ubicacion">
                                                @if ($errors->has('ubicacion'))
                                                <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('ubicacion') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" value="{{ old('descripcion') }}" id="descripcion" name="descripcion" maxlength="200" aria-describedby="emailHelp"></textarea>
                                            @if ($errors->has('descripcion'))
                                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Registrar Proyecto
                                        </button>
                                        <hr>
                                    </form>
                                </div>
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