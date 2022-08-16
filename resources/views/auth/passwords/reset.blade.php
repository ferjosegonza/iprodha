@extends('layouts.auth_app')
@section('title')
Restablecer Contraseña
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/resetPassword/emailblade.css')}}">

    <div class="card card-warning">
        <div class="card-header"><h4 class="text-warning">Establecer Nueva Contraseña</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ url('/password/reset') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="emailResetSpinner" class="row justify-content-center"></div>

                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Contraseña</label>
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="control-label">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password"
                           class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                           name="password_confirmation" tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4"  id="botonEnviarConfirmPass" onclick="EnviarConfirmPass()">
                        Establecer Nueva Contraseña
                    </button>
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
