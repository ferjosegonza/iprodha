@extends('layouts.auth_app')
@section('title')
    Has olvidado tu Contraseña
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/resetPassword/emailblade.css')}}">

    <div class="card card-warning">
        <div class="card-header"><h4 class="text-warning">Restablecer Contraseña</h4></div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div id="emailResetSpinner" class="row justify-content-center"></div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" id="botonEnviarResetPass" tabindex="4" onclick="EnviarResetPass()">
                        Enviar enlace de reinicio
                    </button>
                </div>
                
                <div class="form-group">
                    <a href="{{ route('login') }}" tabindex="4" class="text-small btn btn-secondary btn-lg btn-block">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Recordó la información de inicio de sesión? <a href="{{ route('login') }}">Iniciar Sesión</a>
    </div>
    <script type="text/javascript" src="{{ asset("js/resetPassword/emailblade.js") }}" ></script>

@endsection
