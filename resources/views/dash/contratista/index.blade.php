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

            <div class="container-fluid">
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
                                                <div class="text-white-50 small">Cantidad de Archivos Subidos: {{$dataProyecto[$i][1]}}</div>
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
            </div>



        </div>





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