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
        <form action="{{route('coordinador.contratista.file')}}" method="POST">
            @csrf
            <div class="row" id="busqueda">
                <div class="col">
                    <select class="form-select" name="contratista">
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
        </form>
    </div>
    <br>

    

    @if(isset($resp))
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <i class="fas fa-check-circle" style="font-size: 30px;margin:4px"></i>
        <div>
        Filtrado por {{$data[0]->nombre}}
        </div>
    </div>
 
    <?php $cont = 0 ?>
    @for($m = 0; $m < count($resp['message']) / 3; $m++) 
        <div class="row">
            @for ($j = $cont; $j < count($resp['message']) ; $j++)
            <div class="col-sm">  
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">{{$dataProyecto[$cont]->nombre}}</h5>
                        <h6 class="card-title">{{$dataProyecto[$cont]->descripcion}}</h6>
                        <p class="card-text"><b>Aceptacion: </b>{{$dataProyecto[$cont]->aceptacion}}</p>
                    </div>
                    <div class="card-footer">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-primary"><a href="{{$resp['message'][$cont][1]}}" target="_blank">link Archivo</a></li>
                        </ul>
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

    @else
    <div class="alert alert-success" role="alert" style="width:90%;">
        <h4 class="alert-heading">Bienvenido!</h4>
        <p>En esta seccion podras buscar todos los archivos subidos actualemnte por los contratistas de la Constructora</p>
        <hr>
        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
    </div>
    @endif

        <br>
</main>


    

<!-- Page content -->


@endsection