$(function(){
    $('#id_tip_ant').on('change', onSelectAntChange);
});


function onSelectAntChange(){
    
    let idant = document.getElementById("id_tip_ant").value;
    var descripant = document.getElementById("descripcion_ant");

    if(idant){
        $.when($.ajax({
            type: "post",
            url: '/ofeobra/'+idant+'/anticipo',
            data: {
                idant: idant,
            },
        success: function (response) {
            descripant.value = response;
            },
        error: function (error) {
            console.log(error);
        }
        }));
    }else{
        descripant.value = "-";
    }
    
}

