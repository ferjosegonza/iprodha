$(function(){
    $('#selected-categoria').on('change', onSelectSubCatChangeAndSoluChange);
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