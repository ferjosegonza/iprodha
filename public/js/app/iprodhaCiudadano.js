$(document).ready(function () {
    let url = window.location.href 
    let code = url.split('code=')[1].split('&')[0];
    const apiUrl = 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/token';
    const requestBody = `redirect_uri=https%3A%2F%2Fsistema.iprodha.misiones.gob.ar%2Fiprodha-ciudadano&client_id=iprodha&grant_type=authorization_code&client_secret=9c17c97d-40f0-47e9-87f1-f65adcdd7410&code=${code}`;
    
    $.ajax({
        url: apiUrl,
        type: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            }, 
        body: requestBody,
        success: function(res) 
        {        
            const accessToken = res.access_token;
            console.log(accessToken)    
            $.ajax({
                url: 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/userinfo',
                type: 'GET',
                headers: { Authorization: `Bearer ${accessToken}` },
                body: requestBody,
                success: function(res) 
                {        
                    const userInfo = res
                    console.log('User Information:', userInfo);
                    const cuit = userInfo.cuit;
                    const email = userInfo.email;
                    const nombre = userInfo.name;  
                },
                error: function(response){
                    console.log('Response Status:', response.status);
                    console.log('Response Status Text:', response.statusText);
                }   
            });
        },
        error: function(response){
            console.log('Response Status:', response.status);
            console.log('Response Status Text:', response.statusText);
        }   
    })})