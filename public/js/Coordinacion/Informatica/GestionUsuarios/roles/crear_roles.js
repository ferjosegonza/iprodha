
function seleccionarpermisos() {
    if ($('.selectall').is(':checked')) {
        $.each($('.permisos10'), function (ind, elem) {
            if (!elem.checked) {
                elem.click();
            }
        });
    }
}

 function buscarpermisosname () {
    $("#checkpermisos").prop('checked',false);
    var name3 = $("#name3").val();
    $.when($.ajax({
        type: "post",
        url: "/roles/buscarpermisos",
        data: {
            name3: name3
        },
        success: function (response) {


            $( "#permisos2 label" ).each(function( index ) {
                if(!$(this).find('input:nth-child(1)').prop('checked')){
                    $(this).remove()
                }else{
                    console.log($(this))
                }
              });

            console.log(response)
            html='';
            response.forEach(element => {
                if($('#2'+element.name).length){
                }else{
                    html=html+'<label id="2'+element.name+'"><input class="name permisos10 permisoscheck'+element.id+'" name="permission[]" type="checkbox" value="'+element.id+'">'+element.name+'</label>';
                }
                
            });
            $("#permisos2").append(html);
        },
        error: function (error) {
            console.log(error);
        }
    }));
};
 