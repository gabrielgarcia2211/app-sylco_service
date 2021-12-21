@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso</title>

    <link href="/css/login.css" rel="stylesheet">

</head>

<body id="contenedor">
        <main class="form-signin">
            <div id="contenido-login">
                <form id="login" class="form-signin" method="POST" action="{{ route('login') }}">
                    @csrf

                    <img class="img-fluid" src="/img/sylco-logo.jpg" alt="" width="110" height="60">
                    <img class="img-fluid" src="/img/sylco-logo.jpg" alt="" width="110" height="60">
                    <img class="img-fluid" src="/img/sylco-logo.jpg" alt="" width="110" height="60">
                    

                    <div class="form-floating">
                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"  id="email" name="email"  placeholder="Correo Electronico" required>
                        <label for="email">Correo Electronico</label>
                        @if ($errors->has('email'))
                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-floating">
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}"  id="password" name="password"  placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                        @if ($errors->has('password'))
                            <span style="margin-bottom:18px" class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>

                  

                    <button class="w-100 btn btn-lg btn-danger" type="submit">Iniciar Sesion</button>
                    <a href="{{ route('login.google') }}" class="w-100 btn btn-lg btn-primary btn-block" style="margin-top: 12px;"><i class="fab fa-google"></i> Inicia con <b>Google</b></a>

                    @if(!empty($ingresoError))
                        <div class="alert alert-danger" style="margin-top: 5%;text-align:center" role="alert">
                            {{$ingresoError[0]}}
                        </div>
                    @endif

                </form>
            </div>
        </main>
</body>
