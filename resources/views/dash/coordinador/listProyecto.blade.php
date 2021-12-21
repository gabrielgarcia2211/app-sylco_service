@extends('layouts.coordinador')


@section('content')

<!-- Sidenav -->
<!-- Main content -->
@include('dash.coordinador.nav.nav')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 style="font-family: 'Staatliches', cursive;" class="h2">Proyectos <i class="fas fa-paste"></i></h1>

                </div>
                @if(isset($data))
                <?php $cont = 0 ?>
                @for($m = 0; $m < count($data) / 3; $m++) 
                    <div class="row">
                        @for ($j = $cont; $j < count($data) ; $j++) 
                        <div class="col-sm">
                            <div class="card" style="width: 100%">
                                <div class="card-header">
                                <b>Nombre: </b>{{$data[$j]->name}}
                                </div>
                                <div class="card-body">
                                    <p class="card-title"><b>Ubicacion: </b>{{$data[$j]->ubicacion}}</p>
                                    <p class="card-text"><b>Descripcion: </b>{{$data[$j]->descripcion}}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col" style="text-align: center;">
                                            <button type="button" class="btn btn-success">EDITAR</button>
                                        </div>
                                        <div class="col" style="text-align: center;">
                                            <form id="formu-delete-proyecto" action="{{ route('proyect.delete')}}"  method="POST" onsubmit="return eliminarProyecto()">
                                                @csrf
                                                    <input id="name" name="namesssss" type="hidden" value="{{$data[$j]->name}}">
                                                    <button class="btn btn-danger" >Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <?php $cont++ ?>
                    @if (($cont % 3) == 0)
                    @break
                    @endif
                    @endfor
                    </div>
                    
                    <br>
                    @endfor

                    @endif
                <br>
            
                
        </main>
        </div>
    </div>


    <!-- Page content -->


@endsection

@section('script')
    <script src="{{asset('js/coordinador/index.js')}}"></script>
@endsection