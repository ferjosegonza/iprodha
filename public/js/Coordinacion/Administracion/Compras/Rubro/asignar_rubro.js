$(function(){
    $('#buscarubro').on('keyup', buscarRubro);
    // $('#addRow').on('click', nuevoCrono);
    // $('#item').on('change', mostrarAcumulado);
});

function buscarRubro(){
    let nombre = document.getElementById('buscarubro').value;
    let rubrosLista = document.getElementById('rubrosParaAsignar');

    if(nombre != ''){
        rubrosLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/rubroxemp/buscar/rubro/'+nombre, 
            data: {
                nombre: nombre,
            },
        success: function (response) {
            console.log(response);
            if(response.message){
                rubrosLista.innerHTML = '<p>No se encuentra.</p>'
            }else{
                response.forEach(element => {
                    if($('.ru'+element.id).is(':checked')){
                        // console.log('entra en el true');
                        rubrosLista.innerHTML += '<label id='+element.id+'><input checked onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                    }else{
                        // console.log('entra en el false');
                        rubrosLista.innerHTML += '<label id='+element.id+'><input onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                    }
                    
                });
            }
            
            
            // rubrosLista.innerHTML = html;
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }else{
        rubrosLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/todorubro', 
            data: {
                nombre: nombre,
            },
        success: function (response) {
            response.forEach(element => {
                if($('.ru'+element.id).is(':checked')){
                    rubrosLista.innerHTML += '<label id='+element.id+'><input checked onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                }else{
                    rubrosLista.innerHTML += '<label id='+element.id+'><input onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }
}

function agregarRubro(id, name){
    let rubrosListaAsignados = document.getElementById('rubrosAsignados');
    if($('.radiockeck'+id).is(':checked')){
        rubrosListaAsignados.innerHTML += '<label id=rub'+id+'><input checked onclick="eliminarRubro('+id+')" class="ru'+id+'" name="rubros[]" type="checkbox" value="'+id+'"> '+name+'</label>';
    }else{
        $('.radiockeck'+id).prop("checked", false);
        // $('.permisoscheck'+id).prop("checked", false);
        $('#rub'+id).remove();
    } 
}

function eliminarRubro(id){
    $('.radiockeck'+id).prop("checked", false);
    $('#rub'+id).remove();
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