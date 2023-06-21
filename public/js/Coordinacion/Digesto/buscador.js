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
    //cumplen con la forma value = 17|25, siendo el primer valor el idtipo.
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
    console.log(tipo, subtipo, doc)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'buscar',
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
            document.getElementById('preview').removeAttribute('hidden')
            document.getElementById('nro').innerHTML = '<b>Número de documento: </b>' + res.nro_archivo
            document.getElementById('obs').innerHTML = '<b>Asuntos claves: </b>' + res.claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;') 
            document.getElementById('pdf').setAttribute('src', res.path_archivo + res.nombre_archivo)
            document.getElementById('id').value = res.id_archivo
        },
        error: function(res){
            console.log(res)
        }
    }); 
}


window.addEventListener("DOMContentLoaded", (event) => {
    const tipo = document.getElementById('tipo')
    const subtipo = document.getElementById('subtipo')
    const doc= document.getElementById('doc')
    const btn = document.getElementById('btn-buscar')

    const checkEnableButton = () => {    
        if(tipo.value!='sel' && subtipo.value!='sel' && doc.value!= ''){
            btn.removeAttribute('disabled');    
        }        
        else{
            btn.setAttribute('disabled', 'disabled');
        }   
    }

    doc.addEventListener('input', checkEnableButton)
    subtipo.addEventListener('change', checkEnableButton)
    tipo.addEventListener('change', checkEnableButton)
});