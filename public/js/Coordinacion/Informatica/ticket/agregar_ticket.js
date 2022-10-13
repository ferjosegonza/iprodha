$(function(){
    $('#selected-solucionador').on('change', onSelectSubCatChangeAndSoluChange);
});

function onSelectSubCatChangeAndSoluChange(){
    let vCatId = $(this).val();
    $.when($.ajax({
        type: "post",
        url: '/ticket/'+vCatId+'/solu',
        data: {
            periodo: vCatId
        },
        success: function (response) {
            // $("#selected-subcategoria").find('option').remove();
            // console.log(response);
            // $("#tabla-datos").append().remove();
            $("#fila").remove();
            $("#tabla-datos").append('<tr id="fila"> <td>'+response.nombre+'</td> <td>'+response.totalEnproc+'</td> <td>'+response.totalAsign+'</td> <td>'+response.total+'</td></tr>');

            // $("#selected-subcategoria").append('<option value="">' + 'Seleccionar' +'</option>');
            // response.forEach(element => {
            //     $("#tabla-datos").append('<tr> <td>'+element.nombre+'</td> <td>'+element.nombre+'</td> <td>'+element.nombre+'</td> <td>'+element.nombre+'</td></tr>');
            // });
            
        },
        error: function (error) {
            console.log(error);
        }
    }));    
}