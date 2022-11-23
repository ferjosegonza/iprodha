$(function(){
    $('#selected-categoria').on('change', onSelectSubCatChangeAndSoluChange);
});

$(function(){
    $('#selected-solucionador').on('change', onSelectSubCatChangeAndSoluChange2);
});

function onSelectSubCatChangeAndSoluChange(){
    let vCatId = $(this).val();
    $.when($.ajax({
        type: "post",
        url: '/categoriaprob/'+vCatId+'/subcateg',
        data: {
            periodo: vCatId
        },
        success: function (response) {
            $("#selected-subcategoria").find('option').remove();
            $("#selected-subcategoria").append('<option value="">' + 'Seleccionar' +'</option>');
            response.forEach(element => {
                $("#selected-subcategoria").append('<option value="'+ element.idcatprobsub + '">'+element.catprobsub +'</option>');
            });
            
        },
        error: function (error) {
            console.log(error);
        }
    }));

    $.when($.ajax({
        type: "post",
        url: '/categoriaprob/'+vCatId+'/solucionadores',
        data: {
        periodo: vCatId
        },
        success: function (response) {
        $("#selected-solucionador").find('option').remove();
        $("#selected-solucionador").append('<option value="">' + 'Seleccionar' +'</option>');
        response.forEach(element => {
            $("#selected-solucionador").append('<option value="'+ element.idsolucionador + '">'+element.nombre +'</option>');
        });
        
        },
        error: function (error) {
         console.log(error);
        }
    }));
}

function onSelectSubCatChangeAndSoluChange2(){
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