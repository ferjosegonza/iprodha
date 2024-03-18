document.addEventListener("input", checkBtn);

function checkBtn(){
    console.log(document.getElementById('datepicker').value)
}

function generarTurnos(){
    let id=document.getElementById('id').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/generarTurnos',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function fecha(){
    document.getElementById('datepicker').classList.remove('nofecha')
}

function visualizarDia(){
    let fecha = document.getElementById('datepicker').value
    let id=document.getElementById('id').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/getTurnosByFecha',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id,
            fecha
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            if(res.length > 0){
                mostrarTurnos(res);
            }
            else{
                document.getElementById('diaTracker').setAttribute('hidden', 'hidden')
                popup(2);
            }
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function popup(estado){  
    let popEl = document.getElementById('popup')
    if(estado == 1){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha reservado el turno.</p>'
    }
    else if(estado == 2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No existen turnos en la fecha indicada.</p>'
    }    
    else if(estado == 3){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido reservar el turno.</p>'
    }
    else if(estado == 4){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha borrado la cola.</p>'
        window.location.href = "/sociales/turnos";
    }
    else if(estado == 5){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido borrar la cola.</p>'
    }
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function mostrarTurnos(turnos){
    document.getElementById('diaTracker').removeAttribute('hidden');
    let head_Table= document.getElementById('turnos_head');
    let body_Table= document.getElementById('turnos_body');
    let puestoActual=turnos[0].puesto
    let band=0;
    let head = '<th style="width:60px; display:table-cell;">Puesto</th>'
    let body = '<tr><td style="width:60px; display:table-cell;">'+turnos[0].puesto+'</td>'
    turnos.forEach(turno => {
        if(puestoActual == turno.puesto){
            if(band == 0){
                head+='<th style="display:table-cell;"">'+turno.hora + ':' + turno.minuto +'</th>'
            }            
        }
        else{
            band = 1;
            body +='</tr><tr><td style="width:60px; display:table-cell;">'+turno.puesto+'</td>'
            puestoActual = turno.puesto;
        }
        if(turno.dni == null){
            body += '<td style="display:table-cell;" class="btn" onclick="popupTurno('+turno.idturno+')">Disponible +</td>'
        }
        else{
            body += '<td style="display:table-cell;"><u style="color:red;">Reservado</u> '+ turno.nombre + '. DNI:' + turno.dni +'</td>'
        }
    });
    body += '</tr>'
    if ( $.fn.DataTable.isDataTable('#turnos') ) {
        $('#turnos').DataTable().destroy();
        $('#turnos tbody').empty();
        $('#turnos thead').empty();
      }
    head_Table.innerHTML = head;
    body_Table.innerHTML = body;
    $('#turnos').DataTable({
        scrollX: true,
        paging:   false,
        ordering: false,
        info:     false,
       language: {
        search: 'Buscar'
       }    
    });
}

function popupTurno(id){
    document.getElementById('btnReservar').setAttribute('onclick', 'reservar('+id+')');
    document.getElementById('btnReservar').setAttribute('disabled', 'disabled')
    document.getElementById('nom_titular').setAttribute('hidden','hidden');
    let popEl = document.getElementById('popupTurno')
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function checkBtnVerificar(){
    if(document.getElementById('dni').value != ''){
        document.getElementById('btnVerificar').removeAttribute('disabled');
    }
    else{
        document.getElementById('btnVerificar').setAttribute('disabled', 'disabled');
    }
}

function verificarDni(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/verificarUsuario',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            dni: document.getElementById('dni').value
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            if(res.length>0){
                document.getElementById('nom_titular').removeAttribute('hidden');
                document.getElementById('nombre').value = res[0].nombre;
                document.getElementById('btnReservar').removeAttribute('disabled')
            }
            else{
                alert('No se ha encontrado un titular con ese DNI.')
            }
        },
        error: function(res){
            console.log(res)
        }
    });     
}

function reservar(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/reservarTurno',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id,
            dni: document.getElementById('dni').value
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            popup(1);
            visualizarDia();
        },
        error: function(res){
            console.log(res)
            popup(3)
        }    });   
    
}

function borrarColaPopUp(){
    let popEl = document.getElementById('popupBorrar')
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function borrarCola(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/borrarCola',
        type: 'DELETE',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id : document.getElementById('id').value
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            popup(4);
        },
        error: function(res){
            console.log(res)
            popup(5)
        }
    });       
}

