class elemento{crearin
    constructor(tag){
        this.tag = tag;
        this.cont = 0;
    }
}

class complejo{
    constructor(tag1, tag2){
        this.tag1 = tag1;
        this.tag2 = tag2;
        this.cont = 0;
    }
}

var elementos = []
var complejos = []

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

function getSubtipoId(){
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

function modal(tipo){
    let modalEl = document.getElementById('modal')
    console.log(modalEl)
    if(tipo == 1){
        document.getElementById('modalTitulo').innerHTML = 'Guardar Archivo'
        document.getElementById('modalBody').innerHTML = '<p>¿Está seguro de que desea guardar el archivo</p> <p>No olvide revisar los campos.</p>'
        document.getElementById('btnConfirmarAccion').innerHTML = 'Guardar archivo'      
        document.getElementById('btnConfirmarAccion').setAttribute('onclick', 'confirmarAccion(1)')  
    }
    else if(tipo ==2){
        document.getElementById('modalTitulo').innerHTML = 'Modificar Archivo'
        document.getElementById('modalBody').innerHTML = '<p>¿Está seguro de que desea modificar el archivo</p> <p>No olvide revisar los campos.</p>'
        document.getElementById('btnConfirmarAccion').innerHTML = 'Modificar archivo'      
        document.getElementById('btnConfirmarAccion').setAttribute('onclick', 'confirmarAccion(2)')  
    }
    else{
        document.getElementById('modalTitulo').innerHTML = 'Borrar Archivo'
        document.getElementById('modalBody').innerHTML = '<p>¿Está seguro de que desea borrar el archivo</p> <p>Esta acción no podrá deshacerse.</p>'
        document.getElementById('btnConfirmarAccion').innerHTML = 'Borrar archivo'      
        document.getElementById('btnConfirmarAccion').setAttribute('onclick', 'confirmarAccion(3)')  
    }
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show()

}

function confirmarAccion(tipo){        
    let modal= document.getElementById('modal')
    if(tipo == 1){        
        bootstrap.Modal.getInstance(modal).hide()
        guardar()
        document.getElementById('guardar').checked = false
    }
    else if(tipo == 2){       
        bootstrap.Modal.getInstance(modal).hide()
        modificar()
        document.getElementById('modificar').checked = false
    }
    else{
        bootstrap.Modal.getInstance(modal).hide() 
        borrar()
        document.getElementById('borrar').checked = false
    }
}

function existeCheck(){
    //Al presionar algún botón de guardar/modificar/borrar verificamos si existe un archivo 
    //que coincida con los parámetros mencionados.
    //PARÁMETROS
    ocultarPagina()
    let tipoId = document.getElementById('tipo').value
    let fecha = document.getElementById('fecha').value
    let doc = document.getElementById('doc').value
    let subtid = getSubtipoId()

    console.log(tipoId, fecha, doc, subtid)

    //CONSULTA AJAX
    let route = '/archivo/check';
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
            tipo: tipoId,
            subtipo: subtid,
            fecha: fecha,
            doc: doc
        }),
        dataType: 'json',
        success: function(res) 
        {     
            console.log(res)
            //La operación es válida
            if(res != 'null' && !(document.getElementById('guardar').checked) //se quiere modificar o borrar algo que existe
            || res == 'null' && (document.getElementById('guardar').checked)){ //se quiere guardar y todavia no existe
                mostrarPagina(res);  
            }
            else{
                document.getElementById('sectags').hidden=true;
                if(document.getElementById('guardar').checked){
                    alert("ERROR: Ya existe el archivo");
                    document.getElementById('guardar').checked=false;
                }
                else{
                    alert("ERROR: No se encontró el archivo")
                    document.getElementById('modificar').checked=false;
                    document.getElementById('borrar').checked=false;
                }                
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });

}

function checkArchivos(){
    ocultarPagina()
    let padre = document.getElementById('padre')
    let archivos
    if(document.getElementById('archivos') == undefined){
        archivos = document.createElement('aside')
        archivos.classList.add('col-lg-3')
        archivos.classList.add('card')
        archivos.id = 'archivos'
    }
    else{
        archivos = document.getElementById('archivos')
        while(archivos.hasChildNodes()){
            archivos.removeChild(archivos.lastChild)
        }
    }
    let taggeo = document.getElementById('taggeo')
    taggeo.classList.remove('col-lg-12')
    taggeo.classList.add('col-lg-8')
    padre.appendChild(archivos)
    //
    let tipo=document.getElementById('tipo').value
    let sub = getSubtipoId()
    let fecha = document.getElementById('fecha').value
    let doc = document.getElementById('doc').value
    //
    let route = '/archivo/getArchivos';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        async: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo: tipo,
            subtipo: sub,
            fecha: fecha,
            doc: doc
        }),
        dataType: 'json',
        success: function(res){
            console.log(res)
            let titulo = document.createElement('h5')
            titulo.innerHTML = 'Archivos:'
            let cardhead = document.createElement('div')
            cardhead.className = 'card-head'
            cardhead.appendChild(titulo)
            archivos.appendChild(cardhead)
            let cardbody = document.createElement('div')
            cardbody.className = 'card-body'
            archivos.appendChild(cardbody)  
            console.log(res.length)          
            if(res.length == 0){
                let p = document.createElement('p')
                p.innerHTML = 'No se han encontrado archivos que coincidan con los parámetros'
                cardbody.appendChild(p)
            }
            else{
                let table = document.createElement('table')
                table.id = 'archivotabla'
                let tablebody = document.createElement('tbody')
                cardbody.appendChild(table)
                table.appendChild(tablebody)
                for(let i = 0; i < res.length; i++){
                    let tr = document.createElement('tr')
                    let j = i+1
                    tr.setAttribute('onclick', 'archivoSelected(' + i + ')')
                    let td1 = document.createElement('td')
                    td1.innerHTML = j
                    tr.appendChild(td1)
                    let td2 = document.createElement('td')
                    td2.innerHTML = res[i].nombre_archivo                
                    tr.appendChild(td2)        
                    /* let td3 = document.createElement('td')
                    td3.innerHTML = res[i]         
                    td3.hidden = true
                    tr.appendChild(td3)    */     
                    tr.onclick = function (){
                        document.getElementById('archivos').remove()
                        let taggeo = document.getElementById('taggeo')
                        taggeo.classList.remove('col-lg-8')
                        taggeo.classList.add('col-lg-12')
                        mostrarPagina(res[i])
                    }
                    tablebody.appendChild(tr)
                }  
            }
                        
        },
        error: function(res){console.log(res)}});
}

function contadorSimple(nombre){
    //console.log(nombre)
    let contador=0;
    let band=0;
    elementos.forEach(elemento => {
        if(elemento.tag==nombre){
            band=1;
            elemento.cont+=1;
            contador = elemento.cont;
        }
    });
    if(band == 0){
        let el = new elemento(nombre);
        elementos.push(el);
    }
    //console.log(contador)
    return contador;
}

function contadorComplejo(tag1, tag2){
    let cont=0;
    let band=0;
    complejos.forEach(complejo => {
        if(complejo.tag1 == tag1 && complejo.tag2 == tag2){
            band=1;
            complejo.cont+= 1 
            cont = complejo.cont;
        }
    });
    if(band == 0){
        let co = new complejo(tag1, tag2);
        complejos.push(co);        
    }
    return [cont];
}

function crearInputSimple(padre, dato, nombre, medida, i, contador){  
    let divmenor = document.createElement("div")           
    if(medida==1){ //La medida 1 la tienen solo los no-complejos
        divmenor.className = "col-lg-3 col-md-4"     
    }                             
    if(medida==2){
        divmenor.className = "col-lg-6"
    }                     
    let lab = document.createElement("label")        
    if(medida==1){
        lab.id= "label-i-"+i
    }
    else{
        lab.id= "label-o-"+i
    }
    lab.innerHTML=nombre    
    divmenor.appendChild(lab);
    //
    let input = document.createElement("input");
    if(dato == 1){//Si el dato es numérico                                     
      input.type = "number";
      input.className="no-spin"      
      
    }
    else{//Si el tipo de dato es texto
        input.type = "text";
    }                                        
    input.className = 'form-control'; //Formato
    if(medida==1){
        input.name = 'input' + i;
        input.id = 'input' + i;
    }
    else{
        input.name = 'hijo' + i;
        input.id = 'hijo' + i;
    }    
    input.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            guardarTag(i, nombre, 1, contador, medida);
        }    
    });

    if(document.getElementById('borrar').checked){
        input.setAttribute('disabled', 'disabled')
    }

    divmenor.appendChild(input);
    padre.appendChild(divmenor);
    return input.id;
}

function crearSelect(padre, id, nombre, medida, i, contador){ 
    let divmenor = document.createElement("div")      
    if(medida==1){ //Esta medida solo la tienen los no-complejos
        divmenor.className = "col-lg-3 col-md-4"
    }                              
    if(medida ==2){
        divmenor.className = "col-lg-12"
    }
    let lab = document.createElement("label")           
    lab.innerHTML=nombre
    if(medida==1){
        lab.id= "label-i-"+i
    }
    else{
        lab.id= "label-o-"+i
    }
    divmenor.appendChild(lab);     
    let input = document.createElement("select");
    getSelects(input, id)
    input.className="form-select"   
    if(medida==1){
        input.name = 'input' + i;
        input.id = 'input' + i;
    }
    else{
        input.name = 'hijo' + i;
        input.id = 'hijo' + i;
    }   
    input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida +  ')')
    
    if(document.getElementById('borrar').checked){
        input.setAttribute('disabled', 'disabled')
    }
   
    divmenor.appendChild(input);
    padre.appendChild(divmenor);
    return input.id;
}

function crearSemiSelect(padre, dato, id, nombre, medida, i, contador){   
    let divmenor = document.createElement("div")           
    if(medida==1){ //La medida 1 la tienen solo los no-complejos
        divmenor.className = "col-lg-3 col-md-4"     
    }                             
    if(medida==2){
        divmenor.className = "col-lg-6"
    }                               
    let lab = document.createElement("label")           
    lab.innerHTML=nombre
    if(medida==1){
        lab.id= "label-i-"+i
    }
    else{
        lab.id= "label-o-"+i
    }
    divmenor.appendChild(lab);
    //
    let input = document.createElement("input");
    if(dato == 1){//Si el dato es numérico                                     
      input.type = "number";
      input.className="no-spin"
    }
    else{//Si el tipo de dato es texto
        input.type = "text";
    }                                  
    input.className = 'form-control'; //
    if(medida==1){
        input.name = 'input' + i;
        input.id = 'input' + i;
    }
    else{
        input.name = 'hijo' + i;
        input.id = 'hijo' + i;
    }
    input.setAttribute('list', "opciones"+i);
    input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          findTexto(input.value, id, input, "opciones"+i);
          guardarTag(i , nombre , 1, contador, medida)
        }
    });   
    //input.setAttribute('onchange', 'guardarTag(\''+ input.id + '\',\'' + nombre + '\')')
    input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida + ')')
    
    if(medida != 1){
        input.setAttribute('onchange', 'derivado('+ i + ',' + id + ')');
    }      

    if(document.getElementById('borrar').checked){
        input.setAttribute('disabled', 'disabled')
    }


    divmenor.appendChild(input);
    padre.appendChild(divmenor)
    return input.id;
}

function derivado(id, idtag){
    let valor = document.getElementById('hijo'+id).value;   
    let number = id + 1
    let id2= 'hijo' + number;
    let hijo = document.getElementById(id2)

    let route = '/archivo/derivados';    

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
            id: idtag,
            value: valor
        }),
        dataType: 'json',
        success: function(res) {
            hijo.value=res[0].dato
            let lab = "label-o-" + number
            let tagname = document.getElementById(lab).innerHTML  
            let contador=0;
            complejos.forEach(complejo => {
                if(complejo.tag2==tagname){
                    contador = complejo.cont;
                }
            });      
            guardarTag(number, tagname, 1, contador, 4)
            let labpadre = document.getElementById("label-o-" + id).innerHTML
            guardarTag(id, labpadre, 1, contador, 2)
        },
        error: function(res){
            console.log(res)
        }});

}

function cargarPDF(path, nombre){
    let ruta = path + nombre
    document.getElementById('linkpdf').setAttribute('href', ruta)
    document.getElementById('pdfverpdf').setAttribute('data', ruta)    
}

function cargarClaves(claves_archivo){
    let tags=[];
    let info=[];
    let cont=0;
    let band=0;
    if(claves_archivo != null){
        for(i=0; i<claves_archivo.length; i++){    
        //obtenemos los tags ya cargados
        //i es cada caracter                                                
        if(band==2){
            if(claves_archivo[i] == '>'){
                band=0;
            }   
            else{
                info[cont]=info[cont] + claves_archivo[i]
            }
        }if(band==1){
            if(claves_archivo[i] == ':'){
                band=2;
                info[cont]=''
            }   
            else{
                tags[cont]=tags[cont] + claves_archivo[i]
            }          
        }
        if(claves_archivo[i] == '<'){
            band=1; 
            cont+=1;
            tags[cont]=''
        }                        
    }
     //le damos formato de tag:
     for(i=1; i<tags.length; i++){
        claves.value = claves.value + '<'+tags[i]+':'+info[i]+'>';
    }
    }
    
}

function recuperarTags(tipo, sub){    
    //recuperamos los tags a mostrar segun tipo de documento
    let route = '/archivo/tags';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        async: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo: tipo,
            subtipo: sub
        }),
        dataType: 'json',
        success: function(res){
            cargarTagsSimples(res)        
        },
        error: function(res){console.log(res)}});
}

function recuperarTagsComplejos(concat, tagcomplejoOb, tagcomplejoRe, tagcomplejoOp){
    //console.log(concat, tagcomplejoOb, tagcomplejoRe, tagcomplejoOp)
    let route = '/archivo/complejos';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        async: false,
        data: ({
            _token: $('#signup-token').val(),
            tags: concat
        }),
        dataType: 'json',
        success: function(res){cargarTagsComplejos(res, tagcomplejoOb, tagcomplejoRe, tagcomplejoOp)},
        error: function(res){console.log(res)}});
}

function cargarTagsSimples(tags){
//CARGAMOS LOS TAGS DEL ARCHIVO
    //Variables donde guardar los tags complejos que tendremos que consultar despues
    let tagcomplejoOb=[]    //Obligatorio
    let tagcomplejoRe=[]    //Recomendado
    let tagcomplejoOp=[]    //Opcional
    //Bandera para comprobar que existen tags en cada categoría
    //Indices para el array de complejos                        
    let contOb=0;   //Obligatorio
    let contRe=0;   //Recomendado
    let contOp=0;   //Opcional
    //Acumuladores que nos indican cuándo pasar a la fila siguiente 
    //para permitir que la web sea responsive
    let rowOb=0;
    let rowRe=0;
    let rowOp=0;       
    //
    let containerOb = document.getElementById('comp-obligatorio') //aca van los tags obligatorios
    let containerRe =  document.getElementById('comp-recomendado') //aca van los tags recomendados
    let containerOp =  document.getElementById('comp-opcional') //aca van los tags opcionales
    //
    console.log(containerOb, containerRe, containerOp) 
    //
    for(let i=0; i<tags.length; i++){
        if(tags[i].estructura == 1){
            if(tags[i].id_tipo == 1){
                if(rowOb==0){ //Si es la primera fila/Si se reincició
                    //creamos divmayor con clase row
                    var divmayorOb=document.createElement("div")                                        
                    divmayorOb.className = "row"
                    containerOb.appendChild(divmayorOb)
                }   
                insertarInputSimple(divmayorOb, tags[i], i)
                rowOb+=3
                if(rowOb == 12){rowOb = 0}
            }
            else if(tags[i].id_tipo == 2){
                if(rowRe==0){ //Si es la primera fila/Si se reincició
                    //creamos divmayor con clase row
                    var divmayorRe=document.createElement("div");                                        
                    divmayorRe.className = "row";
                    containerRe.appendChild(divmayorRe)
                }  
                insertarInputSimple(divmayorRe, tags[i], i)
                rowRe+=3
                if(rowRe == 12){rowRe = 0}
            }
            else if(tags[i].id_tipo == 3){
                if(rowOp==0){ //Si es la primera fila/Si se reincició
                    //creamos divmayor con clase row
                    var divmayorOp=document.createElement("div");                                        
                    divmayorOp.className = "row";
                    containerOp.appendChild(divmayorOp)
                }   
                insertarInputSimple(divmayorOp, tags[i], i)
                rowOp+=3
                if(rowOp == 12){rowOp = 0}
            }
        }
        else{
            if(tags[i].id_tipo == 1){
                tagcomplejoOb[contOb] = tags[i].id_tag
                contOb+=1
            }
            else if(tags[i].id_tipo == 2){
                tagcomplejoRe[contRe] = tags[i].id_tag
                contRe+=1
            }
            else if(tags[i].id_tipo == 3){
                tagcomplejoOp[contOp] = tags[i].id_tag
                contOp+=1
            }
        }        
    }

    //AHORA DEBEMOS RECUPERAR LOS TAGS COMPLEJOS            
    let concat = tagcomplejoOb.concat(tagcomplejoRe,tagcomplejoOp)
    //console.log(concat)
    recuperarTagsComplejos(concat, tagcomplejoOb, tagcomplejoRe, tagcomplejoOp)
}

function cargarTagsComplejos(complejos, tagcomplejoOb, tagcomplejoRe, tagcomplejoOp){
    //CARGAMOS LOS TAGS COMPLEJOS
    //Usamos una bandera para saber si es el primer hijo o no
    let containerOb =  document.getElementById('comp-obligatorio'); //aca van los tags obligatorios
    let containerRe =  document.getElementById('comp-recomendado'); //aca van los tags recomendados
    let containerOp =  document.getElementById('comp-opcional'); //aca van los tags opcionales
    //
    let x = 0;
    let bandera = 0;
    let tag1
    let tag2
    //
    for(let i=0; i<tagcomplejoOb.length; i++){
        x++;
        for(let j=0; j<complejos.length; j++){
            if(tagcomplejoOb[i]==complejos[j].id_tag){
                if(bandera == 0){
                    bandera = 1
                    tag1 = complejos[j]
                }
                else{
                    bandera = 0
                    tag2 = complejos[j] 
                    x++;
                    insertarInputComplejo(tag1, tag2, x, containerOb)
                }                
            }
        }
    }
    for(let i=0; i<tagcomplejoRe.length; i++){
        x++;
        for(let j=0; j<complejos.length; j++){
            if(tagcomplejoRe[i]==complejos[j].id_tag){
                if(bandera == 0){
                    bandera = 1
                    tag1 = complejos[j]
                }
                else{
                    bandera = 0
                    tag2 = complejos[j]
                    x++;
                    insertarInputComplejo(tag1, tag2, x, containerRe)
                }                
            }
        }
    }
    for(let i=0; i<tagcomplejoOp.length; i++){
        x++;
        for(let j=0; j<complejos.length; j++){
            if(tagcomplejoOp[i]==complejos[j].id_tag){
                if(bandera == 0){
                    bandera = 1
                    tag1 = complejos[j]
                }
                else{
                    bandera = 0
                    tag2 = complejos[j]
                    x++;
                    insertarInputComplejo(tag1, tag2, x, containerOp)
                }                
            }
        }
    }
}

function mostrarPagina(archivo){
    //TIPO 1: AGREGAR
    //TIPO 2: MODIFICAR
    //TIPO 3: BORRAR
    let tipo 
    if(document.getElementById('guardar').checked){
        tipo = 1
    }
    else if(document.getElementById('modificar').checked){
        tipo = 2
    }
    else{
        tipo = 3
    }
    //
    claves = document.getElementById('claves');
    claves.value = '';
    if(tipo==1){
        document.getElementById('pdfguar').removeAttribute("hidden") //habilitar subir un pdf
        document.getElementById('pdfver').hidden=true  //no existe algo a mostrar
    }
    else{
        cargarClaves(archivo.claves_archivo)
        document.getElementById('pdfguar').hidden = true   //hay que mostrar un pdf
        document.getElementById('pdfver').removeAttribute("hidden")
        cargarPDF();
        if(tipo == 3){
            askEliminarPdf()
        }
    }    
    contadorchar("characla", "claves", 1040); //muestra cuantos caracteres quedan
    //
    //VACIAMOS EN CASO DE QUE YA HAYA TAGS DE OTRO ARCHIVO
    let containerOb =  document.getElementById('comp-obligatorio'); //aca van los tags obligatorios
    let containerRe =  document.getElementById('comp-recomendado'); //aca van los tags recomendados
    let containerOp =  document.getElementById('comp-opcional'); //aca van los tags opcionales
    //
    while (containerOb.hasChildNodes()) {
        containerOb.removeChild(containerOb.lastChild);
    }
    while (containerRe.hasChildNodes()) {
        containerRe.removeChild(containerRe.lastChild);
    }
    while (containerOp.hasChildNodes()) {
        containerOp.removeChild(containerOp.lastChild);
    }  
    //RECUPERAMOS LOS TAGS PARA CREAR LA PÁGINA    
    let tip= document.getElementById('tipo').value
    let subt = getSubtipoId()
    recuperarTags(tip, subt)
    //
    document.getElementById('sec-obligatorio').removeAttribute('hidden')
    document.getElementById('sec-recomendado').removeAttribute('hidden')
    document.getElementById('sec-opcional').removeAttribute('hidden')
    //
    document.getElementById('sectags').removeAttribute("hidden");
    if(tipo == 3){ //Se selecciono borrar
        document.getElementById('claves').disabled=true; //No se deben poder modificar las claves
        document.getElementById('div-btnborrar').removeAttribute("hidden"); //Mostramos el btn borrar
        document.getElementById('div-btnguardar').hidden=true; //escondemos el btn guardar
        document.getElementById('div-btnmodificar').hidden=true; //escondemos el btn modificar
        document.getElementById('agregar').hidden=true; //ocultamos el añadir tags
    }
    else{ //No se selecciono borrar
        document.getElementById('agregar').removeAttribute("hidden"); //Se muestra el añadir tags
        document.getElementById('claves').removeAttribute("disabled"); //si estaban disabled las claves ya no lo están
        if(tipo == 1){
            document.getElementById('div-btnborrar').hidden=true;
            document.getElementById('div-btnmodificar').hidden=true;
            document.getElementById('div-btnguardar').removeAttribute("hidden");
        }
        else{
            document.getElementById('div-btnmodificar').removeAttribute("hidden"); 
            document.getElementById('div-btnborrar').hidden=true;
            document.getElementById('div-btnguardar').hidden=true;
        }
    }
}

function ocultarPagina(){
    let padre = document.getElementById('comp-obligatorio')
    while(padre.hasChildNodes()){
        padre.removeChild(padre.lastChild)
    }
    padre = document.getElementById('comp-recomendado')
    while(padre.hasChildNodes()){
        padre.removeChild(padre.lastChild)
    }
    padre = document.getElementById('comp-opcional')
    while(padre.hasChildNodes()){
        padre.removeChild(padre.lastChild)
    }
    padre = document.getElementById('sectags').hidden = true;
    if(document.getElementById('archivos') != undefined){
        document.getElementById('archivos').remove()
        let taggeo = document.getElementById('taggeo')
        taggeo.classList.remove('col-lg-8')
        taggeo.classList.add('col-lg-12')      
    }
    let span = document.getElementById('spanPdf')
    while(span.hasChildNodes()){
        span.removeChild(span.lastChild)
    }
    span.hidden = true
    if(document.getElementById('removePDF') != undefined){
        document.getElementById('removePDF').remove()
    }

}

function insertarInputSimple(divmayor, tag, i){
    //
                                  
    if(tag.dato == 1){//Si el dato es tipeado      
        let cont = contadorSimple(tag.descripcion);                                                                        
        let idinput = crearInputSimple(divmayor, tag.dato_tipo, tag.descripcion, 1, i, cont) 
        cargarDatosSimples(cont, idinput, tag.descripcion);                                                             
    }
    else if(tag.dato == 2){//Si el dato se busca en la BD
        let cont = contadorSimple(tag.descripcion); 
        let idinput = crearSelect(divmayor, tag.id_tag, tag.descripcion, 1,i, cont) 
        cargarDatosSimples(cont, idinput, tag.descripcion); 
    }
    else if(tag.dato == 3){//Si el dato se busca en la BD despues de tipearlo.
        let cont = contadorSimple(tag.descripcion); 
        let idinput = crearSemiSelect(divmayor, tag.dato_tipo,tag.id_tag, tag.descripcion, 1, i, cont) 
        cargarDatosSimples(cont, idinput, tag.descripcion);  
    }  
}

function insertarInputComplejo(tag1, tag2, i, container){
    //Titulo del padre
    let texto = document.createElement("p");
    texto.innerHTML=tag1.descripcion
    texto.className = 'complejos';
    container.appendChild(texto);     
    //Creamos una row
    let divmayor=document.createElement("div")                                       
    divmayor.className = "row";                                                
    container.appendChild(divmayor)
    //
    let contaComplejo = contadorComplejo(tag1.deschijo, tag2.deschijo)
    //
    let divmedio = document.createElement("div")
    divmedio.className = "col-lg-6 col-md-12 row"   
    //
    let idinput1
    let idinput2
    if(tag1.dato == 1){
        idinput1 = crearInputSimple(divmedio, tag1.dato_tipo, tag1.deschijo, 2, i, contaComplejo)
    }
    else if(tag1.dato == 2){
        idinput1 = crearSelect(divmedio, tag1.id_tag_hijo, tag1.deschijo,2,i, contaComplejo) 
    }
    else if(tag1.dato == 3){
        idinput1 = crearSemiSelect(divmedio, tag1.dato_tipo, tag1.id_tag_hijo, tag1.deschijo, 2, i, contaComplejo) 
    }
    
    if(tag2.dato == 1){
        idinput2 = crearInputSimple(divmedio, tag2.dato_tipo, tag2.deschijo, 2, i+1, contaComplejo)
    }
    else if(tag2.dato == 2){
        idinput2 = crearSelect(divmedio, tag2.id_tag_hijo, tag2.deschijo,2,i+1, contaComplejo) 
    }
    else if(tag2.dato == 3){
        idinput2 = crearSemiSelect(divmedio, tag2.dato_tipo, tag2.id_tag_hijo, tag2.deschijo, 2, i+1, contaComplejo) 
    }                                    
    divmayor.appendChild(divmedio); 
    cargarDatosComplejos(contaComplejo, idinput1, idinput2, tag1.deschijo, tag2.deschijo)
    
}

function cargarDatosSimples(conta, idinput, tag){   
    let tags=[];
    let info=[];
    let cont=0;
    let band=0;
    let claves = document.getElementById('claves').value;
    for(let i = 0; i<claves.length; i++){
        if(claves[i] == '>'){
            cont++;
            band=0;
        }
        else if(claves[i] == ':'){
            band=1;
        }
        else if(claves[i] == '<'){
            tags[cont]=''
            info[cont]=''
        }
        else if(band == 0){
            tags[cont] = tags[cont] + claves[i];
        }
        else{
            info[cont] = info[cont] + claves[i];
        }
    } 
    let aux=0;
    //console.log(conta)
    let val=0;
    for(let i=0; i<tags.length; i++){
        if(tags[i] == tag)
        {
            if(conta == aux){
                document.getElementById(idinput).value = info[i];
                document.getElementById(idinput).placeholder = info[i];
                val=1;
            }
            else{
                aux++;
            }
            
        }
    }
    if(val == 0){
        document.getElementById(idinput).placeholder = 'No asignado';
    }
}

function cargarDatosComplejos(conta, idinput1, idinput2, tag1, tag2){
    let tags=[];
    let info=[];
    let cont=0;
    let band=0;
    let claves = document.getElementById('claves').value;
    for(let i = 0; i<claves.length; i++){
        if(claves[i] == '>'){
            cont++;
            band=0;
        }
        else if(claves[i] == ':'){
            band=1;
        }
        else if(claves[i] == '<'){
            tags[cont]=''
            info[cont]=''
        }
        else if(band == 0){
            tags[cont] = tags[cont] + claves[i];
        }
        else{
            info[cont] = info[cont] + claves[i];
        }
    } 
    let aux=0;  
    //console.log(conta + ' ' + tag1 + ' ' + tag2)
    let val=0;
    for(let i=0; i<tags.length; i++){ 
        if(tags[i] == tag1 && tags[i+1] == tag2)
        {
            //console.log(tags[i] + ' y ' + tags[i+1])
            if(conta == aux){
                document.getElementById(idinput1).value = info[i];
                document.getElementById(idinput1).placeholder = info[i];
                document.getElementById(idinput2).value = info[i+1];
                document.getElementById(idinput2).placeholder = info[i+1];
                val=1;
            }
            else{
                aux++;
            }
            
        }
    }
    if(val == 0){
        document.getElementById(idinput1).placeholder = 'No asignado';
        document.getElementById(idinput2).placeholder = 'No asignado';
    }
}

window.addEventListener("DOMContentLoaded", (event) => {
    const tipo = document.getElementById('tipo');
    const subtipo = document.getElementById('subtipo');
    const fecha = document.getElementById('fecha');
    const doc = document.getElementById('doc');

    const borrarBtn = document.getElementById('borrar');
    const modificarBtn = document.getElementById('modificar');
    const guardarBtn = document.getElementById('guardar');

    const checkEnableButton = () => {    
        if(tipo.value!='sel' && subtipo.value!='sel' && doc.value!= ''){
            borrarBtn.removeAttribute('disabled');
            modificarBtn.removeAttribute('disabled');            
            if(fecha.value != ''){
                guardarBtn.removeAttribute('disabled');            
            }
        }        
        else{
            borrarBtn.setAttribute('disabled', 'disabled');
            modificarBtn.setAttribute('disabled', 'disabled');
            guardarBtn.setAttribute('disabled', 'disabled');
        }   
    }

    subtipo.addEventListener('change', checkEnableButton);
    tipo.addEventListener('change', checkEnableButton);
    fecha.addEventListener('change', checkEnableButton);
    doc.addEventListener('keyup', checkEnableButton);   
    doc.addEventListener('change', checkEnableButton);   

    

    
});

function completarTag(){
    const tag = document.getElementById('tag')    
    let btn = document.getElementById('btn-tag')
    let div = document.getElementById('tag-agregar');
    while(div.hasChildNodes()){
        div.removeChild(div.lastChild)
    }
    if(tag.value!='sel'){
        btn.removeAttribute('disabled')       
        div.removeAttribute('hidden')
    }
    else{
        btn.setAttribute('disabled','disabled')
        div.hidden=true;
    }    
}

function agregarTag(){
    let idtag = document.getElementById('tag').value;
    var tag;
    let route = '/archivo/tag';   

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
            id: idtag
        }),
        dataType: 'json',
        success: function(res) {            
            tag = res
            let div = document.getElementById('tag-agregar');
            let div2 = document.createElement("div");   
            let lab = document.createElement('label');
            lab.innerHTML = tag.descripcion;
            div2.appendChild(lab);
            if(tag.dato == 1){
                let input = document.createElement('input')
                if(tag.dato_tipo == 1){
                    input.type = "number"
                    input.className="no-spin"
                }
                else{
                    input.type = "text"
                }
                input.id='agregarTag';
                input.setAttribute('onkeyup','checkGuardarTag()');
                input.className = 'form-control';
                div2.className = "col-lg-8";
                div2.appendChild(input)     
                div.appendChild(div2);   
            }
            if(tag.dato == 2){
                let input = document.createElement("select");
                getSelects(input, tag.id_tag);
                input.id='agregarTag';
                input.className = 'form-control';
                input.setAttribute('onchange','checkGuardarTag()');
                div2.className = "col-lg-8";
                div2.appendChild(input)     
                div.appendChild(div2);   
            }
            if(tag.dato == 3){
                let input = document.createElement("input");
                if(tag.dato_tipo == 1){                               
                input.type = "number";
                input.className="no-spin"
                }
                else{
                    input.type = "text";
                }                      
                input.setAttribute('list', "opciones-"+tag.id_tag);
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                    findTexto(input.value, tag.id_tag, input, "opciones"+tag.id_tag);
                    }
                });
                input.id='agregarTag';
                input.className = 'form-control';
                input.setAttribute('onkeyup','checkGuardarTag()');
                div2.className = "col-lg-8";                
                div2.appendChild(input)     
                div.appendChild(div2);   
                
            }
            let div3 = document.createElement('div')
            let btn = document.createElement('button')
            btn.type = 'button'
            btn.innerHTML = 'Agregar'               
            btn.setAttribute('onclick','guardarTag(\'' + 'agregarTag' + '\',\'' + tag.descripcion + '\',' + 2 + ',' + 0 + ',' + 0 +')');
            btn.className = 'btn btn-success';               
            btn.id= 'btnTagAgregar' 
            div3.className = 'col-lg-2';
            btn.setAttribute('disabled','disabled')
            div3.appendChild(document.createElement('br'))
            div3.appendChild(btn)
            div.appendChild(div3)            
            },
            error: function(res){
                console.log(res)
            }});
        
    
}

function checkGuardarTag(){
    let input=document.getElementById('agregarTag')
    let btn = document.getElementById('btnTagAgregar')
    if(input.value == ''){
        btn.setAttribute('disabled', 'disabled');
    }
    else{
        btn.removeAttribute('disabled')
    }
}

function guardarTag(idinput, tagname, tipo, cont, medida){
    console.log('TAG: ' + tagname + ' TIPO: ' + tipo + ' CONT: ' + cont + ' MEDIDA: ' + medida)
    let input
    let taghijo = null
    let claves = document.getElementById('claves')
    let ac=0
    //console.log(cont)
    if (medida == 2){
        input = document.getElementById('hijo' + idinput).value
        let num = idinput+1
        //console.log(num)
        taghijo = document.getElementById('label-o-' + num).innerHTML
        //console.log(taghijo)
    }
    else{
        if(medida == 0){
            input = document.getElementById(idinput).value
            //console.log(input)
        }
        else{
            if(medida== 4){
                input = document.getElementById('hijo' + idinput).value
            }
            else{
                input = document.getElementById('input' + idinput).value
            }            
            //console.log(input)
        }
        
    }

    if(tipo == 1){                
        if(medida != 2){
            console.log(tagname)
            if(claves.value.indexOf('<'+tagname+':')!= -1){     
                let first = -1;
                let last = -1;
                let comienza = 0;
                let band=0;
                let guardado =0;
                for(let i = 0; i<claves.value.length; i++){  
                    if(claves.value[i] == '<'){
                        //empieza un tag
                        comienza=0;
                        i++;
                    }            
                    if(comienza == 0){
                        for(let j=0; j<tagname.length; j++){
                            if(claves.value[i+j] != tagname[j]){
                                band=1;
                                break
                            }
                        } 
                        comienza = 1;
                        if(band == 0){               
                            if(ac == cont){                                
                                first = i-1; 
                                guardado = 1;
                            }    
                            ac++;          
                        }
                    }
                    if(claves.value[i] == '>'){
                        if(comienza == 1 && band == 0 && ac-1==cont){
                            last = i;
                        }
                        else{
                            comienza = 0;                        
                            band=0;                        
                        }
                    }
                }
                if(guardado == 1){
                    let stringNew = ''
                    for(let i=0; i<first; i++){
                        stringNew = stringNew + claves.value[i];
                    }
                    stringNew = stringNew + '<' + tagname + ':' + input.trim() + '>';
                    for(let i=last+1; i<claves.value.length; i++){
                        stringNew = stringNew + claves.value[i];
                    }
                    claves.value = stringNew
                }
                else{
                    claves.value = claves.value + '<' + tagname + ':' + input.trim() + '>'
                }
                
            }
            else{
                claves.value = claves.value + '<' + tagname + ':' + input.trim() + '>'
            }
        }
        else{
            if(claves.value.indexOf('<'+tagname+':')!= -1 && claves.value.indexOf('<'+taghijo+':')!= -1){ 
                console.log('Modificando un complejo')
                let firstP = -1, lastP = -1, comienza = 0, band= 0, guardado = 0
                for (let i = 0; i<claves.value.length; i++){
                    if(claves.value[i] == '<'){
                        //comienza un tag
                        comienza = 0;
                        i++;
                    }
                    if(comienza == 0){                        
                        for(let j=0; j<tagname.length; j++){
                            console.log(claves.value[i+j] + ' = ' + tagname[j] + '?')
                            if(claves.value[i+j] != tagname[j]){
                                band=1;
                            }
                        } 
                        comienza = 1
                        if(band == 0){                            
                            firstP = i-1; 
                            console.log('Se encontro el tag padre, posición: ' + firstP)
                        }              
                    }
                    if(claves.value[i] == '>'){
                        if(comienza == 1 && band == 0){
                            lastP = i;
                            comienza = 2
                            console.log('Tag padre termina en la posición: ' + lastP)
                            console.log('Evaluando tag siguiente:')
                            let j = 0
                            for(let k=lastP+2; k<(lastP+2+taghijo.length); k++){                            
                                console.log(claves.value[k] + ' = ' + taghijo[j] + '?aaa')
                                if(claves.value[k] != taghijo[j]){
                                    band=1;
                                    console.log('No')
                                    break
                                }
                                j++;
                            }                            
                        }
                        if(comienza == 2 && band == 0){
                            console.log('Si' + ac + ' = ' + cont + '?')
                            if(ac == cont){
                                guardado = 1  
                                break
                            }
                            else{
                                ac++
                            }                            
                        }
                        else{
                            comienza = 0;                        
                            band=0;                        
                        }
                    }                    
                }
                if(guardado == 1){
                    let stringNew = ''
                    for(let i=0; i<firstP; i++){
                        stringNew = stringNew + claves.value[i];
                    }
                    stringNew = stringNew + '<' + tagname + ':' + input.trim() + '>';
                    for(let i=lastP+1; i<claves.value.length; i++){
                        stringNew = stringNew + claves.value[i];
                    }
                    claves.value = stringNew
                }
                else{
                    claves.value = claves.value + '<' + tagname + ':' + input.trim() + '>' 
                }
            }
            else{
                claves.value = claves.value + '<' + tagname + ':' + input.trim() + '>'
            }
        }        
    }
    else{
        claves.value = claves.value + '<' + tagname + ':' + input.trim() + '>'
    }

             
    
}

function contadorchar(label, input, max){
    let lab = document.getElementById(label);
    let inp = document.getElementById(input)
    if (inp.value.length > max){
        lab.innerHTML = "No quedan caracteres"
        return false;
    }    
    else{
        lab.innerHTML = "Quedan " + (max - inp.value.length) + " caracteres"
    }

}

function findTexto(texto, id, padre, idlista){

    let route = '/archivo/busquedadirigida';   

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
            texto: texto,
            id: id
        }),
        dataType: 'json',
        success: function(res) {
            let lista = document.createElement("datalist");
            lista.id = idlista;
            for(i=0;i<res.length;i++){                
                let option = document.createElement("option");
                option.value = res[i].campo1;
                option.text = res[i].campo1;
                lista.appendChild(option);
            }
            padre.appendChild(lista)
        },
        error: function(res){
            console.log(res)
        }});

}

function getSelects(padre, id){
    let route = '/archivo/selects';    
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
            id: id
        }),
        dataType: 'json',
        success: function(res) {
            let option = document.createElement("option");
            option.value = 'sel';
            option.text = 'Seleccionar';            
            padre.appendChild(option);
            for(i=0;i<res.length;i++){
                let option = document.createElement("option");
                option.value = res[i].campo1;
                option.text = res[i].campo1;
                padre.appendChild(option);
            }
            padre.val='sel';
            return res;
        },
        error: function(res){
            console.log(res)
        }});
}

function popup(tipo, estado){  
    let popEl = document.getElementById('popup')
    if(estado){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        if(tipo == 1){
            document.getElementById('popBody').innerHTML = '<p>El archivo se ha guardado correctamente.</p>'            
        }
        else if(tipo ==2){           
            document.getElementById('popBody').innerHTML = '<p>El archivo se ha modificado con éxito.</p>'
        }
        else{
            document.getElementById('popBody').innerHTML = '<p>Se ha borrado el archivo.</p>'
        }
    }
    else{
        document.getElementById('popTitulo').innerHTML = 'Error'
        if(tipo == 1){
            document.getElementById('popBody').innerHTML = '<p>No se ha podido guardar el archivo.</p>'            
        }
        else if(tipo ==2){           
            document.getElementById('popBody').innerHTML = '<p>No se ha podido modificar el archivo.</p>'
        }
        else{
            document.getElementById('popBody').innerHTML = '<p>No se ha podido borrar el archivo.</p>'
        }
    }    
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function borrar(){ 
    let pdf = $("input[name=pdf]").val();
    let tipo = document.getElementById('tipo').value;
    let subtipo = document.getElementById('subtipo').value;
    let doc = document.getElementById('doc').value;
    let fecha = document.getElementById('fecha').value;
    let orden = document.getElementById('orden').value;
    let askpdf
    if(document.getElementById('askBorrar').checked){
        askpdf  = 'on'
    }
    else{
        askpdf = 'off'
    }

    let route = '/archivo/borrar';    
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
            tipo: tipo,
            subtipo: subtipo,
            doc: doc,
            fecha: fecha,
            orden: orden,
            pdf: pdf,
            askpdf : askpdf
        }),
        //dataType: 'json',
        success: function(res) {
            console.log(res)
            popup(3, res)
        },
        error: function(res){
            console.log(res)
    }});
}

function modificar() {
    let pdf = $("input[name=pdf]").val(); 
    let tipo = document.getElementById('tipo').value;
    let subtipo = document.getElementById('subtipo').value;
    let doc = document.getElementById('doc').value;
    let fecha = document.getElementById('fecha').value;
    let claves = document.getElementById('claves').value;
    let orden = document.getElementById('orden').value;


    let route = '/archivo/modificar';    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo: tipo,
            subtipo: subtipo,
            doc: doc,
            fecha: fecha,
            claves: claves,
            orden: orden, 
            pdf: pdf
        }),
        dataType: 'json',
        success: function(res) {
            console.log(res)
            popup(2, res)
        },
        error: function(res){
            console.log(res)
    }});
}

function guardar(){
    let pdfFile = document.getElementById('pdf')
    let pdf = pdfFile.files[0]
    let pdfName = document.getElementById('pdfname').innerHTML
    let tipo = document.getElementById('tipo').value
    let subtipo =  document.getElementById('subtipo').value
    let doc = document.getElementById('doc').value
    let fecha = document.getElementById('fecha').value
    let claves = document.getElementById('claves').value
    let orden = document.getElementById('orden').value

    let dataForm = new FormData();
    dataForm.append('pdf', pdf);
    dataForm.append('pdfname', pdfName);
    dataForm.append('tipo', tipo);
    dataForm.append('subtipo', subtipo);
    dataForm.append('doc', doc);
    dataForm.append('fecha', fecha);
    dataForm.append('claves', claves);
    dataForm.append('orden', orden);

    //
    console.log(dataForm.get("pdf"))
    //
    let route = '/archivo/crear'  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'POST',
        cache: false,
        data: dataForm,
        processData: false,
        contentType: false,
        //dataType: 'json',
        success: function(res) {
            console.log(res)
            popup(1, res)
        },
        error: function(res){
            console.log(res)
    }});
} 

function modalPdf(){
    let modalEl = document.getElementById('modal')
    document.getElementById('modalTitulo').innerHTML = 'Subir PDF'
    document.getElementById('modalBody').innerHTML = '<label for="pdf">Subir archivo</label>'
    + '<input type="file" id="pdfModal" accept = "application/pdf" name="pdf">'
    + '<br> <label for="pdfName">Guardar como: </label> <input type="text" id="pdfName" name="pdfName">'
    document.getElementById('btnConfirmarAccion').innerHTML = 'Subir PDF'      
    document.getElementById('btnConfirmarAccion').setAttribute('onclick', 'subirPDF()')  
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show()
}

function subirPDF(){
    let pdf = document.getElementById('pdfModal')
    let clonedpdf = pdf.cloneNode(true);
    clonedpdf.id = "pdf"
    clonedpdf.setAttribute('hidden', 'hidden')
    //
    let name = document.getElementById('pdfName').value   
    let lab = document.createElement('label')
    if(name == '') {
        lab.innerHTML = pdf.files[0].name
    }
    else{        
        lab.innerHTML = name + '.pdf'        
    }
    lab.id = 'pdfname'
    let placeholder = document.createElement('div')
    let icon = document.createElement('i')
    icon.className = 'fas fa-file-alt'
    placeholder.appendChild(icon)
    placeholder.appendChild(lab)
    //
    let span = document.getElementById('spanPdf')
    while(span.hasChildNodes()){
        span.removeChild(span.lastChild)
    }
    span.appendChild(clonedpdf)
    span.appendChild(placeholder)
    span.removeAttribute('hidden')
    //
    let modal= document.getElementById('modal')
    bootstrap.Modal.getInstance(modal).hide() 
}

function askEliminarPdf(){
    let padre = document.getElementById('pdfver')
    let checkbox = document.createElement('input')
    checkbox.type = "checkbox"
    checkbox.id = 'askBorrar'
    let lab = document.createElement('label')
    lab.setAttribute("for", "askBorrar")
    lab.innerHTML = "Eliminar PDF de los archivos subidos"
    let div = document.createElement('div')
    div.id = "removePDF"
    div.appendChild(checkbox)
    div.appendChild(lab)
    padre.appendChild(div)
}