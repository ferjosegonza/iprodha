var pagina

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
                     //console.log("Hay " + subtipo.options[i].value.length + " caracteres en: " + subtipo.options[i].value)
                    bandera=0;
                    for(j=0; j<subtipo.options[i].value.length; j++){       
                        //console.log("Recorriendo el caracter nro " + j)             
                        if (bandera==0){
                            console.log("La bandera es 0")    
                            if(j==0){
                                //console.log("J es 0")                            
                                subtid = subtipo.options[i].value[j].toString();
                                //console.log("subtid: " + subtid)
                            }
                            else{
                                //console.log("J es " + j)
                                if(isNaN(subtipo.options[i].value[j])){
                                    //console.log("El valor de subtipo no es un nro: " + subtipo.options[i].value[j])
                                    bandera=1;
                                    //console.log("Es el subtid: " + subtid + " igual al tipoid: "+tipoId+ "?")
                                    if(subtid == tipoId)
                                    {
                                        //console.log("Si")
                                        subtipo.options[i].hidden = false
                                    }
                                    else{
                                        //console.log("No")
                                        subtipo.options[i].hidden = true                                    
                                    }
                                    //console.log("Resultado: " + subtid)
                                    subtid=""
                                }
                                else{
                                    subtid = subtid + subtipo.options[i].value[j].toString();
                                    //console.log("subtid: " + subtid)
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
        //console.log("Hay " + subtipo.options.length + " subitems")
        
        
    }
}    

function year(){
    if(document.getElementById('año').value == "sel"){
       // $( "#archivos" ).DataTable().ajax.reload()
       var table = $('#archivos').DataTable()
       table
       .columns( '.fecha' ).search("").draw();
    }
    else{
        var year = document.getElementById('año').value; 
        console.log(year);
        var table = $('#archivos').DataTable()
        table
            .columns( '.fecha' ).search(year).draw();
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
                console.log(subtipo)                
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
    console.log(subtipoNombre);
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

function create(){
$(document).ready(function () {
if ($.fn.DataTable.isDataTable('#archivos')) {
    $('#archivos').DataTable().destroy();
}
$('#archivos tbody').empty();
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $("#archivos").dataTable().fnDestroy();
        $('#archivos thead tr').clone(true).addClass('filters').appendTo( '#archivos thead' );
        var table = $('#archivos').DataTable({      
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function() {
                
                var api = this.api();
                // For each column
                api.columns().eq(0).each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();
                    $(cell).html( '<input type="text" placeholder="'+title+'" />' );
                    // On every keypress in this input
                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()) )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search((this.value))
                                .draw();
                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        });
                    });
                },
    
    
    
                "bSort":false,
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'No se han encontrado registros',
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'No se han encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
                "bDestroy": true
            },
            order: [[ 1, 'asc' ]],
            
        });    
});   
});
}

function betweenyears(){
    var fecha1 = document.getElementById("fecha1");
    var fecha2 = document.getElementById("fecha2");
    var table = $('#archivos').DataTable();
    if (fecha1 == null && fecha2 !=null){
        table
        .columns('.fecha').search(fecha2.value).draw();
    }
}

function tags(){
    let tag = document.getElementById('tag').value;      
    if (tag.value != 'sel')
    {
        let idtag = document.getElementById('tag').value[0];
        let bandera= 0;  
        for(i = 1; i < tag.length; i++){ 
        if (bandera==0)
        {
            if(isNaN(document.getElementById('tag').value[i]))
            {                    
                if(document.getElementById('tag').value[i] != '|')
                {
                    bandera =1;
                }      
            }
            else{
                idtag = idtag + document.getElementById('tag').value[i].toString(); 
            }
        }
   
        let route = '/archivo/tag';   

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        return $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            data: ({
                _token: $('#signup-token').val(),
                id: idtag
            }),
            dataType: 'json',
            success: function(tag) {
                console.log(tag)
                let div = document.getElementById('tag-comp');
                while(div.hasChildNodes()){
                    div.removeChild(div.lastChild)
                }
                let div2 = document.createElement("div");    
                let lab = document.createElement('label');
                document.getElementById('inp-tag').removeAttribute('hidden');
                document.getElementById('placeholder-tag').hidden = true;
                lab.innerHTML = tag.descripcion;
                div2.appendChild(lab);
                let input;
                if(tag.dato == 1){
                    input = document.createElement('input')
                    if(tag.dato_tipo == 1){
                        input.type = "number"
                        input.className="no-spin"
                    }
                    else{
                        input.type = "text"
                    }
                    input.className = "form-control"
                    input.addEventListener('keyup', checkEnableButton)
                }
                if(tag.dato == 2){
                    input = document.createElement("select");
                    input.className="form-select"
                    getSelects(input, tag.id_tag)
                    input.addEventListener('change', checkEnableButton)
                }
                if(tag.dato == 3){
                    input = document.createElement("input");
                    if(tag.dato_tipo == 1){                               
                    input.type = "number";
                    input.className="no-spin"
                    }
                    else{
                        input.type = "text";
                    }   
                    input.className = "form-control"                   
                    input.setAttribute('list', "opciones");
                    input.addEventListener('keyup', function (e) {
                        if (e.key === 'Enter') {
                            console.log("Enter")
                        findTexto(input.value, tag.id_tag, input, "opciones");
                        }
                    });
                    input.addEventListener('change', checkEnableButton)
                }
                input.setAttribute('name','input_tag');
                input.id= 'input_tag'
                input.name= 'input_tag'
                div2.className = "col-lg-12";
                div2.appendChild(input);
                div.appendChild(div2);
                
            },
            error: function(res){
                console.log(res)
            }});
        }
    }
    else{
        while(document.getElementById('inp_tag').hasChildNodes()){
            document.getElementById('inp_tag').removeChild(document.getElementById('inp_tag').lastChild)
        }
        document.getElementById('inp_tag').hidden = true;
        document.getElementById('placeholder-tag').removeAttribute('hidden');
    }
    
    
}

$(document).ready(function () {
     //create();
    // Setup - add a text input to each footer cell
    $('#archivos thead tr').clone(true).addClass('filters').appendTo( '#archivos thead' );
    var table = $('#archivos').DataTable({      
        orderCellsTop: true,
        fixedHeader: true,
        columnDefs: [
            {
                target: 7,
                visible: false
            },
            {
                target: 6,
                visible: false,
            },
            {
                target: 8,
                visible: false,
            },
        ],
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No se han encontrado registros',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'No se han encontrado registros',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            paginate:{
                first:"Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },

        initComplete: function() {
            var api = this.api();
            // For each column
            api.columns(":not(:first-child)").eq(0).each(function(colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                var title = $(cell).text();
                $(cell).html( '<input type="text" placeholder="'+title+'" />' );
                // On every keypress in this input
                $('input', $('.filters th').eq($(api.column(colIdx).header()).index()) )
                    .off('keyup change')
                    .on('keyup change', function (e) {
                        e.stopPropagation();
                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})'; //$(this).parents('th').find('select').val();
                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search((this.value))
                            .draw();
                        $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                    });
                });
            },



            
        
    });   
    $('#archivos tbody').on('click', 'tr', function () {
        pagina = table.page();
        let data = table.row(this).data();
        console.log(data)
        table.columns( '.sub' ).search(data[2]).draw();
        table.columns( '.tipo' ).search(data[1]).draw();
        table.columns( '.nro' ).search(data[4]).draw();
        table.columns( '.fecha' ).search(data[3]).draw();
        table.columns( '.orden' ).search(data[7]).draw();
        //table.columns( '.asun' ).search(data[5].replaceAll('&lt;','<').replaceAll('&gt;','>')).draw();

        document.getElementById('preview').hidden = false
        document.getElementById('pdfver').setAttribute('data', data[6])
        document.getElementById('linkpdf').setAttribute('href', data[6])
        document.getElementById('pdftitle').innerHTML= data[1] + ' - ' + data[2] + ' - ' + data[4]

        if(data[1] == 'RESOLUCIONES'){
            tieneDigesto(data[8], data)
        }
        else{
            document.getElementById('despdf').innerHTML=  '<b>FECHA:</b> ' + data[3]+ '<br><b>ASUNTOS CLAVES:</b><br>' + data[5]
        }
        

        
        //document.getElementById('ruta').innerHTML= data[6]
        //alert('You clicked on ' + data[6] + "'s row");
    });
    
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });

});


function tieneDigesto(id, data){
    let route = 'digesto/check'
    console.log(id)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        async: false,
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
            if(res){
                document.getElementById('despdf').innerHTML=  '<a href="/digesto/modificaciones?id='+ data[8] +'">Esta resolucion tiene modificaciones</a><br><b>FECHA:</b> ' + data[3]+ '<br><b>ASUNTOS CLAVES:</b><br>' + data[5]
            }else{
                document.getElementById('despdf').innerHTML=  '<b>FECHA:</b> ' + data[3]+ '<br><b>ASUNTOS CLAVES:</b><br>' + data[5]
            }
        }})
}

function cancelarbusqueda(){
    let table = $('#archivos').DataTable()
    //console.log(document.getElementById('tipo').value)
    if(document.getElementById('tipo').value == 'sel'){
        table
        .columns( '.tipo' ).search("").draw()
        .columns( '.sub' ).search("").draw();
        //console.log("no hay tipo")
    }
    else{
        let tipo = document.getElementById('tipo').value; 
        let tipoNombre;
        let bandera= 0;        
        for(i = 1; i < tipo.length; i++){ 
            if (bandera==0)
            {
                if(isNaN(document.getElementById('tipo').value[i]))
                {
                    tipoNombre = document.getElementById('tipo').value[i+1];  
                    bandera =1;
                    i=i+1;
                }
            }
            else{
                tipoNombre = tipoNombre + document.getElementById('tipo').value[i];}  
            }
            console.log(tipoNombre)
        table
            .columns( '.tipo' ).search(tipoNombre).draw();
        if (document.getElementById('subtipo').value == 'sel'){
            table
            .columns( '.sub' ).search("").draw();
        }
        else{
            let subtipo = document.getElementById('subtipo').value; 
            let subtipoNombre;
            let bandera= 0;   
            let bandera2 = 0;      
            for(i = 0; i < subtipo.length; i++){ 
                if (bandera==0)
                {
                    if(isNaN(document.getElementById('subtipo').value[i]))
                    {
                        console.log(subtipo)                
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
                table
                .columns( '.sub' ).search(subtipoNombre).draw();
        }
    }
    table.columns( '.nro' ).search("").draw();    
    if(document.getElementById('año').value == "sel"){
        table.columns( '.fecha' ).search("").draw();
    }
    else{
        let year = document.getElementById('año').value; 
        console.log(year)
        table.columns( '.fecha' ).search(year).draw();
    }  
    document.getElementById('preview').hidden = true
    table.page(pagina).draw(false)
}

function toggle() {
    let year = document.getElementById("yearIn");
    let date = document.getElementById("dateIn");
    if (year.hidden == true) {
        year.hidden=false
        date.hidden=true
        document.getElementById("yearIn").value = 'sel'
        document.getElementById('labelswitch').innerHTML="Elegir entre fechas"
    } else {       
        year.hidden=true
        date.hidden=false
        document.getElementById('labelswitch').innerHTML="Elegir año"
    }
}

function checkEnableButton(){
    const submitBtn = document.getElementById('btnb')
    let año = document.getElementById('año')
    let tipo = document.getElementById('tipo')
    let  busqueda = document.getElementById('busq')
    let fecha1 = document.getElementById('min')
    let fecha2 = document.getElementById('max')
    let tag_sel = document.getElementById('tag')
    let check = document.getElementById('betwenyears')

    if(check.checked){
        if(tag_sel.value != 'sel'){
            let tag = document.getElementById('input_tag')
            if(fecha1.value != '' && tipo.value != 'sel' 
            || fecha2.value != '' && tipo.value != 'sel' || busqueda.value != '' 
            || tag.value != 'sel' && tag.value != ''){
                submitBtn.removeAttribute('disabled')
                submitBtn.classList.remove("btn-secondary"); 
                submitBtn.classList.add("btn-success"); 
            }
            else{
                submitBtn.setAttribute('disabled', 'disabled')
                submitBtn.classList.remove("btn-success"); 
                submitBtn.classList.add("btn-secondary"); 
            }   
        }
        else{
            if(año.value!= 'sel' && tipo.value != 'sel' ||  fecha1.value != '' && tipo.value != 'sel' 
            || fecha2.value != '' && tipo.value != 'sel' || busqueda.value != ''){
                submitBtn.removeAttribute('disabled')
                submitBtn.classList.remove("btn-secondary"); 
                submitBtn.classList.add("btn-success"); 
            }
            else{
                submitBtn.setAttribute('disabled', 'disabled')
                submitBtn.classList.remove("btn-success"); 
                submitBtn.classList.add("btn-secondary"); 
            }   
        }
    }
    else{
        if(tag_sel.value != 'sel'){
            let tag = document.getElementById('input_tag')
            if(año.value!= 'sel' && tipo.value != 'sel' 
            || busqueda.value != '' || tag.value != 'sel' && tag.value != ''){
                submitBtn.removeAttribute('disabled')
                submitBtn.classList.remove("btn-secondary"); 
                submitBtn.classList.add("btn-success"); 
            }
            else{
                submitBtn.setAttribute('disabled', 'disabled')
                submitBtn.classList.remove("btn-success"); 
                submitBtn.classList.add("btn-secondary"); 
            }   
        }
        else{
            if(año.value!= 'sel' && tipo.value != 'sel' || busqueda.value != ''){
                submitBtn.removeAttribute('disabled')
                submitBtn.classList.remove("btn-secondary"); 
                submitBtn.classList.add("btn-success"); 
            }
            else{
                submitBtn.setAttribute('disabled', 'disabled')
                submitBtn.classList.remove("btn-success"); 
                submitBtn.classList.add("btn-secondary"); 
            }   
        }
    }
}

window.addEventListener("DOMContentLoaded", (event) => {
    const submitBtn = document.getElementById('btnb')
    let año = document.getElementById('año')
    let tipo = document.getElementById('tipo')
    let  busqueda = document.getElementById('busq')
    let fecha1 = document.getElementById('min')
    let fecha2 = document.getElementById('max')
    let tag_sel = document.getElementById('tag')
    let tag = document.getElementById('input_tag')

    const checkInput = () => {
        if(tag_sel.value != 'sel'){
            $.when(tags()).done(function(a1){            
                var tag = document.getElementById('input_tag');
                if(tag.nodeName == 'select'){
                    tag.addEventListener('change', checkEnableButton)
                }
                else{
                    tag.addEventListener('keyup', checkEnableButton)
                }
                
            });        
        }
        else{
            document.getElementById('inp-tag').setAttribute('hidden', 'hidden')
            document.getElementById('placeholder-tag').removeAttribute('hidden')
        }
    }

    if(fecha1){fecha1.addEventListener('change', checkEnableButton)}
    if(fecha2){fecha2.addEventListener('change', checkEnableButton)}
    año.addEventListener('change', checkEnableButton)
    tipo.addEventListener('change', checkEnableButton)
    busqueda.addEventListener('keyup', checkEnableButton)
    tag_sel.addEventListener('change', checkInput)


});

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

function getSelects(padre, id){
    console.log(id)
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
        },
        error: function(res){
            console.log(res)
        }});
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

function agregarTag(){
    let input = document.getElementById('input_tag').value;
    let sel = document.getElementById('tag');
    console.log(sel.value)
    let tag = sel.options[sel.selectedIndex].text
    let acumulado = document.getElementById('tag-acumulado');
    acumulado.value = acumulado.value + '|' + '<' + tag + ':' + input + '>';    
    console.log(acumulado.value);
    let añadidas = document.getElementById('tags-añadidos');
    añadidas.removeAttribute('hidden'); 
    filtro = document.createElement('div');
    filtro.className = "btn btn-secondary col-lg-3 col-md-3 col-sm-3 col-xs-3 filtro";
    filtro.id = '&lt' + tag + ':' + input + '&gt'
    filtro.innerHTML=  '&lt' + tag + ':' + input + '&gt' + '<a class="cancelarFiltro" onclick="removeFiltro(\''+ tag + '\', \'' +input +'\')">X</a>'
    console.log(filtro)
    añadidas.appendChild(filtro)
}

function removeFiltro(tag, input){
    document.getElementById('&lt' + tag + ':' + input + '&gt').remove();
    let  acumulado = document.getElementById('tag-acumulado');
    let string= '<'+tag+':'+input+'>'
    for(let i = 0; i<acumulado.value.length; i++){
        if(acumulado.value[i] == '<'){
            let bandera=0
            for(let j=0; j<string.length; j++){
                if(acumulado.value[i+j] != string[j]){
                    console.log(acumulado.value[i+j],string[j])
                    bandera=1;
                }
            }
            if (bandera==0){
                    let ac = acumulado.value
                    console.log(ac)              
                    let str = '|<'+tag+':'+input+'>'
                    acumulado.value = ac.replace(str,'')
                    console.log(acumulado.value)
            }
        }
    }    
    if(acumulado.value == ''){ 
        document.getElementById('tags-añadidos').hidden= true;
    }
   
    
}

function buscarArchivos(){
    let tipo = document.getElementById('tipo').value
    let subtipo = document.getElementById('subtipo').value
    let busqueda = document.getElementById('busq').value
    let tag = document.getElementById('tag').value
    let input_tag = null
    if(document.getElementById('input_tag')){
       input_tag = document.getElementById('input_tag').value
    }    
    let fecha1 = null
    let fecha2 =null
    let ano = null
    let betweenyears = document.getElementById('betwenyears').value
    if(document.getElementById('yearIn').hidden === true){
        fecha1 = document.getElementById('min').value
        fecha2 = document.getElementById('max').value
    }
    else{
        ano = document.getElementById ('año').value
    }
    //
    let route = 'archivo/buscar'
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
            busqueda:busqueda,
            tag:tag,
            input_tag: input_tag,
            betweenyears:betweenyears,
            fecha1:fecha1,
            fecha2:fecha2,
            ano:ano
        }),
        dataType: 'json',
        success: function(res){  
            let table = $('#archivos').DataTable()
            table.clear()
            console.log(res.length)
            if(res.length == 0){
                alert('No se encontraron archivos.')
            }
            for(let i=0; i<res.length; i++){
                console.log(res[i])
                let claves 
                if(res[i].claves_archivo == null){
                    claves='-'
                }
                else{
                    claves=res[i].claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;')
                }
                //console.log(res[i].nombre_corto, '', res[i].dia_archivo + '-' + res[i].mes_archivo + '-' + res[i].ano_archivo, res[i].nro_archivo, res[i].claves_archivo, '', res[i].orden)
                //table.rows.add([0,1,2,3,4,5,6.7]).draw(true);
                let myDate = new Date(res[i].fecha_archivo)
                let noTime = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate()).toLocaleDateString();
                table.row.add({
                   0: '<button type="button" class="btn"><i class="fas fa-print" style="color: #ff9f79;"></i></button>',
                   1 : res[i].nombre_corto,
                   2 : res[i].dessubtipoarchivo,
                   3 : '<span>'+myDate.getFullYear()+(myDate.getMonth() + 1).toString().padStart(2, "0")+ myDate.getDate().toString().padStart(2, "0") + '</span>' + noTime,
                   4 : res[i].nro_archivo,
                   5 : claves,
                   6 : res[i].path_archivo + res[i].nombre_archivo,
                   7 : res[i].orden,
                   8: res[i].id_archivo
                })                      
            }      
            table.draw(true); 
            
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    }); 
}

function cargarBoletin(){
    //
    let advertencia = document.getElementById('aclaracion')
    advertencia.innerHTML='Por favor espere a que el boletín cargue...'
    let route = 'archivo/boletin'    
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
            _token: $('#signup-token').val()
        }),
        dataType: 'json',
        success: function(res){  
            let table = $('#archivos').DataTable()
            table.clear()
            console.log(res.length)            
            for(let i=0; i<res.length; i++){               
                let claves 
                if(res[i].claves_archivo == null){
                    claves='-'
                }
                else{
                    claves=res[i].claves_archivo.replaceAll('<','&lt;').replaceAll('>','&gt;')
                }
                let myDate = new Date(res[i].fecha_archivo)
                let noTime = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate()).toLocaleDateString();
                console.log(res[i])
                table.row.add({
                   0: '<button type="button" class="btn"><i class="fas fa-print" style="color: #ff9f79;"></i></button>',
                   1 : res[i].nombre_corto,
                   2 : res[i].dessubtipoarchivo,
                   3 : '<span>'+myDate.getFullYear()+(myDate.getMonth() + 1).toString().padStart(2, "0")+ myDate.getDate().toString().padStart(2, "0") + '</span> '+ noTime,                   
                   4 : res[i].nro_archivo,
                   5 : claves,
                   6 : res[i].path_archivo + res[i].nombre_archivo,
                   7 : res[i].orden,
                   8 : res[i].id_archivo
                })      
            }      
            advertencia.innerHTML='(Por defecto verás los archivos correspondientes al último boletín)'
            table.draw(true); 
            
        },
        error: function(res){
            console.log(res)
            popup(-2)
        }
    }); 
}

function limpiar(){ 
    if(document.getElementById('subtipo')){
       document.getElementById('subtipo').value ='sel'
    }
    document.getElementById('subtipo').hidden=true
    document.getElementById('tipo').value = 'sel' 
    document.getElementById('placeholder').removeAttribute('hidden')    
    if(document.getElementById('input-tag')){
        document.getElementById('input-tag').value=''
    }
    document.getElementById('tag').value = 'sel'

    document.getElementById('inp-tag').hidden=true    
    document.getElementById('placeholder-tag').removeAttribute('hidden')    
    if(document.getElementById('max')){
        document.getElementById('max').value = 'dd-mm-aaaa'
        document.getElementById('min').value = 'dd-mm-aaaa'
    }
    if(document.getElementById('año')){
        document.getElementById('año').value = 'sel'
    }
    document.getElementById('busq').value = ''
    cancelarbusqueda()
    checkEnableButton()
}