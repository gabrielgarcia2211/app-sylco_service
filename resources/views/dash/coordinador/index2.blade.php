@extends('layouts.coordinador')


@section('content')

<!-- Sidenav -->
<!-- Main content -->
@include('dash.coordinador.nav.nav')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 style="font-family: 'Staatliches', cursive;" class="h2">Contratistas <i class="fas fa-user-tie"></i></h1>
    </div>

    @if(isset($user))
    <?php $cont = 0 ?>
    @for($m = 0; $m < count($user) / 3; $m++) 
        <div class="row">
            @for ($j = $cont; $j < count($user) ; $j++) <?php $cont++ ?>
            <div class="col-sm">
                <div class="card" style="width: 100%">
                    <div class="card-header">
                    <b>Nit: </b>{{$user[$j]->nit}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{$user[$j]->name}} {{$user[$j]->last_name}}</h5>
                        <p class="card-text"><b>Correo Electronico: </b>{{$user[$j]->email}}</p>
                    </div>
                    <div class="card-footer">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success"><b>Proyecto Asociado: </b>{{$user[$j]->proyecto}}</li>
                            <li class="list-group-item list-group-item-primary"><b>Cantidad de Archivos Cargados: </b>{{$user[$j]->cantidad}}</li>
                        </ul>
                    </div>  
                </div>
            </div>
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



<!-- Page content -->


@endsection