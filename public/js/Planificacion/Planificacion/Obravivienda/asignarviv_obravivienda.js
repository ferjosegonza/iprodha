$(function(){
    $('#buscavivienda').on('keyup', buscarVivienda);
    // $('#addRow').on('click', nuevoCrono);
    // $('#item').on('change', mostrarAcumulado);
});

function buscarVivienda(){
    let orden = document.getElementById('buscavivienda').value;
    let viviendaLista = document.getElementById('viviendasParaAsignar');

    if(orden != ''){
        viviendaLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/obravivienda/buscarviv/'+orden+'/'+obra, 
            data: {
                orden: orden,
            },
        success: function (response) {
            console.log(response);
            if(response.message){
                 viviendaLista.innerHTML = response.message;
            }else{
            // response.forEach(element => {
                // if($('.viv'+response.orden).is(':checked')){
                        // console.log('entra en el true');
                        viviendaLista.innerHTML += '<label id='+response.id_viv+'><input onclick="agregarRubro('+response.id_viv+',\''+response.orden+'\')" class="radiockeck'+response.id_viv+'" name="" type="checkbox" value=""> Viv. Orden N°: '+response.orden+'</label>';
                // }else{
                        // console.log('entra en el false');
                        // viviendaLista.innerHTML += '<label id='+element.id+'><input onclick="agregarRubro('+element.id+',\''+element.rubro+'\')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> '+element.rubro+'</label>';
                // }     
                // });
            }
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }else{
        viviendaLista.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/obravivienda/todaslasviviendas/'+obra, 
            data: {
                orden: orden,
            },
        success: function (response) {
            response.forEach(element => {
                if($('.viv'+element.id).is(':checked')){
                    viviendaLista.innerHTML += '<label id='+element.id_viv+'><input checked onclick="agregarVivienda('+element.id_viv+')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> Viv. Orden N°: '+element.orden+'</label>';
                }else{
                    viviendaLista.innerHTML += '<label id='+element.id_viv+'><input onclick="agregarVivienda('+element.id_viv+')" class="radiockeck'+element.id+'" name="" type="checkbox" value=""> Viv. Orden N°: '+element.orden+'</label>';
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
        }));
    }
}

function agregarVivienda(id, orden){
    // console.log(id);
    let viviendasListaAsignados = document.getElementById('viviendasAsignadas');
    let table = document.getElementById('tablavivbody');
    var rowCount = table.rows.length;
    
    if($('.radiockeck'+id).is(':checked')){
        viviendasListaAsignados.innerHTML += '<label id=viv'+id+'><input checked onclick="eliminarVivienda('+orden+','+id+')" class="vi'+orden+'" name="vivs[]" type="checkbox" value="'+id+'"> Viv. Orden N°: '+orden+'</label>';

        $.when($.ajax({
            type: "post",
            url: '/obra/vivienda/'+id, 
            data: {
                orden: orden,
            },
        success: function (response) {
            let row = table.insertRow(rowCount);
            let cell1 = row.insertCell(0);
            let cell2 = row.insertCell(1);
            let cell3 = row.insertCell(2);
            let cell4 = row.insertCell(3);
            let cell5 = row.insertCell(4);
            let cell6 = row.insertCell(5);
            let cell7 = row.insertCell(6);
            let cell8 = row.insertCell(7);
            let cell9 = row.insertCell(8);
            let cell10 = row.insertCell(9);
            let cell11 = row.insertCell(10);
            let cell12 = row.insertCell(11);

            cell1.classList.add("text-center");
            cell2.classList.add("text-center");
            cell3.classList.add("text-center");
            cell4.classList.add("text-center");
            cell5.classList.add("text-center");
            cell6.classList.add("text-center");
            cell7.classList.add("text-center");
            cell8.classList.add("text-center");
            cell9.classList.add("text-center");
            cell10.classList.add("text-center");
            cell11.classList.add("text-center");
            cell12.classList.add("text-center");

            cell1.innerHTML = response.orden;
            if (response.discap == 1) {
                cell2.innerHTML = 'SI';
            } else {
                cell2.innerHTML = 'NO';
            }
            cell3.innerHTML = response.plano;
            cell4.innerHTML = response.seccion;
            cell5.innerHTML = response.chacra;
            cell6.innerHTML = response.manzana;
            cell7.innerHTML = response.parcela;
            cell8.innerHTML = response.finca;
            cell9.innerHTML = response.edificio;
            cell10.innerHTML = response.piso;
            cell11.innerHTML = response.departamento;
            cell12.innerHTML = response.escalera;
        },
        error: function (error) {
            console.log(error);
        }
        }));
        
    }else{
        $('.radiockeck'+id).prop("checked", false);
        // $('.permisoscheck'+id).prop("checked", false);
        $('#viv'+id).remove();
        // $("#tablaviv").find("td:contains('"+orden+"')").closest('tr').remove();
        for (var i = 0, row; row = table.rows[i]; i++) {
            //alert(cell[i].innerText);
            if(row.cells[0].innerText === orden){
                table.deleteRow(i);
              }
            // for (var j = 0, col; col = row.cells[j]; j++) {
            //   //alert(col[j].innerText);
            //   console.log(row.cells[0]);
            //   if(row.cells[0] === orden){
            //     table.deleteRow(i);
            //   }
            // }
        }
    } 
}

function eliminarVivienda(orden, id){
    let viviendaParaAsignar = document.getElementById('viviendasParaAsignar');
    viviendaParaAsignar.innerHTML += '<label id=viv> <i class="fas fa-times" style="color: #ff0000;"></i> Viv. Orden N°:'+orden+' </label>';

    $('.radiockeck'+id).prop("checked", false);
    $('#viv'+id).remove();

    let table = document.getElementById('tablavivbody');

    for (var i = 0, row; row = table.rows[i]; i++) {
        if(row.cells[0].innerText === orden.toString()){
            table.deleteRow(i);
        }
    }
}