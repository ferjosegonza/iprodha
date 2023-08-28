function encabezados(){
    encabezado = document.getElementById('encabezado').value
    let tipo = document.getElementById('tipo')
    for(let i=1; i<tipo.options.length; i++){
        if(tipo.options[i].value != null){
           if(tipo.options[i].value[0] == encabezado){
                tipo.options[i].hidden = false
           }
           else{
                tipo.options[i].hidden = true
           }
        }
    }
}

function tipos(){ //Esta funcion maneja la selección de un tipo de archivo y sus subtipos
    if(document.getElementById('tipo').value == 'sel'){
        //Si no se selecciona un tipo se ocultan los subtipos y se pone un placeholder
        document.getElementById('subtipo').hidden = true
        document.getElementById('placeholder').hidden = false       
        document.getElementById('subtipo').value = "sel"
    }  
    else{   
        //Si se selecciona un tipo se filtran los subtipos correspondientes y se oculta el placeholder
        let tipo =  document.getElementById('tipo').value   
        let tipoId = getTipoId()
        let cabecera = tipo.slice(0,1)
        document.getElementById('subtipo').hidden = false
        document.getElementById('placeholder').hidden = true
        console.log(tipoId, cabecera)
        filtrarSubtipos(tipoId, cabecera)        
    }
}    

function filtrarSubtipos(tipoId, cabecera){ //filtra los subtipos según el id del tipo de archivo
    //los value de cada subtipo están conformados por el idtipo y el idsubtipo 
    //cumplen con la forma value = 17|25, siendo el primer valor el idtipo
    let subtipo = document.getElementById('subtipo')   
    subtipo.value = "sel"
    let bandera= 0; 
    let subtid
    for(let i=1; i<subtipo.options.length; i++){
        //Por cada subtipo que existe
        if(subtipo.options[i].value != null){
            //La bandera nos indica si ya terminamos de procesar el idtipo
            bandera=0;
            for(j=0; j<subtipo.options[i].value.length; j++){ //Por cada caracter del subtipo.value
                if (bandera==0){  //Si se sigue procesando el id                   
                    if(j==0){ //Si es el primer caracter (siempre numérico)    
                        subtid = subtipo.options[i].value[j].toString();
                    }
                    else{ //Si es el caracter != 0
                        if(isNaN(subtipo.options[i].value[j])){ //Si no es un numero, es decir |                        
                            bandera=1; //terminamos de procesar el id
                            if(subtid == tipoId) //si coincide con el idtipo se muestra
                            {
                                let bandCabecera = 0
                                let cabeceraSubt = ''
                                for(const element of subtipo.options[i].value){
                                    if(bandCabecera == 1){
                                        cabeceraSubt = cabeceraSubt + element.toString();
                                    }
                                    else{
                                        if(element == '_'){
                                            bandCabecera = 1
                                        }
                                    }
                                }
                                if(cabeceraSubt == cabecera){
                                    subtipo.options[i].hidden = false
                                }
                                else{
                                    subtipo.options[i].hidden = true
                                }                               
                            }
                            else{ //si no coincide se oculta
                                subtipo.options[i].hidden = true                                    
                            } 
                            subtid="" //reinciamos el idsubtipo para la siguiente iteración
                        }
                        else{ //Es un número, seguimos procesando el id
                            subtid = subtid + subtipo.options[i].value[j].toString();
                        }
                    }
                } 
                else{ //Si terminamos de procesar cerramos el bucle y vamos al siguiente.
                    j=subtipo.options[i].value.length
                }
            }
        }
    }        
}

function getTipoId(){
    let tipo =  document.getElementById('tipo').value
    let tid =  tipo.slice(2)
    return tid;
}

function getSubtipoId(){
    //Recumeramos el subtipoId del subtipo seleccionado
    //Es decir el segundo valor en subtipo.value = 17|25 
    let bandera=0
    let subtid = ''
    for(i=0; i<subtipo.value.length; i++){
        //Por cada caracter
        if (bandera==1){ //Una vez que encontramos el | podemos empezar a guardar el id
            if(subtipo.value[i]=='_'){
                bandera=2
            }
            else{
               subtid= subtid + subtipo.value[i] 
            }
            
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

function documento(){
    document.getElementById('documento').removeAttribute('hidden')
}

function mostrarCrear(){
    document.getElementById('crear').removeAttribute('hidden')
    document.getElementById('btncrear').removeAttribute('hidden')
    document.getElementById('lbl-guardar').removeAttribute('hidden')
    document.getElementById('btnmodificar').setAttribute('hidden','hidden')
    document.getElementById('lbl-modificar').setAttribute('hidden','hidden')
    document.getElementById('btnocultar').removeAttribute('hidden') 
    document.getElementById('btneliminar').setAttribute('hidden', 'hidden')
    document.getElementById('lbl-eliminar').setAttribute('hidden', 'hidden')
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
    encabezados()
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
            if(res.length>0){
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
                    tr.className= 'hoverable'
                    info.appendChild(tr)
                }
            }
            else{
                tr = document.createElement('tr')
                tr.innerHTML = '<td colspan="5">No se han encontrado registros.</td>'
                tr.className= 'hoverable'
                
                info.appendChild(tr)
            }
            
        },
        error: function(res){
            console.log(res)
        }});
}

function buscarArchivos(){
    let tipo= getTipoId()
    let subtipo = getSubtipoId().slice(0, -2)
    console.log(subtipo)
    let nro = document.getElementById('nro').value
    let cabecera = document.getElementById('encabezado').value
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
           nro: nro,
           cabecera:cabecera
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
                for(const element of res){
                    tr=document.createElement('tr')         
                    let claves
                    if(element.claves_archivo == null){
                        claves = '-'
                    }
                    else{
                        claves= element.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;')
                    }
                    tr.innerHTML = '<td>'+element.dia_archivo+'-'+ element.mes_archivo + '-' + element.ano_archivo +'</td><td>'+element.tipo + '-' + element.subtipo + '-' + element.nro_archivo + '</td><td>'+ claves+'</td>'
                    tr.setAttribute('onclick', 'openPreview("'+ element.id_archivo + '", "' + element.path_archivo.replaceAll('\\','\\\\') + ' ", "' + element.nombre_archivo + '", "' + element.tipo +  '", "' + element.subtipo + '", "' + element.nro_archivo +'")')
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
    let src= path.trim()+nombre.trim()
    src = src.slice(14)
    document.getElementById('pdfembed').setAttribute('src', src)
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
    document.getElementById('btnmodificar').removeAttribute('disabled')
    document.getElementById('btnocultar').removeAttribute('hidden')
    document.getElementById('lbl-modificar').removeAttribute('hidden')
    document.getElementById('btneliminar').removeAttribute('hidden')
    document.getElementById('lbl-eliminar').removeAttribute('hidden')
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
                while(info.hasChildNodes()){
                    info.removeChild(info.lastChild)
                }
                for(let i=0; i<res.length; i++){
                    tr = document.createElement('tr')
                    tr.innerHTML = '<td>' + res[i].tipo + '-' + res[i].subtipo + '-' + res[i].nro_archivo +'</td><td><button class="btn" onclick="deleteAsociado('+i+')"><i class="fas fa-trash-alt" style="color: #ff0000;"></i></button></td><td hidden>' + res[i].idarchivo + '</td>'
                    tr.className= 'hoverable' 
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
    document.getElementById('btnocultar').setAttribute('hidden', 'hidden')
    document.getElementById('fecha').value = null
    document.getElementById('detalle').value = ''
    document.getElementById('observacion').value = ''
    let table = document.getElementById('infoasociados')
    while(table.hasChildNodes()){
        table.removeChild(table.lastChild)
    }
    document.getElementById('docsasociados').setAttribute('hidden', 'hidden')
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
    document.getElementById('subtipo').setAttribute('hidden', 'hidden')
    document.getElementById('placeholder').removeAttribute('hidden')
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

    console.log(idagente)

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

function ask(tipo){
    let titulo = document.getElementById('modalTitulo')
    let body = document.getElementById('modalBody')
    let boton = document.getElementById('modalBoton')
    if(tipo == 'eliminar'){
        let modalEl = document.getElementById('modal')
        titulo.innerHTML = '¡Advertencia!'
        console.log(titulo)
        body.innerHTML = '<p>¿Está seguro que desea eliminar esta novedad? Se eliminarán todas las filas asociadas.</p>'
        boton.innerHTML = 'Borrar'
        boton.classList.remove('btn-primary')
        boton.classList.add('btn-danger')
        boton.removeAttribute('onclick')
        boton.setAttribute('onclick', 'eliminar()')
        let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
        modal.show()
    }
}

function eliminar(){
    let modalEl = document.getElementById('modal')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
        modal.hide()
    let idhistorial = document.getElementById('idhistorial').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + '/agente/borrarNovedad',
        type: 'DELETE',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            idhistorial: idhistorial,
          
        }),
        dataType: 'json',
        success: function(res) {          
           console.log(res)
           let popEl = document.getElementById('popup')
           document.getElementById('popTitulo').innerHTML = 'Éxito'
           document.getElementById('popBody').innerHTML = '<p>Se ha borrado correctamente.</p>'
           let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        },
        error: function(res){
            console.log(res)
            let popEl = document.getElementById('popup')
            document.getElementById('popTitulo').innerHTML = 'Error'
            document.getElementById('popBody').innerHTML = '<p>No se ha podido borrar.</p>'
            let pop= bootstrap.Modal.getOrCreateInstance(popEl)
            pop.show()
            cargarHistorial()
        }}); 
}