$(document).ready(function() {
    let url = window.location.href;
    let code = url.split('code=')[1].split('&')[0];
    console.log(code);
    console.log(url);

    const apiUrl = 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/token';
    const redirectUri = encodeURIComponent('https://sistema.iprodha.misiones.gob.ar/iprodha-ciudadano');
    const clientId = 'iprodha';
    const clientSecret = '9c17c97d-40f0-47e9-87f1-f65adcdd7410';

    const requestBody = `redirect_uri=${redirectUri}&client_id=${clientId}&grant_type=authorization_code&client_secret=${clientSecret}&code=${code}`;

    $.ajax({
        url: apiUrl,
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        data: requestBody,  // Use 'data' instead of 'body'
        success: function(res) {
            const accessToken = res.access_token;
            console.log('Access Token:', accessToken);

            // Make a request to get user information using the obtained access token
            $.ajax({
                url: 'https://sso.misiones.gob.ar/auth/realms/Misiones/protocol/openid-connect/userinfo',
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                success: function(userInfo) {
                    console.log('User Information:', userInfo);
                },
                error: function(response) {
                    console.log('Error getting user information. Status:', response.status);
                    console.log('Status Text:', response.statusText);
                }
            });
        },
        error: function(response) {
            console.log('Error getting access token. Status:', response.status);
            console.log('Status Text:', response.statusText);
        }
    });
});
