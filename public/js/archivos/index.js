function subtipos(){
    var idtipo = document.getElementById('tipo').value;
    if(idtipo==""){
        document.getElementById('subtipo').hidden = true;
    }
    else{
        var subtipo = document.getElementById('subtipo').hidden = false;
        let route = '/tipoarchivo/'+idtipo+'/subtipos'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax( {
            type: "GET",
            url: route,
            cache: false,
            data: JSON.stringify({
                _token: $('#signup-token').val(),
                id: idtipo
            }),
            dataType: 'json',
            success: function (json) 
            {   
                console.log(json.response.data);            
                if(json.response.data.lenght != 0){ 
                    console.log("entra");   
                    var div = "<div>";                    
                    div += ('<select class="form-select">')
                    div += ('<option value="" selected>Seleccionar</option>');
                    $.each(json.response.data, function(index) {                     
                    div += ('<option value="{{json.response.data[index].id_subtipoarchivo}}">{{json.response.data[index].nombre_corto}}</option>'); 
                    });
                    div += ('</select></div>');
                    document.getElementById('subtipo').innerHTML=div;
                    console.log(div);
                    console.log(subtipo.innerHTML);
                }  
                
            },                       
            error: function(response){
                console.log(response);
                document.getElementById('subtipo').innerHTML= "ERROR";
            } 

        });
    }
}    