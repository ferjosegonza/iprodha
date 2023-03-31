$(function(){
    // $('#info-obra').on('change', cambioEstado("info-obra"));
    $('#info-plazo').on('change', cambioEstado); //plazo-input
    $('#info-anio').on('change', cambioEstado); //anio-input
    $('#info-viv').on('change', cambioEstado); //viv-input
    $('#info-infra').on('change', cambioEstado); //infra-input
    $('#info-items').on('change', cambioEstado);//info-items-card
    $('#info-crono').on('change', cambioEstado);//info-crono-card
    $('#info-som').on('change', cambioEstado);//info-som-card
    $('#info-nexo').on('change', cambioEstado);//nexo-input
    // $('#addRow').on('click', nuevoCrono);
    // $('#item').on('change', mostrarAcumulado);
});

function cambioEstado(){
    // console.log('hola');
    console.log($(this).val());
    let id = $(this).val();
    if ( document.getElementById(id).className.match(/(?:^|\s)border-success(?!\S)/) ){
        document.getElementById(id).className = document.getElementById(id).className.replace( /(?:^|\s)border-success(?!\S)/g , ' border-danger');
    }else{
         document.getElementById(id).className = document.getElementById(id).className.replace( /(?:^|\s)border-danger(?!\S)/g , ' border-success');
    }
    sensarInformacion();
}

function sensarInformacion(){
    let componentes = ['viv-input', 'infra-input', 'anio-input', 'plazo-input', 'nexo-input'];
    let bandera = 0;
    componentes.forEach(element => {
        if(document.getElementById(element).className.match(/(?:^|\s)border-danger(?!\S)/) && bandera == 0){
            document.getElementById('info-obra-card').className = document.getElementById('info-obra-card').className.replace( /(?:^|\s)border-success(?!\S)/g , ' border-danger');
            bandera = 1;
        }else if(bandera == 0){
            document.getElementById('info-obra-card').className = document.getElementById('info-obra-card').className.replace( /(?:^|\s)border-danger(?!\S)/g , ' border-success');
        }
    });
    validarOrechazar();
}

function validarOrechazar(){
    let secciones = ['info-som-card', 'info-crono-card', 'info-items-card', 'info-obra-card'];
    let bandera = 0;
    let btnValidar = document.getElementById('btnValidar');
    let btnRechazar = document.getElementById('btnRechazar');
    let cardComentario = document.getElementById('cardComentario');
    divBoton = document.getElementById('botonVR');
    secciones.forEach(element => {
        if(document.getElementById(element).className.match(/(?:^|\s)border-danger(?!\S)/) && bandera == 0){
            btnValidar.style.display = 'none';
            btnRechazar.style.display = 'inline';
            cardComentario.style.display = 'inline';
            bandera = 1;
        }else if(bandera == 0){
            btnRechazar.style.display = 'none';
            btnValidar.style.display = 'inline';
            cardComentario.style.display = 'none';
        }
    });
}