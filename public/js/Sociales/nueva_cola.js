document.addEventListener("input", checkBtn);

function checkBtn(){
    let descripcion = document.getElementById('descripcion').value;
    let puestos = document.getElementById('puestos').value;
    let duracion = document.getElementById('duracion').value;
    let desde = document.getElementById('desde').value;
    let hasta = document.getElementById('hasta').value;
    let btn = document.getElementById('guardar');
    let checked = false;
    checked += document.getElementById('checkLunes').checked;
    checked += document.getElementById('checkMartes').checked;
    checked += document.getElementById('checkMiercoles').checked;
    checked += document.getElementById('checkJueves').checked;
    checked += document.getElementById('checkViernes').checked;
    if(descripcion != '' && puestos != '' && duracion != '' && desde != '' && hasta != '' && desde<hasta && puestos>0 && duracion>0 && checked){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function checkDias(dia){  
if(document.getElementById('check'+dia).checked){
    return true;
}
else{
    return false;
}
}

function guardar(){
    let descripcion = document.getElementById('descripcion').value;
    let puestos = document.getElementById('puestos').value;
    let duracion = document.getElementById('duracion').value;
    let desde = document.getElementById('desde').value;
    let hasta = document.getElementById('hasta').value;
    let tramite = document.getElementById('tramite').value;
    let dias=[];
    dias[0] = checkDias('Lunes')
    dias[1] = checkDias('Martes')
    dias[2] = checkDias('Miercoles')
    dias[3] = checkDias('Jueves')
    dias[4] = checkDias('Viernes')  
    horarioLunes={
        'horaInicio': document.getElementById('lunes_inicio_hora').value,
        'minInicio': document.getElementById('lunes_inicio_min').value,
        'horaFin': document.getElementById('lunes_fin_hora').value,
        'minFin': document.getElementById('lunes_fin_min').value,
    }
    horarioMartes={
        'horaInicio': document.getElementById('martes_inicio_hora').value,
        'minInicio': document.getElementById('martes_inicio_min').value,
        'horaFin': document.getElementById('martes_fin_hora').value,
        'minFin': document.getElementById('martes_fin_min').value,
    }
    horarioMiercoles={
        'horaInicio': document.getElementById('miercoles_inicio_hora').value,
        'minInicio': document.getElementById('miercoles_inicio_min').value,
        'horaFin': document.getElementById('miercoles_fin_hora').value,
        'minFin': document.getElementById('miercoles_fin_min').value,
    }
    horarioJueves={
        'horaInicio': document.getElementById('jueves_inicio_hora').value,
        'minInicio': document.getElementById('jueves_inicio_min').value,
        'horaFin': document.getElementById('jueves_fin_hora').value,
        'minFin': document.getElementById('jueves_fin_min').value,
    }
    horarioViernes={
        'horaInicio': document.getElementById('viernes_inicio_hora').value,
        'minInicio': document.getElementById('viernes_inicio_min').value,
        'horaFin': document.getElementById('viernes_fin_hora').value,
        'minFin': document.getElementById('viernes_fin_min').value,
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'postCola',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            descripcion: descripcion,
            puestos: puestos,
            duracion: duracion,
            desde: desde,
            hasta: hasta,
            tramite:tramite,
            dias: dias,
            horarioLunes,
            horarioMartes,
            horarioMiercoles,
            horarioJueves,
            horarioViernes
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            if(res == 1){
                popup(1)
            }
            else{
                popup(2)
            }
        },
        error: function(res){
            console.log(res)
            popup(3)
        }
    }); 
}

$(document).ready(function () {
    $('#horarios').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        "bSort":false,
        language: {
            lengthMenu: 'Mostrando _MENU_ registros',
            zeroRecords: 'No se han encontrado registros',
            info: 'Pág _PAGE_ de _PAGES_',
            infoEmpty: 'No se han encontrado registros',
            infoFiltered: '(De _MAX_ registros totales)',
            search: 'Buscar',
            paginate:{
                first:"Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },
        order: [[ 1, 'asc' ]]
    });
});

function popup(estado){  
    let popEl = document.getElementById('popup')
    if(estado == 1){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha creado la cola.</p>'        
    }
    else if(estado == 2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido crear la cola.</p>'
    }    
    else if(estado == 3){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>Ha ocurrido un error desconocido.</p>'       
    }   
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}
