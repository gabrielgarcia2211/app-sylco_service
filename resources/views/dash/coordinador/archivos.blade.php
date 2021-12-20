@extends('layouts.coordinador')


@section('content')

<!-- Sidenav -->
<!-- Main content -->
@include('dash.coordinador.nav.nav')


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 style="font-family: 'Staatliches', cursive;" class="h2">Archivos <i class="fas fa-file-alt"></i></h1>
    </div>
    <div class="contairner">
        <div class="row" id="busqueda">
            <div class="col">
                <select class="form-select ">
                    @if(isset($user))
                    @foreach ($user as $use)
                    <option>{{$use->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col">
                <div id="boton">
                    <button type="submit " class="btn">BUSCAR</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    @if(isset($resp))
    <?php $cont = 0 ?>
    @for($m = 0; $m < count($resp['message']) / 3; $m++) <div>
        <div class="card-group">
            @for ($j = $cont; $j < count($resp['message']) ; $j++)  <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$dataProyecto[$cont]->nombre}}</h5>
                    <h6 class="card-title">{{$dataProyecto[$cont]->descripcion}}</h6>
                    <p class="card-text"><b>Aceptacion: </b>{{$dataProyecto[$cont]->nombre}}</p>
                    <a  href="{{$resp['message'][$cont][1]}}" target="_blank">link Archivo</a>
                </div>
        </div>

        <?php $cont++ ?>
        @if (($cont % 3) == 0)
        @break
        @endif
        @endfor
        </div>
        </div>
        <br>
        @endfor

        @endif
        <br>
</main>




<!-- Page content -->


@endsection