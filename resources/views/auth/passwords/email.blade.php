@extends('layouts.app')
@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row" style="height: 628px;">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Olvido Su Contraseña?</h1>
                                    <p class="mb-4">
                                        Lo entendemos, pasan cosas. Sólo tienes que introducir tu dirección de correo electrónico a continuación
                                        ¡y le enviaremos un enlace para restablecer su contraseña!</p>
                                </div>
                                <form class="user form-signin" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Ingrese Correo Electronico...">
                                        @if ($errors->has('email'))
                                        <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reestablecer Contraseña
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{route('login')}}">Ya tienes una cuenta? Inicia!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--<div class="container">

   
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Olvido Su Contraseña?</h1>
                                    <p class="mb-4">
                                        Lo entendemos, pasan cosas. Sólo tienes que introducir tu dirección de correo electrónico a continuación
                                        ¡y le enviaremos un enlace para restablecer su contraseña!</p>
                                </div>
                                <form class="user form-signin" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"  id="exampleInputEmail"  name="email" aria-describedby="emailHelp" placeholder="Ingrese Correo Electronico...">
                                        @if ($errors->has('email'))
                                        <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reestablecer Contraseña
                                    </button>
                                </form>
                                <hr>

                                <div class="text-center">
                                    <a class="small" href="{{route('login')}}">Ya tienes una cuenta? Inicia!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>-->

    @endsection