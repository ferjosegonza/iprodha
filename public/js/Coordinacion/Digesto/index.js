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

function buscarArchivo(){
    let tipo = document.getElementById('tipo').value
    let subtipo = getSubtipoId(document.getElementById('subtipo'))
    let doc = document.getElementById('doc').value
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
            doc:doc
        }),
        dataType: 'json',
        success: function(res){  
            document.getElementById('archivo-on').removeAttribute('hidden')
            console.log(res)
            card = document.getElementById('info-original')
            console.log(res.claves_archivo)
            card.innerHTML = res.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') + '<br> <embed src="' + res.path_archivo + res.nombre_archivo +'" width="100%" height="600">'
            document.getElementById('buscador-org').setAttribute('hidden', 'hidden')
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function buscarArchivoModificador(){
    let tipo = document.getElementById('tipo2').value
    let subtipo = getSubtipoId(document.getElementById('subtipo2'))
    let doc = document.getElementById('doc2').value
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
            doc:doc
        }),
        dataType: 'json',
        success: function(res){      
            console.log(res)        
            document.getElementById('buscador-modif').setAttribute('hidden', 'hidden')            
            card = document.getElementById('archivo-on')
            let instanciar = document.createElement('div')
            instanciar.innerHTML = '<div class="col-lg-12"><div class="card-head"><h5>Modificador</h5></div><div class="card-body">'+ res.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') + '<br> <embed src="' + res.path_archivo + res.nombre_archivo +'" width="100%" height="450">' 
            instanciar.innerHTML = instanciar.innerHTML + '</div></div><div class="col-lg-12"><h6>Cargar Observaciones</h6><textarea id="observaciones" onkeyup="contadorchar(\'lab-obs\',\'observaciones\',500)"></textarea><label for="observaciones" id="lab-obs">Quedan 500 caracteres</label><button type="button" class="btn btn-success btn-block" onclick="guardar">Guardar Relación</button></div>'
            instanciar.className= 'col-lg-8 card'
            instanciar.id = 'preview-modificador'
            card.appendChild(instanciar)
        },
        error: function(res){
            console.log(res)
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

function guardar(){
    
}