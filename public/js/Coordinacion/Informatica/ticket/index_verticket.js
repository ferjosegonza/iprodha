$(".re-asignar").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    // let nombre = $(this).parent().parent().parent().find("td:nth-child(1)").html();
    
    //cambio los valores del modal -- ruta -- mensaje
    $('#asignar').attr('action',$(this).attr("action"));
    // $('#contenidoModal').text('Seguro que desea Eliminar el tipo solucionador \"'+nombre+'\"');
    $('#modalTicketReAsignar').modal('show');
    
});

$(".validar").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    // let nombre = $(this).parent().parent().parent().find("td:nth-child(1)").html();
    
    //cambio los valores del modal -- ruta -- mensaje
    $('#cerrar').attr('action',$(this).attr("action"));
    // $('#contenidoModal').text('Seguro que desea Eliminar el tipo solucionador \"'+nombre+'\"');
    $('#modalTicketValidar').modal('show');
    
});