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
                mostrarAgente(res)
                mostrarHistorial(res.idagente)
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
    document.getElementById('nombre').value = agente.nombre
    document.getElementById('apellido').value = agente.apellido
    resultados.removeAttribute('hidden')
}

function mostrarHistorial(id){
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

function excel(){
    $(document).ready(function() {
        $('#historial').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
}

function excel(type, fn, dl){
    let nombre = document.getElementById('apellido').value + '-' + document.getElementById('nombre').value
    var elt = document.getElementById('historial');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
      XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
      XLSX.writeFile(wb, fn || (nombre +'.' + (type || 'xlsx')));
}

