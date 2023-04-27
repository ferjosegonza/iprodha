<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Registro | {{ config('app.name') }}</title>

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap 5.2 -->
    <link href="{{ asset('assets/css/bootstrap.min2.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="{{asset('img/logo3.png')}}">
    
    
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    {{-- <div class="login-brand">
                        <img src="{{ asset('img/logo3.png') }}" alt="logo" width="150"
                             class="shadow-light rounded-circle ">
                    </div> --}}
                    <div class="card card-warning">
                        <div class="card-header"><h4 class="text-warning">Registro IPRODHA</h4></div>
                
                        <div class="card-body pt-1">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Nombre Completo:</label><span
                                                    class="text-danger">*</span>
                                            <input id="firstName" type="text"
                                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="name"
                                                   tabindex="1" placeholder="Ingrese nombre completo" value="{{ old('name') }}"
                                                   autofocus required>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email:</label><span
                                                    class="text-danger">*</span>
                                            <input id="email" type="email"
                                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                   placeholder="Ingrese direción de correo" name="email" tabindex="1"
                                                   value="{{ old('email') }}"
                                                   required autofocus>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="control-label">Contraseña:</label><span
                                                    class="text-danger">*</span>
                                            <input id="password" type="password"
                                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                                   placeholder="Ingrese su contraseña" name="password" tabindex="2" required>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        </div>
                                        <div hidden>
                                            {!! Form::text('emp', 1, ['style' => 'disabled;' ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation"
                                                   class="control-label">Confirmar Contraseña:</label><span
                                                    class="text-danger">*</span>
                                            <input id="password_confirmation" type="password" placeholder="Confirme su contraseña"
                                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                                   name="password_confirmation" tabindex="2">
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password_confirmation') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning btn-lg btn-block fs-5" tabindex="4">
                                                Registrarse
                                            </button>
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="{{ route('login.iprodha') }}" tabindex="4" class="fs-5 btn btn-danger btn-lg btn-block">
                                                Volver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Ya tiene una cuenta ? <a
                                href="{{ route('login') }}">Iniciar Sesión</a>
                    </div>
                    <div class="simple-footer">
{{--                        Copyright &copy; {{ getSettingValue('application_name') }}  {{ date('Y') }}--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min2.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

<!-- JS Libraies -->

<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<!-- Page Specific JS File -->
</body>
</html>
