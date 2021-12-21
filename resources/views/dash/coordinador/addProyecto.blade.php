@extends('layouts.coordinador')


@section('content')

<!-- Sidenav -->
<!-- Main content -->
@include('dash.coordinador.nav.nav')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 style="font-family: 'Staatliches', cursive;" class="h2">Agregar Proyecto <i class="fas fa-plus"></i></i>
            </h1>
        </div>
        <div>
            <form action="{{route('proyect.store')}}" method="POST" id="form-proyecto" onsubmit="return guardarProyecto()">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">NOMBRE</label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('nombre') }}"  id="nombre" name="nombre" aria-describedby="emailHelp"  >
                    @if ($errors->has('nombre'))
                        <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">DESCRIPCION</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" value="{{ old('descripcion') }}"  id="descripcion" name="descripcion" aria-describedby="emailHelp" ></textarea>
                    @if ($errors->has('descripcion'))
                        <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">UBICACION</label>
                    <input type="text" class="form-control {{ $errors->has('ubicacion') ? ' is-invalid' : '' }}" value="{{ old('ubicacion') }}"  id="ubicacion" name="ubicacion" aria-describedby="emailHelp" required>
                    @if ($errors->has('ubicacion'))
                        <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ubicacion') }}</strong>
                            </span>
                    @endif
                </div>
                    <div style="padding:10px;width: 5%">
                        <img id="carga" style="display: none" src="{{asset('/img/carga.gif')}}" alt="Funny image">
                    </div>
                <div id="boton">
                    <button type="submit " class="btn">AGREGAR</button>
                </div>
            </form>
        </div>
        <br>
    </main>
    



@endsection


@section('script')
    <script src="{{asset('js/coordinador/index.js')}}"></script>
@endsection