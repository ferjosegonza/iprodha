function subtipos(){
    var idtipo = document.getElementById('tipo').value;
    if(idtipo==""){
        document.getElementById('subtipo').hidden=true;
    }
    else{
        console.log("something")
        let route = '/tipoarchivo/'+idtipo+'/subtipos'; 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log("something")
        $.ajax( {
            type: "GET",
            url: route,
            cache: false,
            data: JSON.stringify({
                _token: $('#signup-token').val(),
                id: idtipo
            }),
            dataType: 'json',
            success: function (json) { 
                console.log(json);

                var div = "<div>";
                var subtipo = document.getElementById('subtipo');
                div += ('<select class="form-select"> <option value="" selected>Seleccionar</option>');
                $.each(json.response.data, function(index) {
                     div += ('<option value="{{json.response.data[index].id_subtipoarchivo}}">{{json.response.data[index].nombre_corto}}</option>'); 
                });
                div += ('</select></div>');
                subtipo.innerHTML=div;

            },                       
            error: function(response){
                document.getElementById('subtipo').innerHTML= "ERROR";
            } 

        });
    }
}    