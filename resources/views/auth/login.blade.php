

@extends('layouts.app')


@section('content')


    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">¡BIENVENIDO!</h1>
                                    </div>
                                    <hr>
                                    <form id="login" class="user form-signin" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" name="email"  placeholder="Correo Electronico" aria-describedby="emailHelp">
                                            @if ($errors->has('email'))
                                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" id="password" name="password" placeholder="Contraseña">
                                            @if ($errors->has('password'))
                                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        @if(!empty($ingresoError))
                                        <div class="alert alert-danger" style="margin-top: 5%;text-align:center" role="alert">
                                            {{$ingresoError[0]}}
                                        </div>
                                        @endif

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Iniciar
                                        </button>
                                        <hr>
                                        <a href="{{ route('login.google') }}" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Iniciar con Google
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">Olvido Contraseña?</a>
                                    </div>
                                    <div style="height: 150px;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>


@endsection
