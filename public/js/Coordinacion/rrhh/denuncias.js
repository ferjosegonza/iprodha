$(document).ready(function (){
//window.addEventListener("DOMContentLoaded", (event) =>
    $('#tabla-lista-denuncias').DataTable({
        language: {
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se ha encontrado registros',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No se ha encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
            },
            "aaSorting": []
    });
});

// Muestra y oculta los submenús al hacer clic en los botones
document.getElementById('dropdownDenunciante').addEventListener('click', function () {
    document.getElementById('dropdownDenunciante').classList.toggle('show');
});

document.getElementById('dropdownVictima').addEventListener('click', function () {
    document.getElementById('dropdownVictima').classList.toggle('show');
});

document.getElementById('dropdownDenunciado').addEventListener('click', function () {
    document.getElementById('dropdownDenunciado').classList.toggle('show');
});


function confirmarBorrado(event, es_victima, id_denuncia) {
    let mensaje = '';
    if (es_victima){
        mensaje = 'Tenga en cuenta que el Denunciante es también Víctima, se borrarán ambos registros. ¿Confirma?';
    } else {
        mensaje = '¿Confirma que desea borrar el registro?';
    }

    if (confirm(mensaje)) {
        // Si el usuario confirma, permitimos el envío del formulario
        return true;
    } else {
        // Si el usuario cancela, preventimos el envío del formulario
        event.preventDefault();
        return false;
    }
}

function confirmarModificado(event, esDenuncianteVictima) {
    let mensaje = '';
    //let es_victima = $('#denunciante_victima').checked;
    if (esDenuncianteVictima){
        mensaje = 'Tenga en cuenta que las modificaciones sobre Denunciante también impactarán sobre los datos de la Víctima. ¿Confirma?';
    } else {
        mensaje = '¿Confirma que desea modificar el registro?';
    }

    if (confirm(mensaje)) {
        // Si el usuario confirma, permitimos el envío del formulario
        return true;
    } else {
        // Si el usuario cancela, preventimos el envío del formulario
        event.preventDefault();
        return false;
    }
}

function exportPDF() {
    var doc = new jsPDF('p', 'pt', 'a4');
    var source = document.getElementById('content').innerHTML;

    doc.fromHTML(source, 15, 15, {
        'width': 560,
        'elementHandlers': {}
    }, function () {
        doc.save('documento.pdf');
    }, {
        orientation: 'p',
        unit: 'pt',
        format: 'a4',
        align: 'center',
        autocenter: true
    });
}


/*
function  exportPDF(){
    //crear tabla
    let tabla = crearTablaImprimir()
    //
    var doc = new jsPDF('l', 'pt', 'a4');
    doc.autoTable({ html: tabla, 
        didParseCell: function(cell, data){ 
            if (cell.row.index === 1){ 
                cell.cell.styles.fontStyle = 'bold'; 
            }
            if (cell.row.index === 0 && cell.column.index % 2 == 0){
                cell.cell.styles.fontStyle = 'bold';                                  
            }
        },
        theme: 'grid', styles : { halign : 'center'}, headStyles :{fillColor : [124, 95, 240]}, alternateRowStyles: {fillColor : [231, 215, 252]}, tableLineColor: [124, 95, 240], tableLineWidth: 0.1,}, )
    let nombre = document.getElementById('apellido').value + '-' + document.getElementById('nombre').value
    doc.save(nombre+'.pdf')    
}

function crearTablaImprimir(){
    let table = document.createElement('table')
    table.innerHTML = '<tr><th><b>Nombre del Agente</b></th><td>' + document.getElementById('apellido').value + ', ' + document.getElementById('nombre').value + '</td><th style="width=15%"><b>Agrupamiento</b></th><td>' + document.getElementById('agrupamiento').value + '</td><th><b>Categoria</b></th><td>' + document.getElementById('categoria').value + '</td></tr>'
    let historial = document.getElementById('historial')
    let str =''
    for (let i = 0, row; row = historial.rows[i]; i++) {
        str = str + '<tr>'
        for (let j = 0, col; col = row.cells[j]; j++) {
          //alert(col[j].innerText);
            if(i == 0){
                if((j+1)%4 == 0){
                    str=str + '<th colspan="3">' +col.innerText + '</th>'
                }
                else{
                    str=str + '<th>' +col.innerText + '</th>'
                }

            } else {
                if((j+1)%4 == 0){
                    str=str + '<td colspan="3">' +col.innerText + '</td>'
                }
                else{
                    str=str + '<td>' +col.innerText + '</td>'
                }
            }

            console.log(`Txt: ${col.innerText} \tFila: ${i} \t Celda: ${j}`);
        }
    str=str+'</tr>'
    }
    table.innerHTML = table.innerHTML + str
    console.log(table)
    console.log(str)
    return table
}*/