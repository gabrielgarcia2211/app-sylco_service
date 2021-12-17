@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row">
        <p>FILE</p>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="POST" action="{{route('file.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="file">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <p>CARPETA PADRE</p>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="POST" action="{{route('proyect.store')}}">
                    @csrf
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="descripcion">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ubicacion">
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary mt-2 ">Enviar2</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection