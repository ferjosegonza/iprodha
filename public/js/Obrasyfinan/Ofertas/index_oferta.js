$(".formulario").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    // let nombre = $(this).parent().parent().parent().find("td:nth-child(1)").html();
    
    //cambio los valores del modal -- ruta -- mensaje
    $('#presentar').attr('action',$(this).attr("action"));
    // $('#contenidoModal').text('Seguro que desea Eliminar el tipo solucionador \"'+nombre+'\"');
    $('#exampleModalCo').modal('show');
    
});

$(".validacion").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    let nombre = $("#empresa").val();
    
    //cambio los valores del modal -- ruta -- mensaje
    $('#validar').attr('action',$(this).attr("action"));
    $('#contenidoModal').text('¿Desea validar la Oferta de Obra de la empresa \"'+nombre+'\"?');
    $('#exampleModalVa').modal('show');
    
});

$(".rechazar").on('submit', function(evt){
    evt.preventDefault();  

    //obtengo el nombre
    let nombre = $("#empresa").val();
    
    //cambio los valores del modal -- ruta -- mensaje
    // $('#rechazar').attr('action',$(this).attr("action"));
    $('#rechaz').on('click', formSubmit);
    $('#contenidoModalRe').text('¿Desea rechazar la Oferta de Obra de la empresa \"'+nombre+'\"?');
    $('#exampleModalRe').modal('show');
    
});

function formSubmit()
{
    document.getElementById("rechazarOfe").submit();
}