@extends('layouts.coordinador')


@section('content')

<!-- Sidenav -->
<!-- Main content -->
@include('dash.coordinador.nav.nav')



    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 style="font-family: 'Staatliches', cursive;" class="h2">Agregar Usuario <i class="fas fa-address-card"></i></h1>
        </div>
        <div>
            <form>
                <div class="mb-3">
                    <label for="exampleInputNit" class="form-label">NIT</label>
                    <input type="number" class="form-control" id="exampleInputNit" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputNombre" class="form-label">NOMBRE</label>
                    <input type="text" class="form-control" id="exampleInputNombre" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputApeliido" class="form-label">APELLIDO</label>
                    <input type="text" class="form-control" id="exampleInputApeliido" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">EMAIL</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">CONTRASEÑA</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleSelect" class="form-label">ROL</label>
                    <select class="form-select ">
                        <option>Seleccionar</option>
                    </select>
                </div>
                <div id="boton">
                    <button type="submit " class="btn">AGREGAR</button>
                </div>
            </form>
        </div>
        <br>
        <footer style="background-color: #fe5f55;" class="fixed-bottom py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto">
                        <div class="small m-0 text-white">Copyright &copy; Sylco SAS</div>
                    </div>
                </div>
            </div>
        </footer>
    </main>       

@endsection