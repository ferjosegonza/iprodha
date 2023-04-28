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
                let tipoId = tipoId + document.getElementById('tipo').value[i].toString(); 
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
                    document.getElementById('linkpdf').innerHTML = res.response.nombre_archivo;
                    document.getElementById('pdfver').removeAttribute("hidden");
                    document.getElementById('pdfver').setAttribute('data', path);
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
                        console.log(res)        
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
                                                                           
                                        crearInputSimple(divmayorOb, res.response[i].dato_tipo, res.response[i].descripcion, 1, i)                      
                                    }
                                    else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                        crearSelect(divmayorOb, res.response[i].id_tag, res.response[i].descripcion, 1,i) 
                                         
                                    }
                                    else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                        crearSemiSelect(divmayorOb, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1, i) 
                                         
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
                                           crearInputSimple(divmayorRe, res.response[i].dato_tipo, res.response[i].descripcion, 1, i)                                       
                                             

                                        }
                                        else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                            crearSelect(divmayorRe, res.response[i].id_tag, res.response[i].descripcion, 1, i)
                                        }  
                                        else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                           crearSemiSelect(divmayorRe, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1,i) 
                                             
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
                                       crearInputSimple(divmayorOp, res.response[i].dato_tipo, res.response[i].descripcion, 1, i)                                       
                                          
                                    }
                                    else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                        crearSelect(divmayorOp, res.response[i].id_tag, res.response[i].descripcion, 1,i) 
                                     }
                                    else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                      crearSemiSelect(divmayorOp, res.response[i].dato_tipo,res.response[i].id_tag, res.response[i].descripcion, 1, i)
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
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                let divmedioOb = document.createElement("div")
                                                divmedioOb.className = "col-lg-6 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                     crearInputSimple(divmedioOb, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                     crearSelect(divmedioOb, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                     crearSemiSelect(divmedioOb, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                     
                                                }                          
                                                divmayorOb.appendChild(divmedioOb); 
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{       
                                                let divmedioOb = document.createElement("div")
                                                divmedioOb.className = "col-lg-6 col-md-12 row"                                          
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    crearInputSimple(divmedioOb, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    crearSelect(divmedioOb, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    crearSemiSelect(divmedioOb, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                     
                                                }      
                                                divmayorOb.appendChild(divmedioOb); 
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
                                                
                                                 
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                let divmedioRe = document.createElement("div")
                                                divmedioRe.className = "col-lg-6 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    crearInputSimple(divmedioRe, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    crearSelect(divmedioRe, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    crearSemiSelect(divmedioRe, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                     
                                                } 
                                                divmayorRe.appendChild(divmedioRe); 
                                                rowCoRe+=6;  
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{        
                                                let divmedioRe = document.createElement("div")
                                                divmedioRe.className = "col-lg-6 col-md-12 row"                                           
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    crearInputSimple(divmedioRe, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    crearSelect(divmedioRe, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    crearSemiSelect(divmedioRe, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                     
                                                } 
                                                divmayorRe.appendChild(divmedioRe); 
                                                rowCoRe+=6;     
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
                                                let texto = document.createElement("h6");
                                                texto.innerHTML=res.response[i].descripcion
                                                texto.className = 'complejos';
                                                containerOp.appendChild(texto);                                                 
                                                }
                                                var divmayorOp=document.createElement("div");                                        
                                                divmayorOp.className = "row";                                                
                                                containerOp.appendChild(divmayorOp)
                                            }
                                            if (bandera==0){
                                                
                                                //Como hay 2 inputs por complejo, creamos otro div que los contenga
                                                let divmedioOp = document.createElement("div")
                                                divmedioOp.className = "col-lg-6 col-md-12 row"   
                                                //
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    crearInputSimple(divmedioOp, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    crearSelect(divmedioOp, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    crearSemiSelect(divmedioOp, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                    
                                                } 
                                                divmayorOp.appendChild(divmedioOp); 
                                                bandera=1; //Ya no es el primer hijo
                                            }
                                            else{       
                                                let divmedioOp = document.createElement("div")
                                                divmedioOp.className = "col-lg-6 col-md-12 row"                                           
                                                if(res.response[i].dato == 1){//Si el dato es tipeado                                        
                                                    crearInputSimple(divmedioOp, res.response[i].dato_tipo, res.response[i].deschijo, 2, i)                                       
                                                     
                                                }
                                                else if(res.response[i].dato == 2){//Si el dato se busca en la BD
                                                    crearSelect(divmedioOp, res.response[i].id_tag_hijo, res.response[i].deschijo,2,i) 
                                                     
                                                }  
                                                else if(res.response[i].dato == 3){//Si el dato se busca en la BD despues de tipearlo
                                                    crearSemiSelect(divmedioOp, res.response[i].dato_tipo, res.response[i].id_tag_hijo, res.response[i].deschijo, 2, i) 
                                                     
                                                }    
                                                divmayorOp.appendChild(divmedioOp); 
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
                console.log("mostrar")
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

function crearInputSimple(padre, dato, nombre, medida, i){
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
    input.className = 'form-control'; //Formato
    if(medida==1){
        input.name = 'input' + i;
        input.id = 'input' + i;
    }
    else{
        input.name = 'hijo' + i;
        input.id = 'hijo' + i;
    }    
    if(cargarDatos(nombre) == 'No asignado')
    {
        input.placeholder = cargarDatos(nombre)
    }
    else{
        input.value = cargarDatos(nombre)
    }
    divmenor.appendChild(input);
    padre.appendChild(divmenor)
}

function crearSelect(padre, id, nombre, medida, i){   
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
    if(cargarDatos(nombre) == 'No asignado')
    {
        input.placeholder = cargarDatos(nombre)
    }
    else{
        console.log(cargarDatos(nombre))
        input.placeholder = cargarDatos(nombre)
        input.value = cargarDatos(nombre)
    }
    divmenor.appendChild(input);
    padre.appendChild(divmenor)
    return(input.id)
}

function crearSemiSelect(padre, dato, id, nombre, medida, i){
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
    console.log(input)
    if(dato == 1){//Si el dato es numérico                                     
      input.type = "number";
      input.className="no-spin"
    }
    else{//Si el tipo de dato es texto
        input.type = "text";
    }                                        
    console.log(input)
    input.className = 'form-control'; //
    console.log(input)
    if(medida==1){
        input.name = 'input' + i;
        input.id = 'input' + i;
    }
    else{
        input.name = 'hijo' + i;
        input.id = 'hijo' + i;
    }
    console.log(input)
    input.setAttribute('list', "opciones"+i);
    input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          findTexto(input.value, id, input, "opciones"+i);
        }
    });
    if(cargarDatos(nombre) == 'No asignado')
    {
        input.placeholder = cargarDatos(nombre)
    }
    else{
        input.value = cargarDatos(nombre)
    }
    divmenor.appendChild(input);
    padre.appendChild(divmenor)
    return(input.id)
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
            document.getElementById('agregar').removeAttribute("hidden");
        }
        else{
            document.getElementById('div-btnmodificar').removeAttribute("hidden"); 
            document.getElementById('div-btnborrar').hidden=true;
            document.getElementById('div-btnguardar').hidden=true;
        }
    }
}

function cargarDatos(tag){
    let tags=[];
    let info=[];
    let cont=0;
    let band=0;
    let claves = document.getElementById('claves').value;
    console.log(claves)
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
    console.log(tags.length)
    for(let i=0; i<tags.length; i++){
        if(tags[i] == tag)
        {
            return info[i]
        }
    }
    return ("No asignado")
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
    //sigue
}

function agregarTag(){
    var cont=0;
    let idtag = document.getElementById('tag').value;
    let tag = obtenerTagFormato(idtag);
    let div = document.getElementById('tag-agregar');
    let div2 = document.createElement("div");    
    if(tag.length>1){
        
    }
    else{
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
        }
        if(tag.dato == 2){
            let input = document.createElement("select");
            getSelects(input, tag.id)
        }
        if(tag.dato == 3){
            let input = document.createElement("input");
            if(dato == 1){                               
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
        }
        div2.className = "col-lg-12";
        div2.appendChild(input)        
    }
    div.appendChild(div2);
}

function obtenerTagFormato(id){
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
            texto: texto,
            id: id
        }),
        dataType: 'json',
        success: function(res) {
            return res
        },
        error: function(res){
            console.log(res)
        }});
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
            for(i=0;i<res.length;i++){
                let option = document.createElement("option");
                option.value = res[i].campo1;
                option.text = res[i].campo1;
                padre.appendChild(option);
            }
            return res;
        },
        error: function(res){
            console.log(res)
        }});
}