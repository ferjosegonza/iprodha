$(function(){
    $('#etapa').on('change', buscarLasViviendas);
});


function buscarLasViviendas(){
    let etapa = document.getElementById('etapa').value;
    console.log(etapa);

    $.when($.ajax({
        type: "post",
        url: '/obravivienda/viviendasdelaetapa/'+etapa, 
        data: {
            etapa: etapa,
        },
    success: function (response) {
        console.log(response);
        // if(response.message){
        //      viviendaLista.innerHTML = response.message;
        // }else{
        // // response.forEach(element => {
        //     // if($('.viv'+response.orden).is(':checked')){
        //             // console.log('entra en el true');
        //             viviendaLista.innerHTML += '<label id='+response.id_viv+'><input onclick="agregarRubro('+response.id_viv+',\''+response.orden+'\')" class="radiockeck'+response.id_viv+'" name="" type="checkbox" value=""> Viv. Orden N°: '+response.orden+'</label>';
        //     // }else{
        //             // console.log('entra en el false');
        //             // viviendaLista.innerHTML += '<label id='+element.id+'><input onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
        //     // }     
        //     // });
        // }
    },
    error: function (error) {
        console.log(error);
    }
    }));
}