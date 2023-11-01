function enable(){
    document.getElementById('prev').removeAttribute('disabled')
}

function previsualizar(){
    let val = document.getElementById('tipo').value
    if(val == 1){
        boletas()
    }
}

function boletas(){
    let pendientes = document.getElementById('pendientes')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notificaciones/boletas/pendientes',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            console.log(res)
            if(res.length > 0){
                let innerHTML
                if(res.length == 1){
                    innerHTML = '<label>Hay 1 notificación pendiente.</label>'
                }
                else{
                    innerHTML = '<label>Hay ' + res.length + ' notificaciones pendientes.</label>'
                }
                innerHTML = innerHTML + '<table id="pendientesTabla"><thead><th>Cuil</th><th>Encabezado</th><th>Mensaje</th><th>Fecha</th></thead><tbody>'
                res.forEach((noti) => {
                    innerHTML = innerHTML + '<tr><td>'+noti.usuario+'</td><td>'+noti.encabezado+'</td><td>'+noti.mensaje+'</td><td>'+noti.fecha+'</td></tr>'
                })
                innerHTML = innerHTML + '</tbody></table><button class="btn btn-primary" onclick="enviarBoletas()">Enviar notificaciones</button>'
                pendientes.innerHTML = innerHTML
                pendientes.removeAttribute('hidden')
                tabla()
            }
            else{
                pendientes.innerHTML = 'No existen notificaciones pendientes que enviar.'
                pendientes.removeAttribute('hidden')
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}


function tabla() {
  $('#pendientesTabla').DataTable({
       orderCellsTop: true,
       fixedHeader: true,
       "bSort":false,
       language: {
           lengthMenu: 'Mostrar _MENU_ registros por página',
           zeroRecords: 'No se han encontrado registros',
           info: 'Mostrando página _PAGE_ de _PAGES_',
           infoEmpty: 'No se han encontrado registros',
           infoFiltered: '(Filtrado de _MAX_ registros totales)',
           search: 'Buscar',
           paginate:{
               first:"Prim.",
               last: "Ult.",
               previous: 'Ant.',
               next: 'Sig.',
           },
       },
       order: [[ 1, 'asc' ]]
    })
}

function enviarBoletas(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notificaciones/boletas/enviar',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            if(res == 1){
                popup(1)
            }
            else{
                popup(2)
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
            popup(3)
        }   
    });
}

function popup(tipo){  
    let popEl = document.getElementById('popup')
    if(tipo == 1 ){
        document.getElementById('popTitulo').innerHTML = 'Éxito'     
        document.getElementById('popBody').innerHTML = '<p>Se ha enviado la notificación.</p>'      
    }
    else if(tipo == 2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido enviar la notificación.</p>'      
    }    
    else{
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>Hubo un error desconocido.</p>'      
    }
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function ocultarPagina(){
    document.getElementById('pendientes').setAttribute('hidden', 'hidden')
}