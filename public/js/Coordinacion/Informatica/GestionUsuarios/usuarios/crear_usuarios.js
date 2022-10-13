var BanderaFormulario = false;

function clickSubmit() {
    BanderaFormulario=true;
    $('#submit').click();
}

$(".formulario").on('submit', function(evt){
    if (BanderaFormulario) {
        return;
    }
    evt.preventDefault();     
 });


function seleccionarpermisos() {
    if ($('#checkpermisosrol').is(':checked')) {
        $.each($('.radioch'), function (ind, elem) {
            if (!elem.checked) {
                elem.click();
            }
        });
    }else{
        $.each($('.radioch'), function (ind, elem) {
            if (elem.checked) {
                elem.click();
            }
        });
    }
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



 function buscarroles (val) {
    $("#checkpermisosrol").prop('checked',false);

    var estilo='';

    if (val==2) {
        estilo='text-danger';
    }
    var name2 = $("#name2").val();

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/usuarios/rolesconpermisos",
        data: {
            name2: name2
        },
        success: function (response) {
            
            $( "#radio tr" ).each(function( index ) {
                if(!$(this).find('td:nth-child(2)').find('input:nth-child(1)').prop('checked')){
                    $(this).remove()
                }
              });
                    
            html='';
            response.forEach(element => {
                if ($('#trradio'+element.id).length) {
                    $('#trradio'+element.id).remove()
                    html='<tr id="trradio'+element.id+'"><td style="width: 90%"><label><input onclick="buscarpermisos('+element.id+');handleRadioClick(this)" id="rr'+element.id+'" class="name " name="roless" type="radio" value="'+element.id+'"> '+element.name+'</label></td><td id="3'+element.id+'"><input checked="" id="r'+element.id+'" onclick="" class="name" name="roles[]" type="checkbox" value="'+element.id+'"></td></tr>';

                } else {
                    html='<tr id="trradio'+element.id+'"><td style="width: 90%"><label class=" '+estilo+'"><input onclick="buscarpermisos('+element.id+');handleRadioClick(this)" id="rr'+element.id+'" class="name " name="roless" type="radio" value="'+element.id+'"> '+element.name+'</label></td><td id="3'+element.id+'"><input id="r'+element.id+'" disabled="disabled" onclick="" class="name" name="roles[]" type="checkbox" value="'+element.id+'"></td></tr>';
                }
                
                $("#radio").append(html);
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));

};


function seleccionarpermisostodos() {
    if ($('#checkpermisos').is(':checked')) {
        $.each($('.permisos10'), function (ind, elem) {
            if (!elem.checked) {
                elem.click();
            }
        });
    }else{
        $.each($('.permisos10'), function (ind, elem) {
            if (elem.checked) {
                elem.click();
            }
        });
    }
  }



function buscarvista(id) {

    $.ajax({
        type: "post",
        url: "http://192.168.10.84/roles/buscarrol",
        data: {
            id: id
        },
        success: function (response) {
            $('#name2').val(response.rol.name);
            $('#name2').html(response.rol.name);
            buscarroles(2)
            $('#name2').val('');
            $('#name2').html('');
            
        },
        error: function (error) {
            console.log(error);
        }
    });

}

function buscargrupos () {

    var name4 = $("#name4").val();

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/usuarioskk/rolessinpermisos",
        data: {
            name4: name4
        },
        success: function (response) {
            
            $( "#grupos4 label" ).each(function( index ) {
                console.log('pp')
                if(!$(this).find('input:nth-child(1)').prop('checked')){
                    console.log($(this).find('input:nth-child(1)').val())
                    $(this).remove()
                }
              });
                    
            html='';
            response.forEach(element => {

                if ($('#4'+element.id).length) {
                    $('#4'+element.id).remove()
                    html='<label id="4'+element.id+'"><input  checked class="name me-2" name="grupos4[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                } else {
                    html='<label id="4'+element.id+'"><input class="name me-2" name="grupos4[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                }
                
                $("#grupos4").append(html);
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));

};

function buscarpermisosname () {
    $("#checkpermisos").prop('checked',false);
    var name3 = $("#name3").val();
    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/usuarios/buscarpermisos",
        data: {
            name3: name3
        },
        success: function (response) {
            console.log(response)
            $("#permisos2").empty();
            response.forEach(element => {
                if($('#'+element.name).length){
                    
                    html='<label id="2'+element.name+'"><input checked onclick="agregarpermiso('+element.id+',\''+element.name+'\','+element.id+')" class="name permisos10  permisoscheck'+element.id+'" name="permisos10[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                }else{
                    html='<label id="2'+element.name+'"><input onclick="agregarpermiso('+element.id+',\''+element.name+'\','+element.id+')" class="name permisos10 permisoscheck'+element.id+'" name="permisos10[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                }
                $("#permisos2").append(html);
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));
};

var currentValueRadio = 0;
function handleRadioClick(myRadio) {
    $("#r"+myRadio.value).prop('disabled',false);
    $("#checkpermisosrol").prop('checked',false);
    
    $("#r"+currentValueRadio).prop('checked') ? $("#r"+currentValueRadio).prop('disabled',false) : $("#r"+currentValueRadio).prop('disabled',true);
    currentValueRadio = myRadio.value;
}

function buscarpermisos (id) {
    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/usuarios/buscarpermisosdelrol",
        data: {
            id: id
        },
        success: function (response) {
            $("#permisos").remove();
            html='<ul style="list-style: none;" id="permisos">';
            response.forEach(element => {
                if ($('.permisoscheckgrabar'+element.id).is(':checked')) {
                    html=html+'<li id="li'+element.name+'" class="my-0 "><label class="my-0" id="3'+element.name+'"><input checked onclick="agregarpermiso('+element.id+',\''+element.name+'\',1)" class="name me-2 tt'+element.id+' radioch radiocheck'+element.id+'" name="'+element.id+'permisosroles" type="checkbox" value="'+element.id+'">'+element.name+'</label></li>';
                }else{
                    html=html+'<li id="li'+element.name+'" class="my-0 "><label class="my-0" id="3'+element.name+'"><input onclick="agregarpermiso('+element.id+',\''+element.name+'\',1)" class="name me-2  tt'+element.id+' radioch radiocheck'+element.id+'" name="'+element.id+'permisosroles" type="checkbox" value="'+element.id+'">'+element.name+'</label></li>';
                }
            });
            html=html+'</ul>';
            $("#lista_permisos").append(html);
            //$("#r"+id).prop('disabled',false);
        },
        error: function (error) {
            console.log(error);
        }
    }));

};

