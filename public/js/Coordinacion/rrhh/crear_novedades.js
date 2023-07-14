function tipos(){
    if(document.getElementById('tipo').value == 'sel'){
        document.getElementById('subtipo').hidden = true;
        document.getElementById('placeholder').hidden = false;        
        document.getElementById('subtipo').value = "sel"
    }  
    else{
        let tipo = document.getElementById('tipo').value;
        let tipoId = document.getElementById('tipo').value[0];     
        document.getElementById('subtipo').value = "sel"
        let tipoNombre;
        let bandera= 0;       
        console.log(tipo)
        for(i = 1; i < tipo.length; i++){ 
            if (bandera==0)
            {
                if(isNaN(document.getElementById('tipo').value[i]))
                {                    
                    if(document.getElementById('tipo').value[i] != '|')
                    {
                        tipoNombre = document.getElementById('tipo').value[i];
                        bandera =1;
                    }      
                }
                else{
                    tipoId = tipoId + document.getElementById('tipo').value[i].toString(); 
                }
            }
            else{
                tipoNombre = tipoNombre + document.getElementById('tipo').value[i];}  
            }
              
        
        console.log(tipoId);
        console.log(tipoNombre);
        
        let subtipo = document.getElementById('subtipo')
        let subtid
        console.log(subtipo.options.length)
        if (subtipo.options.length != 0){
            document.getElementById('subtipo').removeAttribute("hidden");
            document.getElementById('placeholder').hidden = true;
            for(i=1; i<subtipo.options.length; i++){
                if(subtipo.options[i].value != null){                    
                    bandera=0;
                    for(j=0; j<subtipo.options[i].value.length; j++){           
                        if (bandera==0){
                            if(j==0){               
                                subtid = subtipo.options[i].value[j].toString();
                            }
                            else{
                                if(isNaN(subtipo.options[i].value[j])){
                                    bandera=1;
                                    if(subtid == tipoId)
                                    {
                                        subtipo.options[i].hidden = false
                                    }
                                    else{
                                        subtipo.options[i].hidden = true                                    
                                    }
                                    subtid=""
                                }
                                else{
                                    subtid = subtid + subtipo.options[i].value[j].toString();
                                }
                            }
                        }
                        else{
                            j=subtipo.options[i].value.length
                        }
                    }
                }
            }
        }
        else{
            document.getElementById('subtipo').hidden = true;
            document.getElementById('placeholder').removeAttribute("hidden");
        }    
    }
}    

function subtipos(){
    if(document.getElementById('subtipo').value == 'sel'){
    }
    else{
    var subtipo = document.getElementById('subtipo').value; 
    var subtipoNombre;
    var bandera= 0; 
    var bandera2 = 0;      
    for(i = 0; i < subtipo.length; i++){ 
        if (bandera==0)
        {
            if(isNaN(document.getElementById('subtipo').value[i]))
            {               
                if(document.getElementById('subtipo').value[i] != '|')
                {subtipoNombre = document.getElementById('subtipo').value[i];  bandera =1; }
                else{
                    if(bandera2==0)
                    {
                        bandera2=1;
                    }
                    else{
                        i=subtipo.length;
                    }
                }
                
               
            }
        }
        else{
            if(document.getElementById('subtipo').value[i] != '|')
                {subtipoNombre = subtipoNombre + document.getElementById('subtipo').value[i];  }
                else{
                    if(bandera2==0)
                    {
                        bandera2=1;
                    }
                    else{
                        i=subtipo.length;
                    }
                }}  
        }
    var table = $('#archivos').DataTable()
    }
}

function documento(){
    document.getElementById('documento').removeAttribute('hidden')
}

function mostrarCrear(){
    document.getElementById('crear').removeAttribute('hidden')
    document.getElementById('btncrear').removeAttribute('hidden')
    document.getElementById('lbl-guardar').removeAttribute('hidden')
    document.getElementById('btnmodificar').setAttribute('hidden','hidden')
    document.getElementById('lbl-modificar').setAttribute('hidden','hidden')
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
            infoEmpty: '',
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

    $('#archivos').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        "bSort":false,
        language: {
            lengthMenu: 'Mostrando _MENU_ registros',
            zeroRecords: 'No se han encontrado registros',
            info: 'Pág _PAGE_ de _PAGES_',
            infoEmpty: '',
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

    cargarHistorial()
});

function cargarHistorial(){
    let id=document.getElementById('id').innerHTML
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
                tr.innerHTML = '<td>'+res[i].fecha.slice(0, 10)+'</td>'+'<td>'+res[i].detalle+'</td>'+'<td>'+str2+'</td>'+'<td>'+str+'</td><td><button class="btn" onclick="abrirEditar(\'' + res[i].idhistorial + '\',\'' + res[i].fecha + '\',\'' + res[i].detalle + '\',\''+ res[i].observacion +'\' )"><i class="fas fa-edit" style="color: #ff5900;"></i></button></td>'
                info.appendChild(tr)
            }
        },
        error: function(res){
            console.log(res)
        }});
}

function buscarArchivos(){
    let tipo= document.getElementById('tipo').value
    let subtipo = getSubtipoId()
    let nro = document.getElementById('nro').value
    console.log(tipo)
    console.log(subtipo)
    console.log(nro)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/archivo/rrhh',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
           tipo: tipo,
           subtipo: subtipo,
           nro: nro
        }),
        dataType: 'json',
        success: function(res) {          
            console.log(res)            
            if(res.length > 0){
                document.getElementById('elegirArchivo').removeAttribute('hidden')
                let info = document.getElementById('infoarchivos')
                while(info.hasChildNodes()){
                    info.removeChild(info.lastChild)
                }
                for(let i=0; i<res.length; i++){
                    tr=document.createElement('tr')                    
                    tr.innerHTML = '<td>'+res[i].tipo + '-' + res[i].subtipo + '-' + res[i].nro_archivo + '</td><td>'+res[i].claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;')+'</td>'
                    tr.setAttribute('onclick', 'openPreview("'+ res[i].id_archivo + '", "' + res[i].path_archivo.replaceAll('\\','\\\\') + ' ", "' + res[i].nombre_archivo + '", "' + res[i].tipo +  '", "' + res[i].subtipo + '", "' + res[i].nro_archivo +'")')
                    tr.className= 'hoverable'
                    info.appendChild(tr)
                }
            }
            else{
                alert('No se encontraron archivos')
            }
        },
        error: function(res){
            console.log(res)
        }});

}

function getSubtipoId(){
    //Recumeramos el subtipoId del subtipo seleccionado
    //Es decir el segundo valor en subtipo.value = 17|25 
    let subtipo = document.getElementById('subtipo')
    let bandera=0
    let subtid = ''
    for(i=0; i<subtipo.value.length; i++){
        //Por cada caracter
        if (bandera==1){ //Una vez que encontramos el | podemos empezar a guardar el id
            subtid= subtid + subtipo.value[i]
        }
        else{
            if(subtipo.value[i]=='|')
            {
                bandera=1 //Encontramos el |
            }
        }
    }
    return subtid;
}

function openPreview(id, path, nombre, tipo, subtipo, nro){
    console.log(path)
    console.log(nombre)
    document.getElementById('elegirArchivo').classList.remove('col-lg-12')
    document.getElementById('elegirArchivo').classList.add('col-lg-6')
    document.getElementById('pdfembed').setAttribute('src', path.slice(14)+nombre)
    let str = tipo + '-' + subtipo + '-' + nro
    document.getElementById('title-preview').innerHTML = str
    document.getElementById('previewpdf').removeAttribute('hidden')
    document.getElementById('btn-preview').setAttribute('onclick', 'guardarAvalatorio("' + id + '", "' + str +'")')
}

function guardarAvalatorio(id, nombre){
    document.getElementById('docsasociados').removeAttribute('hidden')
    let table = document.getElementById('infoasociados')
    let tr = document.createElement('tr')
    tr.className= 'hoverable'
    i= table.children.length
    tr.innerHTML = '<td>' + nombre +'</td><td><button class="btn" onclick="deleteAsociado('+i+')"><i class="fas fa-trash-alt" style="color: #ff0000;"></i></button></td><td hidden>' + id +'</td>'
    table.appendChild(tr)
    ocultarDocumentos()
}

window.addEventListener("DOMContentLoaded", (event) => {
    let fecha = document.getElementById('fecha')
    let detalle = document.getElementById('detalle')
    let btnGuardar = document.getElementById('btnguardar')
    let btnModificar = document.getElementById('btnmodificar')

    const verificarGuardar = () => {
        if(detalle.value != '' && fecha.value != ''){
            btnGuardar.removeAttribute('disabled')
        }
        else{
            btnGuardar.setAttribute('disabled','disabled')
        }
    }    

    const verificarModificar = () => {
        if(detalle.value != '' && fecha.value != ''){
            btnModificar.removeAttribute('disabled')
        }
        else{
            btnModificar.setAttribute('disabled','disabled')
        }
    }

    detalle.addEventListener('input', verificarGuardar)
    fecha.addEventListener('change', verificarGuardar)
    detalle.addEventListener('input', verificarModificar)
    fecha.addEventListener('change', verificarModificar)
});

function guardar(){
    let fecha = document.getElementById('fecha').value
    let detalle = document.getElementById('detalle').value
    let observacion = document.getElementById('observacion').value
    let id = document.getElementById('id').innerHTML
    let avalatorios = []
    let table = document.getElementById('docsasociados')
    for (let i = 1, row; row = table.rows[i]; i++) {
        avalatorios[i-1]= row.children.item(2).innerHTML
    }


   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/agente/guardarNovedad',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            fecha: fecha,
            detalle: detalle,
            observacion: observacion,
            id: id,
            avalatorios: avalatorios
          
        }),
        dataType: 'json',
        success: function(res) {          
           console.log(res)
           let popEl = document.getElementById('popup')
           document.getElementById('popTitulo').innerHTML = 'Éxito'
           document.getElementById('popBody').innerHTML = '<p>Se ha guardado correctamente.</p>'
           let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        },
        error: function(res){
            console.log(res)
            let popEl = document.getElementById('popup')
            document.getElementById('popTitulo').innerHTML = 'Error'
            document.getElementById('popBody').innerHTML = '<p>No se ha podido guardar.</p>'
            let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        }}); 
}

function abrirEditar(id, fecha, detalle, observacion){
    document.getElementById('idhistorial').innerHTML=id;
    document.getElementById('btncrear').setAttribute('hidden','hidden')
    document.getElementById('crear').removeAttribute('hidden')
    document.getElementById('btnguardar').setAttribute('hidden','hidden')
    document.getElementById('lbl-guardar').setAttribute('hidden','hidden')
    document.getElementById('btnmodificar').removeAttribute('hidden')
    document.getElementById('lbl-modificar').removeAttribute('hidden')
    document.getElementById('fecha').value = fecha.slice(0, 10)
    if(detalle!= 'null'){
       document.getElementById('detalle').value = detalle 
    }
    else{
        document.getElementById('detalle').value = ''
    }
    if(observacion != 'null'){
        document.getElementById('observacion').value = observacion
    }
    else{
        document.getElementById('observacion').value = ''
    }
    document.getElementById('btnguardar').removeAttribute('disabled')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/novedad/avalatorios',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id: id          
        }),
        dataType: 'json',
        success: function(res) {   
            console.log(res)     
            if(res.length>0){
                document.getElementById('docsasociados').removeAttribute('hidden')
                let info = document.getElementById('infoasociados')
                for(let i=0; i<res.length; i++){
                    tr = document.createElement('tr')
                    tr.innerHTML = '<td>' + res[i].tipo + '-' + res[i].subtipo + '-' + res[i].nro_archivo +'</td><td><button class="btn" onclick="deleteAsociado('+i+')"><i class="fas fa-trash-alt" style="color: #ff0000;"></i></button></td><td hidden>' + res[i].idarchivo + '</td>'
                    info.appendChild(tr)
                }
            }
        },
        error: function(res){
            console.log(res)
        }}); 

    
}

function ocultarCrear(){
    document.getElementById('btncrear').removeAttribute('hidden')
    document.getElementById('fecha').value = null
    document.getElementById('detalle').value = ''
    document.getElementById('observacion').value = ''
    let table = document.getElementById('infoasociados')
    while(table.hasChildNodes()){
        table.removeChild(table.lastChild)
    }
    ocultarDocumentos()
    document.getElementById('crear').setAttribute('hidden', 'hidden')
}

function ocultarDocumentos(){
    document.getElementById('subtipo').value = 'sel'
    document.getElementById('tipo').value = 'sel'
    document.getElementById('nro').value = ''
    let table2= document.getElementById('infoarchivos')
    while(table2.hasChildNodes()){
        table2.removeChild(table2.lastChild)
    }
    document.getElementById('elegirArchivo').classList.remove('col-lg-6')
    document.getElementById('elegirArchivo').classList.add('col-lg-12')
    document.getElementById('previewpdf').setAttribute('hidden','hidden')
    document.getElementById('elegirArchivo').setAttribute('hidden','hidden')    
    document.getElementById('documento').setAttribute('hidden', 'hidden')
}

function deleteAsociado(i){
    let table = document.getElementById('infoasociados')
    table.removeChild(table.children[i])
}

function modificar(){  
    let idhistorial = document.getElementById('idhistorial').innerHTML
    let fecha = document.getElementById('fecha').value
    let detalle = document.getElementById('detalle').value
    let observacion = document.getElementById('observacion').value
    let idagente = document.getElementById('id').innerHTML
    let avalatorios = []
    let table = document.getElementById('docsasociados')
    for (let i = 1, row; row = table.rows[i]; i++) {
        avalatorios[i-1]= row.children.item(2).innerHTML
    }


   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/agente/modificarNovedad',
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            fecha: fecha,
            detalle: detalle,
            observacion: observacion,
            idagente: idagente,
            idhistorial: idhistorial,
            avalatorios: avalatorios
          
        }),
        dataType: 'json',
        success: function(res) {          
           console.log(res)
           let popEl = document.getElementById('popup')
           document.getElementById('popTitulo').innerHTML = 'Éxito'
           document.getElementById('popBody').innerHTML = '<p>Se ha modificado correctamente.</p>'
           let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        },
        error: function(res){
            console.log(res)
            let popEl = document.getElementById('popup')
            document.getElementById('popTitulo').innerHTML = 'Error'
            document.getElementById('popBody').innerHTML = '<p>No se ha podido modificar.</p>'
            let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        }}); 
}