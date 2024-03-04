$(document).ready(function () {
    let table = $('#tabla-relacionados').DataTable({
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

/* function openBusqueda(){
    document.getElementById('busqueda').removeAttribute('hidden');
    document.getElementById('search-btn').innerHTML = '<i class="fas fa-search"></i>'
} */

function openPDF(archivo){
    document.getElementById('pdf-preview').removeAttribute('hidden')
    document.getElementById('lista-relacionados').setAttribute('class', 'col-lg-4 card')
    document.getElementById('titulo').innerHTML= 'Archivo '+ archivo.nro_archivo
    document.getElementById('info').innerHTML = '<b>Claves: </b>'  + archivo.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') 
    document.getElementById('pdf').setAttribute('src', archivo.path_archivo + archivo.nombre_archivo)
}

function cancelar(){
    document.getElementById('pdf-preview').setAttribute('hidden', 'hidden')
    document.getElementById('lista-relacionados').setAttribute('class', 'col-lg-12 card')
}

function  exportPDF(){
    //crear tabla
    let tabla = document.getElementById('tabla-relacionados')
    //
    let doc = new jsPDF('l', 'pt', 'a4');
    doc.autoTable({ html: tabla, 
        theme: 'grid', styles : { halign : 'center'}, headStyles :{fillColor : [124, 95, 240]}, alternateRowStyles: {fillColor : [231, 215, 252]}, tableLineColor: [124, 95, 240], tableLineWidth: 0.1,}, )
    console.log(tabla)
    let nombre = 'Historial_'+tabla.rows[1].cells[0].innerHTML;
    console.log(nombre)
    doc.save(nombre+'.pdf')    
}