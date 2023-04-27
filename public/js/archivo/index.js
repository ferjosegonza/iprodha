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
                    let tipoId = tipoId + document.getElementById('tipo').value[i].toString(); 
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
        document.getElementById('subtipo').hidden = false;
        document.getElementById('placeholder').hidden = true;
        let subtipo = document.getElementById('subtipo')
        let subtid

        //console.log("Hay " + subtipo.options.length + " subitems")
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

function filtrar(){
    if(document.getElementById('busq').value == ""){
        // $( "#archivos" ).DataTable().ajax.reload()
        var table = $('#archivos').DataTable()
        table
        .columns( '.asun' ).search("").draw();
     }
     else{
         var asunto = document.getElementById('busq').value; 
         console.log(asunto);
         var table = $('#archivos').DataTable()
         table
             .columns( '.asun' ).search(asunto).draw();
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
    var cont=0;
    let idtag = document.getElementById('tag').value;
    let tag = obtenerTagFormato(idtag);
    let div = document.getElementById('tag-comp');
    let div2 = document.createElement("div");    
    let lab = document.createElement('label');
    document.getElementById('inp-tag').removeAttribute('hidden');
    document.getElementById('placeholder-tag').hidden = true;
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
    input.setAttribute('name','input'+cont);
    cont++;
    div2.className = "col-lg-12";
    div2.appendChild(input)       

    div.appendChild(div2);
}

$(document).ready(function () {
     //create();
     
    // Setup - add a text input to each footer cell
    $('#archivos thead tr').clone(true).addClass('filters').appendTo( '#archivos thead' );

    var table = $('#archivos').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
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
        },
        order: [[ 1, 'asc' ]],

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
        let data = table.row(this).data();
        table.columns( '.sub' ).search(data[2]).draw();
        table.columns( '.tipo' ).search(data[1]).draw();
        table.columns( '.nro' ).search(data[4]).draw();
        table.columns( '.fecha' ).search(data[3]).draw();
        document.getElementById('preview').hidden = false
        document.getElementById('pdfver').setAttribute('data', data[6])
        document.getElementById('linkpdf').setAttribute('href', data[6])
        document.getElementById('pdftitle').innerHTML= data[1] + ' - ' + data[2] + ' - ' + data[4]
        document.getElementById('despdf').innerHTML=  '<b>FECHA:</b> ' + data[3]+ '<br><b>ASUNTOS CLAVES:</b><br>' + data[5]
        //document.getElementById('ruta').innerHTML= data[6]
        //alert('You clicked on ' + data[6] + "'s row");
    });
    
});

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
        console.log('nada')
    }
    else{
        let year = document.getElementById('año').value; 
        console.log(year)
        table.columns( '.fecha' ).search(year).draw();
    }    
    document.getElementById('preview').hidden = true
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


  window.addEventListener("DOMContentLoaded", (event) => {
    const submitBtn = document.getElementById('btnb')

const año = document.getElementById('año')
const tipo = document.getElementById('tipo')
const busqueda = document.getElementById('busq')
const fecha1 = document.getElementById('min')
const fecha2 = document.getElementById('max')
// run this function whenever the values of any of the above 4 inputs change.
// this is to check if the input for all 4 is valid.  if so, enable submitBtn.
// otherwise, disable it.
const checkEnableButton = () => {    

    console.log(busqueda.value)
    //console.log(año.value, tipo.value, fecha1.value, fecha2.value, busqueda.value) 
    if(año.value!= 'sel' && tipo.value != 'sel' ||  fecha1.value != '' && tipo.value != 'sel' 
    || fecha2.value != '' && tipo.value != 'sel' || busqueda.value != ''){
        submitBtn.removeAttribute('disabled')
    }
    else{
        submitBtn.setAttribute('disabled', 'disabled')
    }   
}


if(fecha1){fecha1.addEventListener('change', checkEnableButton)}
if(fecha2){fecha2.addEventListener('change', checkEnableButton)}
año.addEventListener('change', checkEnableButton)
tipo.addEventListener('change', checkEnableButton)
busqueda.addEventListener('keyup', checkEnableButton)
});

