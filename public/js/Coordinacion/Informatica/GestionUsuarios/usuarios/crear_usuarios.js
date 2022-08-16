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


 function agregarpermiso(id,name) {
    $('#'+name).remove();
    html='<label id='+name+'><input checked onclick="eliminar('+id+',\''+name+'\')" class="name me-2" name="permisos[]" type="checkbox" value="'+id+'">'+name+'</label>';
    
    $("#lista_permisos2").prepend(html);
    $('#2'+name).remove();
}

 function eliminar(id,name) {
    $('#2'+name).remove();
    $('#'+name).remove();
    html='<label id="2'+name+'"><input onclick="agregarpermiso('+id+',\''+name+'\')" class="name" name="permisos2[]" type="checkbox" value="'+id+'">'+name+'</label>';
    $("#permisos2").prepend(html);
 }



 function buscarroles () {

    var name2 = $("#name2").val();

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/rolesconpermisos",
        data: {
            name2: name2
        },
        success: function (response) {
            
            $( "#rolles label" ).each(function( index ) {
                console.log('pp')
                if(!$(this).find('input:nth-child(1)').prop('checked')){
                    console.log($(this).find('input:nth-child(1)').val())
                    $(this).remove()
                }
              });
                    
            html='';
            response.forEach(element => {

                if ($('#3'+element.id).length) {
                    $('#3'+element.id).remove()
                    html='<label id="3'+element.id+'"><input onclick="buscarpermisos('+element.id+')" checked class="name me-2" name="roles[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                } else {
                    html='<label id="3'+element.id+'"><input onclick="buscarpermisos('+element.id+')" class="name me-2" name="roles[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                }
                
                $("#rolles").append(html);
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));

};

function buscargrupos () {

    var name4 = $("#name4").val();

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/rolessinpermisos",
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

    var name3 = $("#name3").val();

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/buscarpermisos",
        data: {
            name3: name3
        },
        success: function (response) {
            console.log(response)
            $("#permisos2").empty();

            response.forEach(element => {
                
                html='<label id="2'+element.name+'"><input onclick="agregarpermiso('+element.id+',\''+element.name+'\')" class="name" name="permisos2[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                $("#permisos2").prepend(html);
            });
        },
        error: function (error) {
            console.log(error);
        }
    }));

};
function buscarpermisos (id) {


    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/buscarpermisosdelrol",
        data: {
            id: id
        },
        success: function (response) {
            console.log(response)
            $("#permisos").remove();
            html='<ul id="permisos">';
            
            response.forEach(element => {
                
                html=html+'<li>'+element.name+'</li>';
            });
            html=html+'</ul>';
            $("#lista_permisos").append(html);
        },
        error: function (error) {
            console.log(error);
        }
    }));

};