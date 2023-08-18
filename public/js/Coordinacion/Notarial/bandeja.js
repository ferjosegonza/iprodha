$(document).ready(function () {
    let table = $('#pendientes').DataTable({
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
    table.columns(4).search('Pendiente').draw();
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
            location.reload() 
                   
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function filter(tipo){
    let table = $('#pendientes').DataTable()
    if(tipo == 't'){
        table.columns(4).search('').draw();
    }
    if(tipo == 'c'){
        table.columns(4).search('Cerrado').draw();
    }
    if(tipo == 'p'){
        table.columns(4).search('Pendiente').draw();
    }
}