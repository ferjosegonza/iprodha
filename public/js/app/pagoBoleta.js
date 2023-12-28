window.onload=function(){    
    let form = document.getElementById('formPagos')
    var secretKey = "IPRODHA_28813050-3d45-4cd1-a246-2c907f258aff"; 
    var callbackSucces = document.getElementById("CallbackSuccess").value; 
    var callbackCancel = document.getElementById("CallbackCancel").value; 
    var sucursalComercio = ""; 
    var monto = document.getElementById("Monto").value; 
    var info = document.getElementById("Informacion").value; 
    callbackSucces = AESEncrypter.encryptString(callbackSucces, secretKey); 
    callbackCancel= AESEncrypter.encryptString(callbackCancel, secretKey); 
    sucursalComercio= AESEncrypter.encryptString(sucursalComercio, secretKey); 
    monto = AESEncrypter.encryptString(monto, secretKey);   
    info = AESEncrypter.encryptString(info, secretKey);   
    document.getElementById("CallbackSuccess").value = callbackSucces;                
    document.getElementById("CallbackCancel").value = callbackCancel;                
    document.getElementById("SucursalComercio").value = sucursalComercio;                
    document.getElementById("Monto").value = monto;  
    document.getElementById("Informacion").value = info;  
    form.submit();
}