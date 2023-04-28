$(function(){
    $('#selected-orden').on('change', onBuscarVivienda);
    // $('#guardarVivienda').on('click', alert('Se guardaron los datos de la vivienda'));
});

function onBuscarVivienda(){
    
    // let mes = $(this).val();
    let idviv = $("#selected-orden").val();
    let plano = document.getElementById('idplano');
    let partida = document.getElementById('idpartida');
    let partidaucac = document.getElementById('idpartidaucac');
    let vivdiscap = document.getElementById('idvivdisc');
    let seccion = document.getElementById('idseccion');
    let chacra  = document.getElementById('idchacra');
    let manzana = document.getElementById('idmanzana');
    let parcela = document.getElementById('idparcela');
    let finca = document.getElementById('idfinca');
    let edif = document.getElementById('idedif');
    let piso = document.getElementById('idpiso');
    let dpto = document.getElementById('iddepto');
    let esca = document.getElementById('idesca');
    let unfun = document.getElementById('idunfun');
    let empmanza = document.getElementById('idempmanza');
    let lote = document.getElementById('idlote');
    let nucalle = document.getElementById('idnumcalle');
    let nomcalle = document.getElementById('idnomcalle');
    let entrecalle = document.getElementById('identcalle');
    let numFinca = document.getElementById('idnumfinca');
    let supLote = document.getElementById('idsuplote');
    let supCubi = document.getElementById('idplano');
    let deslinde = document.getElementById('iddeslinde');
    
    $.when($.ajax({
        type: "post",
        url: '/obra/vivienda/'+idviv,
        data: {
             periodo: idviv
         },
        success: function (response) {
            plano.value = response.plano;
            partida.value = response.partida;
            partidaucac.value = response.partida_2;
            vivdiscap.value = response.discap;
            seccion.value = response.seccion;
            chacra.value = response.chacra;
            manzana.value = response.manzana;
            parcela.value = response.parcela;
            finca.value = response.finca;
            edif.value = response.edificio;
            piso.value = response.piso;
            dpto.value = response.departamento;
            esca.value = response.escalera;
            unfun.value = response.uni_fun;
            empmanza.value = response.man_emp;
            lote.value = response.lot_emp;
            nucalle.value = response.num_cal;
            nomcalle.value = response.nom_cal;
            entrecalle.value = response.entrecalles;
            numFinca.value = response.sup_fin;
            supLote.value = response.sup_lot;
            deslinde.value = response.deslinde;
            console.log(response);
         },
         error: function (error) {
             console.log(error);
         }
    }));
}