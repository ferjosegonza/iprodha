$(".formulario").on('submit', function(evt){
    evt.preventDefault();  
    $('#presentar').attr('action',$(this).attr("action"));
    cargarModal();
    $('#exampleModalCo').modal('show');    
});

function enviarDatos(){
    $form = $('.formulario');
    $form.submit();
}

function cargarModal(){
    $('#num_obr_m').val(document.getElementById('num_obr').value);
    $('#nom_obr_m').val(document.getElementById('nom_obr').value);
    $('#can_viv_m').val(document.getElementById('can_viv').value);
}