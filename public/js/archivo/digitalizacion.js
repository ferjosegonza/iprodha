class elemento{
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
        let bandera= 0;       
        for(i = 1; i < tipo.length; i++){ 
            if(isNaN(document.getElementById('tipo').value[i]))                
            {                    
                i=tipo.length+1;    
            }
            else{
                tipoId = tipoId + document.getElementById('tipo').value[i].toString(); 
            }
        }    
        document.getElementById('subtipo').hidden = false;
        document.getElementById('placeholder').hidden = true;
        let subtipo = document.getElementById('subtipo')
        let subtid
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
}    

function existeCheck(){
    const tipoId = document.getElementById('tipo').value;
    const subtipo = document.getElementById('subtipo');
    const fecha = document.getElementById('fecha').value;
    const doc = document.getElementById('doc').value;  
    bandera=0;
    let subtid = '';
    for(i=0; i<subtipo.value.length; i++){
        if (bandera==1){
            subtid= subtid + subtipo.value[i];
        }
        else{
            if(subtipo.value[i]=='|')
            {
                bandera=1;
            }
        }
    }


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
            if(res.response != null && !(document.getElementById('guardar').checked) //se quiere modificar o borrar algo que existe
            || res.response == null && (document.getElementById('guardar').checked)){ //se quiere guardar y todavia no existe
                
                claves = document.getElementById('claves');
                claves.value = '';
                if(document.getElementById('guardar').checked){
                    document.getElementById('pdfguar').removeAttribute("hidden"); //habilitar subir un pdf
                    document.getElementById('pdfver').hidden=true;  //no existe algo a mostrar
                }
                else{                    
                    document.getElementById('pdfguar').hidden = true;   //hay que mostrar un pdf
                    let path = res.response.path_archivo + res.response.nombre_archivo;
                    document.getElementById('linkpdf').setAttribute('href', path);
                    document.getElementById('pdfver').removeAttribute("hidden");
                    console.log(path)
                    document.getElementById('pdfverpdf').setAttribute('data', path);
                }
                let tags=[];
                let info=[];
                let cont=0;
                let band=0;
                if(res.response!=null){ //Si estamos modificando o borrando
                    for(i=0; i<res.response.claves_archivo.length; i++){    
                        //obtenemos los tags ya cargados
                        //i es cada caracter                                                
                        if(band==2){
                            if(res.response.claves_archivo[i] == '>'){
                                band=0;
                            }   
                            else{
                                info[cont]=info[cont] + res.response.claves_archivo[i]
                            }
                        }if(band==1){
                            if(res.response.claves_archivo[i] == ':'){
                                band=2;
                                info[cont]=''
                            }   
                            else{
                                tags[cont]=tags[cont] + res.response.claves_archivo[i]
                            }          
                        }
                        if(res.response.claves_archivo[i] == '<'){
                            band=1; 
                            cont+=1;
                            tags[cont]=''
                        }                        
                    }
                }                 
                //le damos formato de tag:
                for(i=1; i<tags.length; i++){
                    claves.value = claves.value + '<'+tags[i]+':'+info[i]+'>';
                }
                contadorchar("characla", "claves", 1040); //muestra cuantos caracteres quedan

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
                    data: ({
                        _token: $('#signup-token').val(),
                        tipo: tipoId,
                        subtipo: subtid,
                        fecha: fecha,
                        doc: doc
                    }),
                    dataType: 'json',
                    success: function(res) {    
                        //obligatorio:   
                        let containerOb =  document.getElementById('comp-obligatorio'); //aca van los tags obligatorios
                        let containerRe =  document.getElementById('comp-recomendado'); //aca van los tags recomendados
                        let containerOp =  document.getElementById('comp-opcional'); //aca van los tags opcionales
                        //en caso de recargar el archivo: removemos los hijos anteriores (TODAVIA POR PROBAR)
                        while (containerOb.hasChildNodes()) {
                            containerOb.removeChild(containerOb.lastChild);
                        }
                        while (containerRe.hasChildNodes()) {
                            containerRe.removeChild(containerRe.lastChild);
                        }
                        while (containerOp.hasChildNodes()) {
                            containerOp.removeChild(containerOp.lastChild);
                        }
                        //Variables donde guardar los tags complejos que tendremos que consultar despues
                        let tagcomplejoOb=[]    //Obligatorio
                        let tagcomplejoRe=[]    //Recomendado
                        let tagcomplejoOp=[]    //Opcional
                        //Bandera para comprobar que existen tags en cada categoría
                        let bandOb=0;   //Obligatorio
                        let bandRe=0;   //Recomendado
                        let bandOp=0;   //Opcional
                        //Indices para el array de complejos                        
                        contOb=0;   //Obligatorio
                        contRe=0;   //Recomendado
                        contOp=0;   //Opcional
                        //Acumuladores que nos indican cuándo pasar a la fila siguiente 
                        //para permitir que la web sea responsive
                        rowOb=0;
                        rowRe=0;
                        rowOp=0;       
                        //
                        for(let i=0;i<res.response.length;i++){      //Por cada tag recuperado      
                            if(res.response[i].id_tipo == 1){                                
                                   //Si el tag es obligatorio...            
                                if (bandOb==0){ 
                                    //Existen tags obligatorios, podemos mostrar la sección
                                    bandOb=1;
                                    document.getElementById('sec-obligatorio').hidden=false;
                                }
                                if(res.response[i].estructura == 1){ //Si el tag es un tag simple (no complejo)
                                    if(rowOb==0){ //Si es la primera fila/Si se reincició
                                        //creamos divmayor con clase row
                                        var divmayorOb=document.createElement("div");                                        
                                        divmayorOb.className = "row";
                                        containerOb.appendChild(divmayorOb)
                                    }                                 
                                    if(res.response[i].dato == 1){//Si el dato es tipeado      
                                        let cont = contadorSimple(res.response[i].descripcion);                                                                        
                                        let idinput = crearInputSimple(divmayorOb, res.response[i].dato_tipo, res.response[i].descripcion, 1, i, cont) 
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion);                                                             
                                    }
                                    else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                        let cont = contadorSimple(res.response[i].descripcion); 
                                        let idinput = crearSelect(divmayorOb, res.response[i].id_tag, res.response[i].descripcion, 1,i, cont) 
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion); 
                                    }
                                    else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo.
                                        let cont = contadorSimple(res.response[i].descripcion); 
                                        let idinput = crearSemiSelect(divmayorOb, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1, i, cont) 
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion);  
                                    }  
                                    rowOb+=3
                                    if(rowOb==12){                
                                        //Si ya llegamos al máximo de elementos en una row
                                        //en la proxima iteración creaeremos otra                 
                                        rowOb=0
                                    }    
                                }
                                else{
                                    //Si es un tag complejo se añade a la lista de complejos
                                    tagcomplejoOb[contOb] = res.response[i].id_tag;
                                    contOb+=1;
                                }
                            }
                            else if(res.response[i].id_tipo == 2) //Si el tag es recomendado
                                {
                                    //recomendada:
                                    if(bandRe==0){
                                        //Existen tags recomendados, se puede mostrar la sección
                                        bandRe=1;
                                        document.getElementById('sec-recomendado').hidden=false;
                                    }
                                    if(res.response[i].estructura == 1){       
                                        //El tag es simple (no complejo)              
                                        if(rowRe==0){
                                            //Si ya llegamos al máximo de elementos en una row
                                            //en la proxima iteración creaeremos otra        
                                            var divmayorRe=document.createElement("div");                                        
                                            divmayorRe.className = "row";
                                            containerRe.appendChild(divmayorRe)
                                        } 
                                        if(res.response[i].dato == 1){//Si el dato es tipeado      
                                            let cont = contadorSimple(res.response[i].descripcion);                                  
                                            let idinput = crearInputSimple(divmayorRe, res.response[i].dato_tipo, res.response[i].descripcion, 1, i, cont)                                      
                                            cargarDatosSimples(cont, idinput, res.response[i].descripcion); 
                                        }
                                        else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                            let cont = contadorSimple(res.response[i].descripcion); 
                                            let idinput = crearSelect(divmayorRe, res.response[i].id_tag, res.response[i].descripcion, 1, i, cont)
                                            cargarDatosSimples(cont, idinput, res.response[i].descripcion); 
                                        }  
                                        else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                            let cont = contadorSimple(res.response[i].descripcion); 
                                            let idinput = crearSemiSelect(divmayorRe, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1,i, cont) 
                                            cargarDatosSimples(cont, idinput, res.response[i].descripcion);  
                                        }
                                        rowRe+=3
                                        if(rowRe==12){                    
                                            //Ultimo elemento e iniciamos una nueva fila               
                                            rowRe=0
                                        }                                        
                                    }
                                    else{
                                        //Si es un tag complejo se añade a la lista de complejos
                                        tagcomplejoRe[contRe] = res.response[i].id_tag;
                                        contRe+=1;
                                    }
                                }
                            else{
                                //El tag es opcional:
                                if(bandOp==0){
                                    //Hay tags opcionales, podemos mostrar la sección
                                    bandOp=1;
                                    document.getElementById('sec-opcional').hidden=false;
                                }
                                if(res.response[i].estructura == 1){  
                                    //Si el tag es simple (No complejo)                                  
                                    if(rowOp==0){
                                        //Si ya llegamos al máximo de elementos en una row
                                        //en la proxima iteración creaeremos otra        
                                        var divmayorOp=document.createElement("div");                                        
                                        divmayorOp.className = "row";
                                        containerOp.appendChild(divmayorOp)
                                    }                              
                                    if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                        let cont = contadorSimple(res.response[i].descripcion); 
                                        let idinput = crearInputSimple(divmayorOp, res.response[i].dato_tipo, res.response[i].descripcion, 1, i, cont)                                       
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion);   
                                    }
                                    else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                        let cont = contadorSimple(res.response[i].descripcion); 
                                        let idinput = crearSelect(divmayorOp, res.response[i].id_tag, res.response[i].descripcion, 1,i, cont) 
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion); 
                                    }
                                    else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                        let cont = contadorSimple(res.response[i].descripcion); 
                                        let idinput = crearSemiSelect(divmayorOp, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1, i, cont)
                                        cargarDatosSimples(cont, idinput, res.response[i].descripcion); 
                                    } 
                                    rowOp+=3
                                    if(rowOp==12){                         
                                        //Es el último elemento de esta row y se inicia otra        
                                        rowOp=0
                                    }
                                }
                                else{
                                    //El tag es complejo y se añade a la lista de complejos
                                    tagcomplejoOp[contOp] = res.response[i].id_tag;
                                    contOp+=1;
                                }
                            }                            
                        }
                        //Ahora debemos consultar los complejos:
                        let route = '/archivo/complejos';
                        let concat = tagcomplejoOb.concat(tagcomplejoRe,tagcomplejoOp);
                        //
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
                            data: ({
                                _token: $('#signup-token').val(),
                                tags: concat
                            }),
                            dataType: 'json',
                            success: function(res) {
                                //Empezamos a recorrer los COMPLEJOS
                                //Rows para las interfaces
                                let rowCoOb = 0; //Obligatorio
                                let rowCoRe = 0; //Recomendado
                                let rowCoOp = 0; //Opcional
                                //Usamos una bandera para saber si es el primer hijo o no
                                let bandera;
                                //
                                //Recorremos los tags obligatorios
                                for(let j=0;j<tagcomplejoOb.length;j++){               
                                    bandera=0 //Por cada tag complejo inicializamos la bandera en 0
                                    for(let i=0;i<res.response.length;i++){ 
                                        //Recorremos todos los tags que nos devolvio el servidor                                                                        
                                        if(tagcomplejoOb[j]==res.response[i].id_tag){ //Si el id_tag coincide                                  
                                            if(rowCoOb==0){ 
                                                //Si es una nueva linea o si es la primera
                                                //creamos una nueva row
                                                if (bandera==0){
                                                    //Es el primer hijo
                                                    //Al ser el primer hijo también creamos el nombre del padre
                                                    let texto = document.createElement("p");
                                                    texto.innerHTML=res.response[i].descripcion
                                                    texto.className = 'complejos';
                                                    containerOb.appendChild(texto);     
                                                    }
                                                var divmayorOb=document.createElement("div");                                        
                                                divmayorOb.className = "row";                                                
                                                containerOb.appendChild(divmayorOb)           
                                            }
                                            if (bandera==0){                 
                                                var contaComplejo = contadorComplejo(res.response[i].deschijo, res.response[i+1].deschijo);                                
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                var divmedioOb = document.createElement("div")
                                                divmedioOb.className = "col-lg-12 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                     var idinput1 = crearInputSimple(divmedioOb, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                     var idinput1 = crearSelect(divmedioOb, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                     var idinput1 = crearSemiSelect(divmedioOb, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                     
                                                }                          
                                                divmayorOb.appendChild(divmedioOb); 
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{       
                                                //let divmedioOb = document.createElement("div")
                                                //divmedioOb.className = "col-lg-6 col-md-12 row"                                          
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    var idinput2 = crearInputSimple(divmedioOb, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    var idinput2 = crearSelect(divmedioOb, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    var idinput2 = crearSemiSelect(divmedioOb, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                     
                                                }      
                                                divmayorOb.appendChild(divmedioOb); 
                                                cargarDatosComplejos(contaComplejo, idinput1, idinput2, res.response[i-1].deschijo, res.response[i].deschijo)
                                            }
                                           
                                            rowCoOb+=6;  
                                            if(rowCoOb==12){   
                                                //Es el ultimo elemento permitido y se reinicializa la fila                                    
                                                rowCoOb=0
                                            }                                              
                                        }
                                    }
                                }
                                //Recorremos los tags recomendados   
                                for(let j=0;j<tagcomplejoRe.length;j++){
                                    bandera=0   //bandera de primer hijo
                                    for(let i=0;i<res.response.length;i++){   //recorremos todos los tags que nos devolvió la bd                                                                            
                                        if(tagcomplejoRe[j]==res.response[i].id_tag){ //Si el id_tag coincide
                                            if(rowCoRe==0){ 
                                                //Si es una nueva linea o si es la primera
                                                //creamos una nueva row
                                                if (bandera==0){
                                                    //Es el primer hijo
                                                    //Al ser el primer hijo también creamos el nombre del padre
                                                    let texto = document.createElement("h6");
                                                    texto.innerHTML=res.response[i].descripcion
                                                    texto.className = 'complejos';
                                                    containerRe.appendChild(texto);                                                 
                                                    }
                                                var divmayorRe=document.createElement("div");                                        
                                                divmayorRe.className = "row";                                                
                                                containerRe.appendChild(divmayorRe)
                                            }
                                            if (bandera==0){          
                                                var contaComplejo = contadorComplejo(res.response[i].deschijo, res.response[i+1].deschijo);
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                var divmedioRe = document.createElement("div")
                                                divmedioRe.className = "col-lg-12 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    var idinput1 = crearInputSimple(divmedioRe, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    var idinput1 = crearSelect(divmedioRe, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    var idinput1 = crearSemiSelect(divmedioRe, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                     
                                                } 
                                                divmayorRe.appendChild(divmedioRe); 
                                                rowCoRe+=6;  
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{        
                                                //let divmedioRe = document.createElement("div")
                                                //divmedioRe.className = "col-lg-6 col-md-12 row"                                           
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    var idinput2 = crearInputSimple(divmedioRe, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    var idinput2 = crearSelect(divmedioRe, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    var idinput2 = crearSemiSelect(divmedioRe, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                     
                                                } 
                                                divmayorRe.appendChild(divmedioRe); 
                                                rowCoRe+=6;     
                                                cargarDatosComplejos(contaComplejo, idinput1, idinput2, res.response[i-1].deschijo, res.response[i].deschijo)
                                            }
                                           
                                            if(rowCoRe==12){   
                                                //Es el ultimo elemento permitido y se reinicializa la fila                                    
                                                rowCoRe=0
                                            }                                                       
                                        }
                                    }
                                }  
                                //Recorremos los tags opcionales
                                for(let j=0;j<tagcomplejoOp.length;j++){
                                    bandera=0 //bandera de primer hijo
                                    for(let i=0;i<res.response.length;i++){  //recorremos todos los tags que nos devolvió la bd                                       
                                        if(tagcomplejoOp[j]==res.response[i].id_tag){ //si los id_tag coinciden                                  
                                            if(rowCoOp==0){ 
                                                //Si es una nueva linea o si es la primera
                                                //creamos una nueva row
                                                if (bandera==0){
                                                //Es el primer hijo
                                                //Al ser el primer hijo también creamos el nombre del padre
                                                                                        
                                                }
                                                var divmayorOp=document.createElement("div");                                        
                                                divmayorOp.className = "row";                                                
                                                containerOp.appendChild(divmayorOp)
                                            }
                                            if (bandera==0){
                                                var contaComplejo = contadorComplejo(res.response[i].deschijo, res.response[i+1].deschijo);
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                var divmedioOp = document.createElement("div")
                                                divmedioOp.className = "col-lg-12 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    var idinput1 = crearInputSimple(divmedioOp, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    var idinput1 = crearSelect(divmedioOp, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    var idinput1 = crearSemiSelect(divmedioOp, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                    
                                                } 
                                                divmayorOp.appendChild(divmedioOp); 
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{       
                                                //let divmedioOp = document.createElement("div")
                                                //divmedioOp.className = "col-lg-6 col-md-12 row"                                           
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    var idinput2 = crearInputSimple(divmedioOp, res.response[i].dato_tipo, res.response[i].deschijo, 2, i, contaComplejo)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    var idinput2 = crearSelect(divmedioOp, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i, contaComplejo) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    var idinput2 = crearSemiSelect(divmedioOp, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i, contaComplejo) 
                                                     
                                                }    
                                                divmayorOp.appendChild(divmedioOp); 
                                                cargarDatosComplejos(contaComplejo, idinput1, idinput2, res.response[i-1].deschijo, res.response[i].deschijo)
                                            }                                           
                                            rowCoOp+=6;  
                                            if(rowCoOp==12){   
                                                //Es el ultimo elemento permitido y se reinicializa la fila     
                                                rowCoOp=0
                                            }                                                                                                    
                                        }      
                                    } 
                                }   
                                
                                
                            },
                            error: function (res) {
                                alert("No se pudieron recuperar los tags complejos");
                                console.log(res)
                            }});  
                            
                        },
                    error: function(res){
                        alert("No se pudieron recuperar los tags");
                        console.log(res)
                    }});
                    //ESTO PUEDE SER UNA FUNCION
                if(document.getElementById('borrar').checked){ //Si seleccionamos borrar
                    mostrarPagina(3)      
                }
                else if(document.getElementById('guardar').checked){ //Si seleccionamos guardar
                    mostrarPagina(1)
                }
                else{
                    mostrarPagina(2)
                }   
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
            //alert(res);
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });

}

function contadorSimple(nombre){
    console.log(nombre)
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
    console.log(contador)
    return contador;
}

function contadorComplejo(tag1, tag2){
    let contador=0;
    let band=0;
    complejos.forEach(complejo => {
        if(complejo.tag1 == tag1 && complejo.tag2 == tag2){
            band=1;
            complejo.cont+=1;
            contador = complejo.cont;
        }
    });
    if(band == 0){
        let co = new complejo(tag1, tag2);
        complejos.push(co);
    }
    return contador;
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
            guardarTag(input.id, nombre, 1, contador);
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
    input.setAttribute('onchange', 'guardarTag(\''+ input.id + '\',\'' + nombre + '\',' + 1 + ',' + contador + ')')
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
        }
    });   
    //input.setAttribute('onchange', 'guardarTag(\''+ input.id + '\',\'' + nombre + '\')')
    input.setAttribute('oninput', 'guardarTag(\''+ input.id + '\',\'' + nombre + '\',' + 1 + ',' + contador + ')')
    
    if(medida != 1){
        input.setAttribute('onchange', 'derivado('+ i + ',' + id + ')');
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
            tagname = document.getElementById(lab).innerHTML  
            let contador=0;
            elementos.forEach(elemento => {
                if(elemento.tag==tagname){
                    contador = elemento.cont;
                }
            });      
            guardarTag(hijo.id, tagname, 1, contador)
        },
        error: function(res){
            console.log(res)
        }});

}

function mostrarPagina(tipo){
    //TIPO 1: AGREGAR
    //TIPO 2: MODIFICAR
    //TIPO 3: BORRAR

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
    console.log(conta)
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
    console.log(conta + ' ' + tag1 + ' ' + tag2)
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
    const tipo = document.getElementById('tipo');
    const subtipo = document.getElementById('subtipo');
    const fecha = document.getElementById('fecha');
    const doc = document.getElementById('doc');

    const borrarBtn = document.getElementById('borrar');
    const modificarBtn = document.getElementById('modificar');
    const guardarBtn = document.getElementById('guardar');

    const checkEnableButton = () => {    
        if(tipo.value!='sel' && subtipo.value!='sel' && fecha.value != '' && doc.value!= ''){
            borrarBtn.removeAttribute('disabled');
            modificarBtn.removeAttribute('disabled');
            guardarBtn.removeAttribute('disabled');            
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
            btn.setAttribute('onclick','guardarTag(\'' + 'agregarTag' + '\',\'' + tag.descripcion + '\',' + 2 + ')');
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

function guardarTag(idinput, tagname, tipo, cont){

    let input = document.getElementById(idinput).value;
    let claves = document.getElementById('claves');
    let ac=-1;

    if(tipo == 1){
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
                        }
                    } 
                    comienza = 1;
                    if(band == 0){
                        ac++;
                        if(ac == cont){
                            first = i-1; 
                            guardado = 1;
                        }              
                    }
                }
                if(claves.value[i] == '>'){
                    if(comienza == 1 && band == 0 && ac==cont){
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
        
        /* if(claves.value.indexOf('<'+tagname+':')!= -1){
            let first = claves.value.indexOf('<'+tagname+':');
            let last = -1;
            let band = 0;
            for(let i=first; i<claves.value.length; i++){
                if(band == 0){
                    if(claves.value[i] == '>'){
                        last=i;
                        band= 1;
                    }
                }
            }
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
        }     */
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

function borrar(){ 
    let subtipo = document.getElementById('subtipo').value;
    let doc = document.getElementById('doc').value;
    let fecha = document.getElementById('fecha').value;
    let orden = document.getElementById('orden').value;

    let route = '/archivo/borrar';    
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
            tipo: subtipo,
            doc: doc,
            fecha: fecha,
            orden: orden
        }),
        dataType: 'json',
        success: function(res) {
            console.log(res)
        },
        error: function(res){
            console.log(res)
    }});
}

function modificar() { 
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
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            tipo: subtipo,
            doc: doc,
            fecha: fecha,
            claves: claves,
            orden: orden
        }),
        dataType: 'json',
        success: function(res) {
            console.log(res)
        },
        error: function(res){
            console.log(res)
    }});
}

function guardar(){
    let subtipo = document.getElementById('subtipo').value;
    let doc = document.getElementById('doc').value;
    let fecha = document.getElementById('fecha').value;
    let claves = document.getElementById('claves').value;
    let orden = document.getElementById('orden').value;

    let route = '/archivo/crear';    
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
            tipo: subtipo,
            doc: doc,
            fecha: fecha,
            claves: claves,
            orden: orden
        }),
        dataType: 'json',
        success: function(res) {
            console.log(res)
        },
        error: function(res){
            console.log(res)
    }});
}