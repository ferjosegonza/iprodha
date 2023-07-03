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

var archivoid

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
}

function existeCheck(){
    //Al presionar algún botón de guardar/modificar verificamos si existe un archivo 
    //que coincida con los parámetros mencionados.
    //PARÁMETROS
    ocultarPagina()
    let tipoId = document.getElementById('tipo').value
    let fecha = document.getElementById('fecha').value
    let doc = document.getElementById('doc').value
    let subtid = getSubtipoId()
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
            //La operación es válida
            if(res.response != null && !(document.getElementById('guardar').checked) //se quiere modificar algo que existe
            || res.response == null && (document.getElementById('guardar').checked)){ //se quiere guardar y todavia no existe
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
        archivos.classList.add('asideP')
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
    taggeo.classList.add('col-lg-9')
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
            let titulo = document.createElement('h5')
            titulo.innerHTML = 'Archivos:'
            let cardhead = document.createElement('div')
            cardhead.className = 'card-head'
            cardhead.appendChild(titulo)
            archivos.appendChild(cardhead)
            let cardbody = document.createElement('div')
            cardbody.className = 'card-body'
            archivos.appendChild(cardbody)   
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
                    tr.onclick = function (){
                        document.getElementById('archivos').remove()
                        let taggeo = document.getElementById('taggeo')
                        taggeo.classList.remove('col-lg-9')
                        taggeo.classList.add('col-lg-12')
                        let mes, dia
                        if(res[i].mes_archivo.length == 1){
                            mes = '0'+res[i].mes_archivo
                        }
                        else{
                            mes = res[i].mes_archivo
                        }
                        if(res[i].dia_archivo.length == 1){
                            dia = '0'+res[i].dia_archivo
                        }
                        else{
                            dia = res[i].dia_archivo
                        }
                        let str= res[i].ano_archivo.toString() + '-' + mes + '-' + dia
                        document.getElementById('fecha').value = str
                        document.getElementById('asunto').value = res[i].asunto
                        mostrarPagina(res[i])
                    }
                    tablebody.appendChild(tr)
                }  
            }
                        
        },
        error: function(res){console.log(res)}});
}

function contadorSimple(nombre){
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
    //input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida +  ')')
    
    if(medida != 1){
        input.setAttribute('onchange', 'derivado('+ i + ',' + id + ')');
    } 
    else{
        input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida +  ')')
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
          //guardarTag(i , nombre , 1, contador, medida)
        }
    });   
    //input.setAttribute('onchange', 'guardarTag(\''+ input.id + '\',\'' + nombre + '\')')
    //input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida + ')')
    
    if(medida != 1){
        input.setAttribute('onchange', 'derivado('+ i + ',' + id + ')');
    }   
    else{
        input.setAttribute('onchange', 'guardarTag('+ i + ',\'' + nombre + '\',' + 1 + ',' + contador + ',' + medida +  ')')
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

    console.log(complejos)

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
            let labpadre = document.getElementById("label-o-" + id).innerHTML
            guardarTagComplejo(labpadre, tagname, document.getElementById('hijo'+id).value, document.getElementById('hijo'+number).value, contador)

            //guardarTag(number, tagname, 1, contador, 4)
            
           // guardarTag(id, labpadre, 1, contador, 2)
        },
        error: function(res){
            console.log(res)
        }});

}

function cargarPDF(path, nombre){
    let ruta = path.substring(14) + nombre
    document.getElementById('embedpdf').setAttribute('src', ruta)
    let lab = document.createElement('label')
    lab.id = 'pdfname'
    lab.innerHTML = nombre
    let labpath = document.createElement('label')
    labpath.innerHTML = path
    labpath.id = 'pdfpath'
    labpath.hidden = true
    let placeholder = document.createElement('div')
    let icon = document.createElement('i')
    icon.className = 'fas fa-file-alt'
    placeholder.appendChild(icon)
    placeholder.appendChild(lab)
    placeholder.appendChild(labpath)
    //
    let span = document.getElementById('spanPdf')
    while(span.hasChildNodes()){
        span.removeChild(span.lastChild)
    }
    span.appendChild(placeholder)
    span.removeAttribute('hidden')
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
    let k = 0;
    let bandera = 0;
    let tag1
    let tag2
    let row
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
                    if(k % 2  == 0){
                        row = document.createElement('div')
                        row.className = 'row'
                    }                    
                    insertarInputComplejo(tag1, tag2, x, containerOb, row)                     
                    k++
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
                    if(k % 2  == 0){
                        row = document.createElement('div')
                        row.className = 'row'
                    }                    
                    insertarInputComplejo(tag1, tag2, x, containerRe, row)                     
                    k++
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
                    if(k % 2  == 0){
                        row = document.createElement('div')
                        row.className = 'row'
                    }                    
                    insertarInputComplejo(tag1, tag2, x, containerOp, row)                     
                    k++
                }                
            }
        }
    }
}

function mostrarPagina(archivo){
    //TIPO 1: AGREGAR
    console.log(archivo)
    //TIPO 2: MODIFICAR
    archivoid = archivo.id_archivo
    let tipo 
    if(document.getElementById('guardar').checked){
        tipo = 1
    }
    else if(document.getElementById('modificar').checked){
        tipo = 2
    }
    //
    claves = document.getElementById('claves');
    claves.value = '';
    if(tipo==1){
        document.getElementById('sec-pdf').removeAttribute("hidden")
        document.getElementById('pdfguar').removeAttribute("hidden") 
        document.getElementById('previewpdf').hidden=true 
    }
    else{
        cargarClaves(archivo.claves_archivo)
        document.getElementById('sec-pdf').removeAttribute("hidden")
        document.getElementById('pdfguar').hidden = true   //hay que mostrar un pdf
        document.getElementById('previewpdf').removeAttribute("hidden")
        cargarPDF(archivo.path_archivo, archivo.nombre_archivo);
       /*  if(tipo == 3){
            askEliminarPdf()
        } */
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
    document.getElementById('agregar').removeAttribute("hidden"); //Se muestra el añadir tags
    document.getElementById('claves').removeAttribute("disabled"); //si estaban disabled las claves ya no lo están
    if(tipo == 1){
        document.getElementById('div-btnmodificar').hidden=true;
        document.getElementById('div-btnguardar').removeAttribute("hidden");
    }
    else{
        document.getElementById('div-btnmodificar').removeAttribute("hidden"); 
        document.getElementById('div-btnguardar').hidden=true;
    }
    
}

function ocultarPagina(){    
    elementos=[]
    complejos=[]
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
    document.getElementById('sec-pdf').hidden = true
    document.getElementById('pdfguar').hidden = true
    document.getElementById('previewpdf').hidden = true 
    let aside = document.getElementById('aside-pdf')
    if(aside != undefined){
        while(aside.hasChildNodes()){
            aside.removeChild(aside.lastChild)
        }
        aside.remove() 
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

function insertarInputComplejo(tag1, tag2, i, container, divmayor){
    //Titulo del padre
    let texto = document.createElement("p");
    texto.innerHTML=tag1.descripcion
    texto.className = 'complejos';                            
    container.appendChild(divmayor)
    //
    let contaComplejo = contadorComplejo(tag1.deschijo, tag2.deschijo)
    //
    let divmedio = document.createElement("div")
    divmedio.appendChild(texto);    
    divmedio.className = "col-lg-6 col-md-12 row divmedio"   
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
    let val=0;
    for(let i=0; i<tags.length; i++){
        if(tags[i] == tag)
        {
            if(conta == aux){
                if(document.getElementById(idinput).tagName  == 'SELECT'){
                //document.getElementById(idinput).value = info[i];
                   // $('#' + idinput + ' option[value="' + info[i] + '"]').attr('selected','selected');
                }
                else{
                    document.getElementById(idinput).value = info[i];
                }           
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
    let val=0;
    for(let i=0; i<tags.length; i++){ 
        if(tags[i] == tag1 && tags[i+1] == tag2)
        {
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
    const tipo = document.getElementById('tipo')
    const subtipo = document.getElementById('subtipo')
    const fecha = document.getElementById('fecha')
    const doc = document.getElementById('doc')
    const modificarBtn = document.getElementById('modificar')
    const guardarBtn = document.getElementById('guardar')

    const checkEnableButton = () => {    
        if(tipo.value!='sel' && subtipo.value!='sel' && doc.value!= ''){
            modificarBtn.removeAttribute('disabled');            
            if(fecha.value != ''){
                guardarBtn.removeAttribute('disabled');            
            }
        }        
        else{
            modificarBtn.setAttribute('disabled', 'disabled');
            guardarBtn.setAttribute('disabled', 'disabled');
        }   
    }

    const checkFecha = () => {    
        let today = new Date();
        let chosen = new Date(fecha.value)
        let aviso= document.getElementById('avisofecha')
        if(chosen > today){
           console.log('error')
           aviso.removeAttribute('hidden')
        }    
        else{
            console.log('bien')
            aviso.hidden=true
        }
    }

    subtipo.addEventListener('change', checkEnableButton)
    tipo.addEventListener('change', checkEnableButton)
    fecha.addEventListener('change', checkEnableButton)
    fecha.addEventListener('change', checkFecha)
    doc.addEventListener('keyup', checkEnableButton)  
    doc.addEventListener('change', checkEnableButton)   
    

    
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
    let input
    let taghijo = null
    let claves = document.getElementById('claves')
    let ac=0
    console.log(medida, tagname)
    if (medida == 2){
        input = document.getElementById('hijo' + idinput).value
        let num = idinput+1
        taghijo = document.getElementById('label-o-' + num).innerHTML
        
        console.log('guardando hijo ' + idinput + ' y ' + num)
    }
    else{
        if(medida == 0){
            input = document.getElementById(idinput).value
        }
        else{
            if(medida== 4){
                input = document.getElementById('hijo' + idinput).value
            }
            else{
                input = document.getElementById('input' + idinput).value
            }            
        }
        
    }

    if(tipo == 1){                
        if(medida != 2){
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
                let firstP = -1, lastP = -1, comienza = 0, band= 0, guardado = 0
                for (let i = 0; i<claves.value.length; i++){
                    if(claves.value[i] == '<'){
                        //comienza un tag
                        comienza = 0;
                        i++;
                    }
                    if(comienza == 0){                        
                        for(let j=0; j<tagname.length; j++){
                            if(claves.value[i+j] != tagname[j]){
                                band=1;
                            }
                        } 
                        comienza = 1
                        if(band == 0){                            
                            firstP = i-1; 
                        }              
                    }
                    if(claves.value[i] == '>'){
                        if(comienza == 1 && band == 0){
                            lastP = i;
                            comienza = 2
                            let j = 0
                            for(let k=lastP+2; k<(lastP+2+taghijo.length); k++){                   
                                if(claves.value[k] != taghijo[j]){
                                    band=1;
                                    break
                                }
                                j++;
                            }                            
                        }
                        if(comienza == 2 && band == 0){
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
    
    console.log(claves.value)             
    
}

function guardarTagComplejo(tagpadre, taghijo, valpadre, valhijo, cont){
    console.log('A guardar : <'+tagpadre+':'+valpadre+'><'+taghijo+':'+valhijo+'>')
    let claves = document.getElementById('claves')
    let ac=0
    if(claves.value.indexOf('<'+tagpadre+':')!= -1 && claves.value.indexOf('<'+taghijo+':')!= -1){ 
        console.log('Ya existen los tags')
        let firstP = -1, lastP = -1, firstH = -1, lastH = -1, comienza = 0, band= 0, guardado = 0
        for (let i = 0; i<claves.value.length; i++){
            console.log('Analizando caracter ' + claves.value[i])
            if(claves.value[i] == '<'){
                console.log('comienza un tag')
                //comienza un tag
                comienza = 0;
                i++;
            }
            if(comienza == 0 && firstP == -1){ 
                let advance = 0                       
                for(let j=0; j<tagpadre.length; j++){
                    console.log(claves.value[i+j] + ' = '+ tagpadre[j] + ' ?')
                    if(claves.value[i+j] != tagpadre[j]){
                        band=1;
                    }
                    advance = j
                } 
                comienza = 1
                if(band == 0){        
                    console.log('El padre comienza en la posicion: ' + i + ' - 1')                    
                    firstP = i-1; 
                }           
                else{
                    firstP = -1
                }   
                i = i + advance;
                console.log('El tag padre termina en la posicion: ' + i)   
            }
            if(claves.value[i] == '>'){
                if(comienza == 1 && band == 0 && firstH == -1){
                    lastP = i;
                    comienza = 2
                    console.log('Analizando si el siguiente es el hijo: ')      
                    let j = 0
                    for(let k=lastP+2; k<(lastP+2+taghijo.length); k++){       
                        console.log(claves.value[k] + ' = ' + taghijo[j] + ' ?' )            
                        if(claves.value[k] != taghijo[j]){
                            band=1;
                            break
                        }
                        j++;
                    }            
                    if(band == 0){
                        console.log('El siguiente hijo empieza en ' + lastP + ' + 2')
                        firstH = lastP+2
                        console.log('Es decir empieza en el caracter: ' + claves.value[firstH])
                    }  
                    else{
                        firstH = -1
                    }              
                }
                console.log(firstH)
                if(firstH != -1){
                    console.log('existe un hijo')
                    console.log(claves.value.length)
                    for(let k=firstH; k<claves.value.length; k++){
                        console.log(claves.value[k])
                        if(claves.value[k] == '>'){
                            lastH=k
                            console.log('El hijo termina en posicion '+ k)
                            break
                        }
                    }
                }
                if(comienza == 2 && band == 0){
                    console.log(ac, cont)
                    if(ac == cont){
                        guardado = 1  
                        break
                    }
                    else{
                        ac++
                    }                            
                }
                else{
                    firstP = -1
                    firstH = -1
                    lastP = -1
                    lastH = -1
                    comienza = 0                        
                    band=0                       
                }
            }                    
        }
        if(guardado == 1){
            let stringNew = ''
            for(let i=0; i<firstP; i++){
                stringNew = stringNew + claves.value[i];
            }
            stringNew = stringNew + '<' + tagpadre + ':' + valpadre.trim() + '><' + taghijo + ':' + valhijo.trim() + '>';
            for(let i=lastH+1; i<claves.value.length; i++){
                stringNew = stringNew + claves.value[i];
            }
            claves.value = stringNew
        }
        else{
            claves.value = claves.value + '<' + tagpadre + ':' + valpadre.trim() + '><' + taghijo + ':' + valhijo.trim() + '>';
        }
    }
    else{
        console.log('Aun no existen los tags')
        claves.value = claves.value + '<' + tagpadre + ':' + valpadre.trim() + '><' + taghijo + ':' + valhijo.trim() + '>';
    }
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
    console.log(tipo, estado)
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
    }    
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function modificar() {
    let pdf = $("input[name=pdf]").val(); 
    let tipo = document.getElementById('tipo').value;
    let subtipo = document.getElementById('subtipo').value;
    let doc = document.getElementById('doc').value;
    let fecha = document.getElementById('fecha').value;
    let claves = document.getElementById('claves').value;
    let orden = document.getElementById('orden').value;
    let asunto = document.getElementById('asunto').value


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
            pdf: pdf,
            asunto: asunto,
            id: archivoid
        }),
        dataType: 'json',
        success: function(res) {
            popup(2, res)
        },
        error: function(res){
            console.log(res)
            console.log(res.responseText)
            popup(2, false)
    }});
}

function guardar(){
    let pdf = 'off'
    let pdfFile = document.getElementById('pdf')
    let pdfName = ''
    if(pdfFile!=undefined){ 
        pdf = 'on'
       pdfName = document.getElementById('pdfname').innerHTML
    }        
    let tipo = document.getElementById('tipo').value
    let subtipo =  document.getElementById('subtipo').value
    let doc = document.getElementById('doc').value
    let fecha = document.getElementById('fecha').value
    let claves = document.getElementById('claves').value
    let orden = document.getElementById('orden').value
    let asunto = document.getElementById('asunto').value
    console.log(subtipo)
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
        data: ({'_token': $('#signup-token').val(), 
        'tipo': tipo,
        'subtipo': subtipo,
        'doc': doc,
        'fecha': fecha,
        'claves': claves,
        'orden': orden,
        'asunto': asunto,
        'pdf': pdf,
        'pdfname': pdfName}),
        processData: false,
        contentType: false,
        //dataType: 'json',
        success: function(res) {
            console.log(res)
            popup(1, res)
        },
        error: function(res){
            console.log(res.responseText)
            popup(1, false)
    }});
} 

function modalPdf(){
    let modalEl = document.getElementById('modal')
    document.getElementById('modalTitulo').innerHTML = 'Subir PDF'
    document.getElementById('modalBody').innerHTML = '<label for="pdf">Subir archivo: </label>'
    + '<input type="file" id="pdfModal" accept = "application/pdf" name="pdf">'
    + '<br> <label for="pdfName">Guardar como: </label> <input type="text" id="pdfName" name="pdfName" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9_-]/g, \'\')">'
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
    let labpath = document.createElement('label')    
    let placeholder = document.createElement('div')
    let icon = document.createElement('i')
    icon.className = 'fas fa-file-alt'
    placeholder.appendChild(icon)
    placeholder.appendChild(lab)
    placeholder.appendChild(labpath)
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
    //
    src= URL.createObjectURL(pdf.files[0])
    document.getElementById('embedpdf').setAttribute('src', src)
    document.getElementById('previewpdf').removeAttribute('hidden')
}

function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function cambiarDireccionPDF(modo){
    let padre = document.getElementById('padre')
    let taggeo = document.getElementById('taggeo')       
    let stick = document.getElementById('sec-pdf')
    let btn = document.getElementById('radio-pdf')    

    let aside = document.getElementById('aside-pdf')
    if(aside != undefined){
        while(aside.hasChildNodes()){
            aside.removeChild(aside.lastChild)
        }
        aside.remove() 
    }

    if(modo == 'N'){
        taggeo.classList.remove('col-lg-7')
        taggeo.classList.add('col-lg-12')
        stick.removeAttribute('hidden')           
        insertAfter(document.getElementById('spanPdf'), btn)    
    }
    else if(modo == 'V'){        
        taggeo.classList.remove('col-lg-12')
        taggeo.classList.add('col-lg-7')
        let aside = document.createElement('aside')
        aside.classList.add('col-lg-5')
        aside.classList.add('card')
        aside.classList.add('asideV')
        aside.id = 'aside-pdf'
        let div = document.createElement('div')
        div.className = 'row'
        let div1 = document.createElement('div')
        div1.className = 'col-lg-3'
        div1.append(btn)                   
        let div2 = document.createElement('div')
        div2.className = 'col-lg-8'
        let lab = document.createElement('label')
        lab = '    ' + document.getElementById('pdfname').innerHTML
        let icon = document.createElement('i')
        icon.className = 'fas fa-file-alt'
        div2.append(icon)
        div2.append(lab)
        div.append(div1)
        div.append(div2)
        stick.hidden = true
        let pdf = document.createElement('embed')
        if(document.getElementById('guardar').checked){
            let pdfM = document.getElementById('pdfModal')
            pdf.src = URL.createObjectURL(pdfM.files[0])
        }
        else{
            let path = document.getElementById('pdfpath').innerHTML + document.getElementById('pdfname').innerHTML
            pdf.src = path.substring(14)
        }        
        aside.classList.add('sticky')
        div.classList.add('padre-pdf-sticky-v')
        pdf.classList.add('pdf-sticky-v')
        div.appendChild(pdf)
        aside.appendChild(div)
        padre.appendChild(aside)
    }
    else if(modo == 'H'){
        taggeo.classList.add('col-lg-12')
        taggeo.classList.remove('col-lg-7')
        let aside = document.createElement('aside')
        aside.classList.add('col-lg-12')
        aside.classList.add('card')
        aside.id = 'aside-pdf'        
        let div = document.createElement('div')
        aside.append(btn)            
        stick.hidden = true
        let pdf = document.createElement('embed')
        if(document.getElementById('guardar').checked){
            let pdfM = document.getElementById('pdfModal')
            pdf.src = URL.createObjectURL(pdfM.files[0])
        }
        else{
            let path = document.getElementById('pdfpath').innerHTML + document.getElementById('pdfname').innerHTML
            pdf.src = path.substring(14)
        }  
        aside.classList.add('sticky')
        div.classList.add('row')
        //div.classList.add('padre-pdf-sticky-v')
        div.classList.add('padre-pdf-sticky-h')
        div.appendChild(pdf)
        aside.appendChild(div)  
        pdf.classList.add('pdf-sticky-h')
        aside.classList.add('asideH')
        padre.prepend(aside)
        //appendChild(aside)
    }
}

function getUser(){
    let route = '/archivo/getuser'  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        type: 'GET',
        cache: false,
        processData: false,
        contentType: false,
        //dataType: 'json',
        success: function(res) {
            console.log(res)
        },
        error: function(res){
            console.log(res.responseText)
    }});

}