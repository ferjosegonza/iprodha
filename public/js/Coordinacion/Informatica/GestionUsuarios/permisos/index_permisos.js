

$(".formulario").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    let nombre = $(this).parent().parent().parent().find("td:nth-child(1)").html();
    
    //cambio los valores del modal -- ruta -- mensaje
    $('#eliminar').attr('action',$(this).attr("action"));
    $('#contenidoModal').text('Seguro que desea Eliminar el permiso \"'+nombre+'\"');
    $('#exampleModal').modal('show');
    
 });

 