$(document).ready(function () {
    let table = $('#colas').DataTable({
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
    table.columns(3).search('Pendiente').draw();
});


function filter(tipo){
    let table = $('#colas').DataTable()
    if(tipo == 't'){
        table.columns(3).search('').draw();
    }
    if(tipo == 'c'){
        table.columns(3).search('Cerrada').draw();
    }
    if(tipo == 'p'){
        table.columns(3).search('Pendiente').draw();
    }
    if(tipo == 'pu'){
        table.columns(3).search('Publicada').draw();
    }
}