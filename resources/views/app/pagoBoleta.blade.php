<html> 
<head> 
    <meta name=”referrer” content=”no-referrer”>
    <script src="{{ asset('js/app/pagoBoleta.js') }}"></script>
</head> 
<body> 
<form method="post" action="https://sandboxpp.asjservicios.com.ar/" id="formPagos">
    <input type="hidden" name="CallbackSuccess" value={{$postData['CallbackSuccess']}} />
    <input type="hidden" name="CallbackCancel" value={{$postData['CallbackCancel']}}/>
    <input type="hidden" name="Comercio" value={{$postData['Comercio']}}/>
    <input type="hidden" name="SucursalComercio" value={{$postData['SucursalComercio']}}/>
    <input type="hidden" name="Hash" value={{$postData['Hash']}}/>
    <input type="hidden" name="TransaccionComercioId" value={{$postData['TransaccionComercioId']}} />
    <input type="text" name="Monto" value={{$postData['Monto']}} />
    <input type="text" name="Producto[0]" value={{$postData['Producto[0]']}} />
    <input type="text" name="Producto[1]" value={{$postData['Producto[1]']}} />
    <input type="text" name="Informacion" value={{$postData['Informacion']}}/>
    <input type="hidden" name="ClientData.CUIT" value={{$postData['ClientData.CUIT']}} /> 
    <input type="hidden" name="ClientData.NombreApellido" value={{$postData['ClientData.NombreApellido']}} /> 
    <button type="submit">ENVIAR</button> 
</form> 
</body> 
</html