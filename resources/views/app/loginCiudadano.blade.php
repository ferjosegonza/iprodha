<head>
    <link rel="stylesheet" href="{{asset('css/app/loginCiudadano.css')}}">
    <script src="{{ asset('js/app/loginCiudadano.js') }}"></script>
</head>
<body>
    <div id="container">
        <a 
        href="https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/auth?response_type=code&client_id=iprodha&scope=email&redirect_uri=https%3A%2F%2Fsistema.iprodha.misiones.gob.ar%2Fiprodha-ciudadano">
            <button class="btn">Iniciar Sesión</button>
        </a>
    </div>
</body>