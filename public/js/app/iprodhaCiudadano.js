window.addEventListener("DOMContentLoaded", (event) => {
    let url = window.location.href 
    let code = url.split('code=')[1].split('&')[0];
    console.log(code)
    console.log(url)
    const apiUrl = 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/token';
    const requestBody = `redirect_uri=https%3A%2F%2Fsistema.iprodha.misiones.gob.ar%2Fiprodha-ciudadano&client_id=iprodha&grant_type=authorization_code&client_secret=9c17c97d-40f0-47e9-87f1-f65adcdd7410&code=${code}`;
    
    $.ajax({
        url: apiUrl,
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: requestBody,
        success: function(res) 
        {        
            const accessToken = res.access_token;
            console.log(accessToken)    
            $.ajax({
                url: 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/userinfo',
                type: 'GET',
                headers: { Authorization: `Bearer ${accessToken}` },
                data: requestBody,
                success: function(res) 
                {        
                    console.log('User Information:', res);
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