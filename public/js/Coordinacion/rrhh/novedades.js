
window.addEventListener("DOMContentLoaded", (event) => {
    let buscar = document.getElementById('buscar')
    let dni = document.getElementById('dni')

    const verificarBuscar = () => {
        if(dni.value != ''){
            buscar.removeAttribute('disabled')
        }
        else{
            buscar.setAttribute('disabled','disabled')
        }
    }
    dni.addEventListener('keyup', verificarBuscar)
});

function buscarAgente(){
    let dni = document.getElementById('dni').value  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }   
    });
    $.ajax({
        url: window.location.origin + '/agente/buscar',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            dni:dni
        }),
        dataType: 'json',
        success: function(res) {          
            console.log(res)
            if(Object.keys(res).length >0){
                mostrarAgente(res[0])
                mostrarHistorial(res[0].idagente)
                buscarDNI(res[0].nrodoc)
            }
            //else popup
            
        },
        error: function(res){
            console.log(res)
        }});
}

function mostrarAgente(agente){
    console.log(agente)    
    document.getElementById('id').innerHTML= agente.idagente
    let resultados = document.getElementById('resultados')
    document.getElementById('dni2').value = agente.nrodoc
    document.getElementById('nombre').value = agente.nombre
    document.getElementById('apellido').value = agente.apellido
    document.getElementById('agrupamiento').value = agente.agrupamiento
    document.getElementById('categoria').value = agente.idcateg
    resultados.removeAttribute('hidden')
}

function mostrarHistorial(id){
    //console.log(id)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/agente/historial',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res) {          
            console.log(res)
            let info = document.getElementById('info-historial')
            while(info.hasChildNodes()){
                info.removeChild(info.lastChild)
            }
            for(let i=0; i<res.length; i++){
                tr = document.createElement('tr')
                let str, str2
                if(res[i].observacion==null){
                    str='-'
                }
                else{
                    str=res[i].observacion
                }
                if(res[i].idarchivo==null){
                    str2='-'
                }
                else{
                    str2=res[i].tipo 
                    if(res[i].subtipo != null){
                        str2 = str2+ '-' + res[i].subtipo
                    }
                    if(res[i].nro_archivo != null){
                        str2 = str2+ '-' + res[i].nro_archivo
                    }
                }
                tr.innerHTML = '<td>'+res[i].fecha.slice(0, 10)+'</td>'+'<td>'+res[i].detalle+'</td>'+'<td>'+str2+'</td>'+'<td>'+str+'</td>'
                info.appendChild(tr)
            }
        },
        error: function(res){
            console.log(res)
        }});
}

$(document).ready(function () {
    $('#historial').DataTable({
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

function redirect(){
    id = document.getElementById('id').innerHTML
    location.href = '/'+ id + "/crear_novedad";
}

function excel(type, fn, dl){
    let nombre = document.getElementById('apellido').value + '-' + document.getElementById('nombre').value
    var elt = crearTablaImprimir();
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
      XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
      XLSX.writeFile(wb, fn || (nombre +'.' + (type || 'xlsx')));
}

var specialElementHandlers = {
    // element with id of "bypass" - jQuery style selector
    '.no-export': function (element, renderer) {
        // true = "handled elsewhere, bypass text extraction"
        return true;
    }
};
    
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
            
          }
          else{
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
}

function buscarDNI(dni){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/archivo/dni',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            dni:dni
        }),
        dataType: 'json',
        success: function(res) {          
            console.log(res)
            document.getElementById('dniemb').setAttribute('src', res);
            document.getElementById('dnipdf').removeAttribute('hidden')
        },
        error: function(res){
            console.log(res)
        }});
}

function mostrarDni(){
    if($('#dniemb').is(':hidden')){
        document.getElementById('dniemb').removeAttribute('hidden');
    }
    else{
        document.getElementById('dniemb').setAttribute('hidden', 'hidden');
    }
}