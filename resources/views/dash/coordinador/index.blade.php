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
    @for($m = 0; $m < count($user) / 3; $m++) <div>
        <div class="card-group">
            @for ($j = $cont; $j < count($user) ; $j++) <?php $cont++ ?> <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$user[$j]['name']}} {{$user[$j]['last_name']}}</h5>
                    <h6 class="card-title"><b>Nit: </b>{{$user[$j]['nit']}}</h6>
                    <p class="card-text">{{$user[$j]['email']}}</p>
                </div>
        </div>


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