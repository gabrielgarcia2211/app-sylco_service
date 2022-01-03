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
                                        <h1 class="h4 text-gray-900 mb-4">Añadir Usuario</h1>
                                    </div>
                                    <form action="{{Route('user.store')}}" class="user" id="form-user" method="POST" onsubmit="return guardarUsuario()">
                                        @csrf
                                        <div class="form-group">
                                            <input type="number" class="form-control {{ $errors->has('nit') ? ' is-invalid' : '' }} form-control-user" value="{{ old('nit') }}" id="nit" name="nit" maxlength="12" aria-describedby="emailHelp" placeholder="NIT">
                                            @if ($errors->has('nit'))
                                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nit') }}</strong>
                                            </span>
                                            @endif
                                        </div>
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
                                                <input type="text" class="form-control {{ $errors->has('apellido') ? ' is-invalid' : '' }} form-control-user" value="{{ old('apellido') }}" id="apellido" name="apellido" maxlength="50" aria-describedby="emailHelp" placeholder="Apellido">
                                                @if ($errors->has('apellido'))
                                                <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('apellido') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="email" class="form-control {{ $errors->has('correo') ? ' is-invalid' : '' }} form-control-user" value="{{ old('correo') }}" id="correo" name="correo" aria-describedby="emailHelp" placeholder="Correo Electronico">
                                                @if ($errors->has('correo'))
                                                <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('correo') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control {{ $errors->has('contrasenia') ? ' is-invalid' : '' }} form-control-user" value="{{ old('contrasenia') }}" id="contrasenia" name="contrasenia" maxlength="50" aria-describedby="emailHelp" placeholder="Contraseña">
                                                @if ($errors->has('contrasenia'))
                                                <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contrasenia') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="role" class="form-select form-control-user card shadow mb-4" aria-label="Default select example" style="border: 1px solid gray; width: 100%;">
                                                    @isset($dataRol)
                                                    @foreach ( $dataRol as $rol )
                                                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                                                    @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="proyecto" class="form-select form-control-user card shadow mb-4" aria-label="Default select example" style="border: 1px solid gray; width: 100%;">
                                                    @isset($dataProyecto)
                                                    @foreach ( $dataProyecto as $proyecto )
                                                    <option value="{{$proyecto->name}}">{{$proyecto->name}}</option>
                                                    @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Registrar Usuario
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