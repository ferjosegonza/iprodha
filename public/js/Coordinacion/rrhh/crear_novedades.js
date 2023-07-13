function tipos(){
    if(document.getElementById('tipo').value == 'sel'){
        document.getElementById('subtipo').hidden = true;
        document.getElementById('placeholder').hidden = false;        
        document.getElementById('subtipo').value = "sel"
        let table = $('#archivos').DataTable()
        table
        .columns( '.tipo' ).search("").draw()
        .columns( '.sub' ).search("").draw();

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
        let table = $('#archivos').DataTable()
        table
        .columns( '.tipo' ).search(tipoNombre).draw()
        .columns( '.sub' ).search("").draw();
        
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
        var table = $('#archivos').DataTable()
        table
        .columns( '.sub' ).search("").draw();
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
    if(subtipoNombre != 'sel'){
        table
        .columns( '.sub' ).search(subtipoNombre).draw();
    }
    else{
        table
        .columns( '.sub' ).search("").draw();
    }
    }
}

function documento(){
    document.getElementById('documento').removeAttribute('hidden')
}

function mostrarCrear(){
    document.getElementById('crear').removeAttribute('hidden')
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

    $('#archivos').DataTable({
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
                    tr.innerHTML = '<td>'+res[i].nro_archivo+'</td><td>'+res[i].nombre_archivo+'</td><td>'+res[i].claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;')+'</td>'
                    tr.setAttribute('onclick', 'openPreview("'+ res[i].id_archivo + '", "' + res[i].path_archivo.replaceAll('\\','\\\\') + ' ", "' + res[i].nombre_archivo + '")')
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

function openPreview(id, path, nombre){
    console.log(path)
    console.log(nombre)
    document.getElementById('elegirArchivo').classList.remove('col-lg-12')
    document.getElementById('elegirArchivo').classList.add('col-lg-6')
    document.getElementById('pdfembed').setAttribute('src', path.slice(14)+nombre)
    document.getElementById('title-preview').innerHTML = nombre
    document.getElementById('previewpdf').removeAttribute('hidden')
    document.getElementById('btn-preview').setAttribute('onclick', 'guardarAvalatorio("' + id + '", "' + nombre +'")')
}

function guardarAvalatorio(id, nombre){
    document.getElementById('docsasociados').removeAttribute('hidden')
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>' + nombre +'</td><td><i class="fas fa-trash-alt" style="color: #ff0000;"></i></td><td hidden>' + id +'</td>'
    document.getElementById('infoasociados').appendChild(tr)
}