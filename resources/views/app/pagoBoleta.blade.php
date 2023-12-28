<html> 
<head> 
    <meta name="referrer" content="no-referrer">
    <script src="https://cdn.jsdelivr.net/npm/pluspagos-aes-encryption@1.0.0/dist/AESEncrypter.js"></script>
    <script src="{{ asset('js/app/pagoBoleta.js') }}"></script>
</head> 
<body> 
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