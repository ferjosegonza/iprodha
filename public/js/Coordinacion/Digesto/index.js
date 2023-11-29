let idoriginal
let idmodificador

function tipos(){ //Esta funcion maneja la selección de un tipo de archivo y sus subtipos
    if(document.getElementById('tipo').value == 'sel'){
        //Si no se selecciona un tipo se ocultan los subtipos y se pone un placeholder
        document.getElementById('subtipo').hidden = true
        document.getElementById('placeholder').hidden = false       
        document.getElementById('subtipo').value = "sel"
    }  
    else{   
        //Si se selecciona un tipo se filtran los subtipos correspondientes y se oculta el placeholder
        let tipoId =  document.getElementById('tipo').value   
        document.getElementById('subtipo').hidden = false
        document.getElementById('placeholder').hidden = true
        filtrarSubtipos(tipoId)        
    }
}    

function filtrarSubtipos(tipoId){ //filtra los subtipos según el id del tipo de archivo
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
                                subtipo.options[i].hidden = false
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

function getSubtipoId(subtipo){
    //Recumeramos el subtipoId del subtipo seleccionado
    //Es decir el segundo valor en subtipo.value = 17|25 
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

$(document).ready(function() {
    let tipo = document.getElementById('tipo').value
    filtrarSubtipos(tipo)
    $("#subtipo option:first").attr('selected','selected');
});

function buscarArchivo(estado){
    let tipo = document.getElementById('tipo').value
    let subtipo = getSubtipoId(document.getElementById('subtipo'))
    let doc = document.getElementById('doc').value
    let año = document.getElementById('año').value
    //
    let route = 'digesto/buscar'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo:tipo,
            subtipo:subtipo,
            doc:doc,
            año: año
        }),
        dataType: 'json',
        success: function(res){  
            idmodificador = res.id_archivo
            document.getElementById('archivo-on').removeAttribute('hidden')                        
            document.getElementById('claves-org').innerHTML = res.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') 
            document.getElementById('emb-org').setAttribute('src', res.path_archivo + res.nombre_archivo)
            document.getElementById('preview-org').removeAttribute('hidden')
            document.getElementById('buscador-modif').removeAttribute('hidden')
            document.getElementById('buscador-org').setAttribute('hidden', 'hidden') 
            document.getElementById('observaciones').innerHTML = ''
            document.getElementById('año').innerHTML = ''
            document.getElementById('año2').innerHTML = ''
            document.getElementById('areas').setAttribute('hidden', 'hidden')
            document.getElementById('areas2').setAttribute('hidden', 'hidden')
            actualizarTabla()        
            buscarRelacionados(res.id_archivo)      
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    }); 
}

function buscarRelacionados(id){
    console.log(id)
    let route = 'digesto/relacionados'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){  
            console.log(res)
            document.getElementById('archivos-relacionados').removeAttribute('hidden')
            let table = document.getElementById('table-relacionados')
            while(table.hasChildNodes()){
                table.removeChild(table.lastChild)
            }
            let head= document.createElement('thead')
            table.append(head)
            if(res.length>0){
                let tr = document.createElement('tr')
                let th1 = document.createElement('th')    
                th1.innerHTML = 'Nro de Archivo'
                tr.appendChild(th1)
                th1.className ='primero'
                let th2 = document.createElement('th')    
                th2.innerHTML = 'Observación'
                tr.appendChild(th2)
                th2.className ='segundo'
                let th3 = document.createElement('th')    
                th3.innerHTML = 'Nombre de Archivo'
                tr.appendChild(th3)             
                tr.className = 'row2'   
                th3.className ='tercero'
                head.appendChild(tr)
                let body=document.createElement('tbody')
                table.append(body)
                for(const element of res){
                    let tr = document.createElement('tr')
                    tr.className = 'row2'
                    let td1 = document.createElement('td')
                    let td2 = document.createElement('td')
                    let td3 = document.createElement('td')
                    td1.innerHTML = element.nro_archivo
                    td1.className = 'primero'
                    td2.innerHTML = element.observacion
                    td2.className = 'segundo'
                    td3.innerHTML = element.nombre_archivo
                    td3.className = 'tercero'
                    tr.appendChild(td1)
                    tr.appendChild(td2)
                    tr.appendChild(td3)
                    tr.setAttribute('onclick', 'modificarOpen(\''+element.observacion+'\',\'' + element.id_archivo0 + '\',\'' +  element.path_archivo.replaceAll('\\','\\\\')  + '\',\'' +  element.nombre_archivo + '\')')
                    body.append(tr)
                }
            }
            else{
                let tr = document.createElement('tr')
                tr.innerHTML = 'Aún no existen archivos que modifiquen a este documento'
                table.append(tr)
            }
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    }); 
}

function buscarArchivoModificador(){
    let tipo = document.getElementById('tipo2').value
    let subtipo = getSubtipoId(document.getElementById('subtipo2'))
    let doc = document.getElementById('doc2').value
    let año = document.getElementById('año2').value
    //
    let route = 'digesto/buscar'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo:tipo,
            subtipo:subtipo,
            doc:doc,
            año:año
        }),
        dataType: 'json',
        success: function(res){  
            idoriginal = res.id_archivo    
            console.log(res)                    
            document.getElementById('buscador-modif').setAttribute('hidden', 'hidden')  
            document.getElementById('preview-modificador').removeAttribute('hidden')
            document.getElementById('claves-modif').innerHTML = res.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') 
            document.getElementById('claves-modif').removeAttribute('hidden')
            document.getElementById('emb-modif').setAttribute('src', res.path_archivo + res.nombre_archivo)
            document.getElementById('btnguardar').removeAttribute('hidden')
            document.getElementById('btnmodificar').setAttribute('hidden', 'hidden')
            document.getElementById('areas').removeAttribute('hidden')
            document.getElementById('areas2').removeAttribute('hidden')
            document.getElementById('observaciones').innerHTML=' '
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    }); 
}

function modificarOpen(obs, id, path, nombre){
    idoriginal = id
    document.getElementById('buscador-modif').setAttribute('hidden', 'hidden')  
    document.getElementById('preview-modificador').removeAttribute('hidden')
    document.getElementById('claves-modif').setAttribute('hidden', 'hidden') 
    document.getElementById('emb-modif').setAttribute('src', path.slice(14) + nombre)
    document.getElementById('btnguardar').setAttribute('hidden', 'hidden')
    document.getElementById('btnmodificar').removeAttribute('hidden')
    document.getElementById('observaciones').innerHTML = obs
}

function modificar(){
    console.log(idoriginal, ', ', idmodificador)
    let obs = document.getElementById('observaciones').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'digesto/modificar',
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id0: idoriginal,
            idn: idmodificador,
            obs: obs
        }),
        dataType: 'json',
        success: function(res){  
            popup(1)
        },
        error: function(res){
            console.log(res)
            popup(-1)
        }
    }); 
}

function contadorchar(label, input, max){
    let lab = document.getElementById(label)
    let inp = document.getElementById(input)
    if (inp.value.length > max){
        lab.innerHTML = "No quedan caracteres"            
        inp.value = inp.value.slice(0, max)
        return false;    
    }    
    else{
        lab.innerHTML = "Quedan " + (max - inp.value.length) + " caracteres"
    }
}

function volveralbuscador(){
    document.getElementById('archivo-on').setAttribute('hidden', 'hidden')
    document.getElementById('preview-org').setAttribute('hidden', 'hidden')
    document.getElementById('preview-modificador').setAttribute('hidden', 'hidden')
    document.getElementById('buscador-modif').setAttribute('hidden', 'hidden')
    document.getElementById('buscador-org').removeAttribute('hidden')
    idoriginal = null
    idmodificador = null
    document.getElementById('doc').value = null
    document.getElementById('doc2').value = null
}

function guardar(){
    let obs = document.getElementById('observaciones').value
    //
    let route = 'digesto/guardar'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id0:idoriginal,
            idn:idmodificador,
            obs:obs
        }),
        dataType: 'json',
        success: function(res){              
            popup(1)
        },
        error: function(res){
            console.log(res)
            popup(-1)
        }
    }); 
}

function popup(estado){  
    let popEl = document.getElementById('popup')
    if(estado == 1){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha guardado el digesto.</p>'        
        document.getElementById('ok').setAttribute('onclick', "volveralbuscador()")     
    }
    else if(estado == -1){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido guardar el digesto.</p>'
        document.getElementById('ok').removeAttribute('onclick')
    }    
    else if(estado == -2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido encontrar el archivo.</p>' 
        document.getElementById('ok').removeAttribute('onclick')           
    }   
    else if(estado == 2){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>El documento ya no afecta al área retirada.</p>'  
        document.getElementById('ok').removeAttribute('onclick')          
    }  
    else if(estado == -3){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido retirar el área.</p>'      
        document.getElementById('ok').removeAttribute('onclick')      
    } 
    else if(estado == 3){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha agregado el área afectada al documento.</p>'  
        document.getElementById('ok').removeAttribute('onclick')          
    }  
    else if(estado == -4){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido agregar el área.</p>'      
        document.getElementById('ok').removeAttribute('onclick')      
    } 
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function remove_area(id_area, tr){
    //
    let route = 'digesto/sacarArea'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'DELETE',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id_archivo: idoriginal,
            id_area: id_area
        }),
        dataType: 'json',
        success: function(res){
            popup(2)
            actualizarTabla()
        },
        error: function(res){
            console.log(res)
            popup(-3)
        }
    }); 
}

function actualizarTabla(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'digesto/areas',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id: idoriginal
        }),
        dataType: 'json',
        success: function(res){  
            let table = document.getElementById('areas-afectadas')
            while(table.hasChildNodes()){
                table.removeChild(table.lastChild)
            }
            if (res.length>0){
                for(let i = 0; i<res.length; i++){
                    let tr = document.createElement('tr')
                    id='tr'+i
                    tr.id=id
                    tr.innerHTML = res[i].area + ' <button class="btn btn-danger btn-sm quitar" onclick="remove_area('+ res[i].idarea + ',' + id +')">-</button>'
                    table.append(tr)
                }
            }
            else{
                let tr = document.createElement('tr')
                tr.innerHTML = 'Aun no existen areas asignadas'
                table.append(tr)
            }                    
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    });       
}

function add_area(){
    let id_area= document.getElementById('area_select').value
    let route = 'digesto/añadirArea'
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id_archivo: idoriginal,
            id_area: id_area
        }),
        dataType: 'json',
        success: function(res){
            popup(3)
            actualizarTabla()
        },
        error: function(res){
            console.log(res)
            popup(-4)
        }
    }); 
}

function checkBtnAgregar(){
    let val = document.getElementById('area_select').value
    if(val !='sel'){
        document.getElementById('btn-agregar-area').removeAttribute('disabled')
    }
    else{
        document.getElementById('btn-agregar-area').setAttribute('disabled', 'disabled')
    }
}

window.addEventListener("DOMContentLoaded", (event) => {
    const tipo = document.getElementById('tipo')
    const subtipo = document.getElementById('subtipo')
    const doc= document.getElementById('doc')
    const tipo2 = document.getElementById('tipo2')
    const subtipo2 = document.getElementById('subtipo2')
    const doc2= document.getElementById('doc2')
    const btn = document.getElementById('btn-buscar')
    const btn2 = document.getElementById('btn-buscar2')

    const checkEnableButton = () => {    
        if(tipo.value!='sel' && subtipo.value!='sel' && doc.value!= ''){
            btn.removeAttribute('disabled');    
        }        
        else{
            btn.setAttribute('disabled', 'disabled');
        }   
    }

    const checkEnableButton2 = () => {    
        if(tipo2.value!='sel' && subtipo2.value!='sel' && doc2.value!= ''){
            btn2.removeAttribute('disabled');    
        }        
        else{
            btn2.setAttribute('disabled', 'disabled');
        }   
    }

    doc.addEventListener('input', checkEnableButton)
    subtipo.addEventListener('change', checkEnableButton)
    tipo.addEventListener('change', checkEnableButton)
    doc2.addEventListener('input', checkEnableButton2)
    subtipo2.addEventListener('change', checkEnableButton2)
    tipo2.addEventListener('change', checkEnableButton2)
});