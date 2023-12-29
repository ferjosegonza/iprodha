<html> 
<head> 
    <meta name="referrer" content="no-referrer">
    <script src="https://cdn.jsdelivr.net/npm/pluspagos-aes-encryption@1.0.0/dist/AESEncrypter.js"></script>
    <script src="{{ asset('js/app/pagoBoleta.js') }}"></script>
</head> 
<body> 
    <style>
        .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
    </style>
    <div class="loader"></div>
<form method="POST" action="https://sandboxpp.asjservicios.com.ar/" id="formPagos">
    <input type="hidden" name="CallbackSuccess" value="{{$postData['CallbackSuccess']}}" id="CallbackSuccess"/>
    <input type="hidden" name="CallbackCancel" value="{{$postData['CallbackCancel']}}" id="CallbackCancel"/>
    <input type="hidden" name="Comercio" value="ca309049-84d7-430a-af3a-ce747f3c1f50"/>
    <input type="hidden" name="SucursalComercio" value="" id="SucursalComercio"/>
    <input type="hidden" name="TransaccionComercioId" value='{{$postData['TransaccionComercioId']}}' />
    <input hidden type="int" name="Monto" value="{{$postData['Monto']}}" id="Monto"/>
    <input hidden type="text" name="Producto[0]" value="{{$postData['Producto[0]']}}" />
    <input hidden type="text" name="Producto[1]" value="{{$postData['Producto[1]']}}" />
    <input hidden type="text" name="Informacion" value="{{$postData['Informacion']}}" id="Informacion"/>
    <input type="hidden" name="ClientData.CUIT" value="{{$postData['ClientData.CUIT']}}" /> 
    <input type="hidden" name="ClientData.NombreApellido" value='{{$postData['ClientData.NombreApellido']}}' />
</form> 
</body> 
</html