$(function(){
    $('#selected-categoria').on('change', onSelectSubCatChange);
});

function onSelectSubCatChange(){
    let vCatId = $(this).val();

    $.when($.ajax({
        type: "post",
        url: '/categoriaprob/'+vCatId+'/subcateg',
        data: {
            periodo: vCatId
        },
        success: function (response) {
            $("#selected-subcategoria").find('option').not(':first').remove();
            response.forEach(element => {
                $("#selected-subcategoria").append('<option value="'+ element.idcatprobsub + '">'+element.catprobsub +'</option>');
            });
            
        },
        error: function (error) {
            console.log(error);
        }
    }));
}
