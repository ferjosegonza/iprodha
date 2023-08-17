$(document).ready(function () {
    $('#pendientes').DataTable({
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

function cerrar(id){
    console.log(id)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/' + id + '/cerrar',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val()
        }),
        dataType: 'json',
        success: function(res){             
            console.log(res) 
           actualizarTabla()
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function actualizarTabla(){
    let body = document.getElementById('bodyTramite')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/gettramites',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val()
        }),
        dataType: 'json',
        success: function(res){ 
            /* while(body.hasChildNodes()){
                body.removeChild(body.lastChild)
            }
            if(res.length>0){
              for(let i = 0; i<res.length; i++){
                let tr = document.createElement('tr')
                tr.innerHTML = '<td>'+res[i].descripcion+'</td>' + '<td>'+res[i].fecha+'</td>'+'<td>'+res[i].nombre_comitente+'</td>'+'<td>'+res[i].dni_comitente+'</td>'+'<td> <a href="/tramite/\''+res[i].id_tramite+'\'/movimientos" class="btn btn-outline-primary btn-sm">Movimientos</a><button onclick="cerrar(\''+res[i].id_tramite+'\')" class="btn btn-outline-danger btn-sm">Cerrar trámite</button></td>'
                body.appendChild(tr)
                }
                $('#pendientes').DataTable().draw();  
            }
            else{
                let tr = document.createElement('tr')
                tr.innerHTML = '<td colspan="5">No se han encontrado registros</td>'
                body.appendChild(tr)
            } */
            location.reload() 
                   
        },
        error: function(res){
            console.log(res)
        }
    }); 
}