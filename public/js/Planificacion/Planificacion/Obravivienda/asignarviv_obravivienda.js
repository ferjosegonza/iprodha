$(function(){
    $('#buscavivienda').on('keyup', buscarVivienda);
    // $('#addRow').on('click', nuevoCrono);
    // $('#item').on('change', mostrarAcumulado);
});

function buscarVivienda(){
    let orden = document.getElementById('buscavivienda').value;
    let viviendaLista = document.getElementById('viviendasParaAsignar');

    if(orden != ''){
        viviendaLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/obravivienda/buscarviv/'+orden+'/'+obra, 
            data: {
                orden: orden,
            },
        success: function (response) {
            console.log(response);
            if(response.message){
                 viviendaLista.innerHTML = response.message;
            }else{
            // response.forEach(element => {
                // if($('.viv'+response.orden).is(':checked')){
                        // console.log('entra en el true');
                        viviendaLista.innerHTML += '<label id='+response.id_viv+'><input onclick="agregarRubro('+response.id_viv+',\''+response.orden+'\')" class="radiockeck'+response.id_viv+'" name="" type="checkbox" value=""> Viv. Orden N°: '+response.orden+'</label>';
                // }else{
                        // console.log('entra en el false');
                        // viviendaLista.innerHTML += '<label id='+element.id+'><input onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                // }     
                // });
            }
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }else{
        viviendaLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/obravivienda/todaslasviviendas/'+obra, 
            data: {
                orden: orden,
            },
        success: function (response) {
            response.forEach(element => {
                if($('.viv'+element.id).is(':checked')){
                    viviendaLista.innerHTML += '<label id='+element.id_viv+'><input checked onclick="agregarVivienda('+element.id_viv+')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> Viv. Orden N°: '+element.orden+'</label>';
                }else{
                    viviendaLista.innerHTML += '<label id='+element.id_viv+'><input onclick="agregarVivienda('+element.id_viv+')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> Viv. Orden N°: '+element.orden+'</label>';
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }
}

function agregarVivienda(id, orden){
    // console.log("hola");
    let viviendasListaAsignados = document.getElementById('viviendasAsignadas');

    if($('.radiockeck'+orden).is(':checked')){
        viviendasListaAsignados.innerHTML += '<label id=viv'+orden+'><input checked onclick="eliminarVivienda('+orden+')" class="vi'+orden+'" name="vivs[]" type="checkbox" value="'+id+'"> Viv. Orden N°: '+orden+'</label>';
    }else{
        $('.radiockeck'+orden).prop("checked", false);
        // $('.permisoscheck'+id).prop("checked", false);
        $('#viv'+orden).remove();
    } 
}

function eliminarVivienda(orden){
    $('.radiockeck'+orden).prop("checked", false);
    $('#viv'+orden).remove();
}

function agregarpermiso(id,name,i) {
    if (i == 1) {
        if ($('.radiocheck'+id).is(':checked')) {
            html='<label id='+name+'><input checked onclick="eliminar('+id+',\''+name+'\')" class="name me-2 permisoscheckgrabar'+id+'" name="permisos[]" type="checkbox" value="'+id+'">'+name+'</label>';
            $('#'+name).remove();
            $("#lista_permisos2").prepend(html);
            $('.radiocheck'+id).prop("checked", true);
            $('.permisoscheck'+id).prop("checked", true);
        } else {
            $('.radiocheck'+id).prop("checked", false);
            $('.permisoscheck'+id).prop("checked", false);
            $('#'+name).remove();
        }
        //$('#li'+name).remove();
    } else {
        if ($('.permisoscheck'+id).is(':checked')) {
            html='<label id='+name+'><input checked onclick="eliminar('+id+',\''+name+'\')" class="name me-2 permisoscheckgrabar'+id+'" name="permisos[]" type="checkbox" value="'+id+'">'+name+'</label>';
            $('#'+name).remove();
            $("#lista_permisos2").prepend(html);
            $('.radiocheck'+id).prop("checked", true);
            $('.permisoscheck'+id).prop("checked", true);
        } else {
            $('.radiocheck'+id).prop("checked", false);
            $('.permisoscheck'+id).prop("checked", false);
            $('#'+name).remove();
        }
        //$('#2'+name).remove();
    }
    
    
}

function eliminar(id,name) {
    //$('#2'+name).remove();
    $('#'+name).remove();
    $('.radiocheck'+id).prop("checked", false);
    $('.permisoscheck'+id).prop("checked", false);
    //html='<label id="2'+name+'"><input onclick="agregarpermiso('+id+',\''+name+'\')" class="name" name="permisos2[]" type="checkbox" value="'+id+'">'+name+'</label>';
    //$("#permisos2").prepend(html);
}