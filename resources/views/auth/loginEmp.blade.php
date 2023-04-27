<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login | {{ config('app.name') }}</title>

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
                        <div class="card-header"><h4 class="text-warning">Inicio IPRODHA</h4></div>
                
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
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
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                           placeholder="Ingrese su Email" tabindex="1"
                                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                                           required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="float-right">
                                            <a href="{{ route('password.request') }}" class="text-small">
                                                Olvidó tu contraseña?
                                            </a>
                                        </div>
                                    </div>
                                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                                           placeholder="Ingrese su Contraseña"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                                           tabindex="2" required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                               id="remember"{{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">Recordar</label>
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                                        Iniciar Sesión
                                    </button>
                                </div>
                                
                                <div class="form-group">
                                    <a href="{{ route('register.emp') }}" tabindex="4" class="text-small btn btn-secondary btn-lg btn-block">
                                        Registrarse
                                    </a>
                                </div>
                            </form>
                        </div>
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
