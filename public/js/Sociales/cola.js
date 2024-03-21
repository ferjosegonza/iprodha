document.addEventListener("input", checkBtn);

function checkBtn(){
    console.log(document.getElementById('datepicker').value)
}

function generarTurnos(){
    let id=document.getElementById('id').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/generarTurnos',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            popup(6)
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function fecha(){
    document.getElementById('datepicker').classList.remove('nofecha')
}

function visualizarDia(){
    let fecha = document.getElementById('datepicker').value
    let id=document.getElementById('id').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/getTurnosByFecha',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id,
            fecha
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            if(res.length > 0){
                mostrarTurnos(res);
            }
            else{
                document.getElementById('diaTracker').setAttribute('hidden', 'hidden')
                popup(2);
            }
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function popup(estado){  
    let popEl = document.getElementById('popup')
    if(estado == 1){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha reservado el turno.</p>'
    }
    else if(estado == 2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No existen turnos en la fecha indicada.</p>'
    }    
    else if(estado == 3){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido reservar el turno.</p>'
    }
    else if(estado == 4){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha borrado la cola.</p>'
        document.getElementById('btnOk').setAttribute('onclick', location.assign("/sociales/turnos"));
    }
    else if(estado == 5){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido borrar la cola.</p>'
    }
    else if(estado == 6){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se han generado los turnos</p>'
        document.getElementById('btnOk').setAttribute('onclick', location.reload())
        
    }
    else if(estado == 7){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se puede borrar una cola a la que ya se le reservaron turnos.</p>'
    }
    else if(estado == 8){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha publicado la cola.</p>'
        document.getElementById('btnOk').setAttribute('onclick', location.reload())
    }
    else if(estado == 9){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido publicar la cola.</p>'
    }
    else if(estado == 10){
        document.getElementById('popTitulo').innerHTML = 'Éxito'
        document.getElementById('popBody').innerHTML = '<p>Se ha liberado el turno.</p>'
    }
    else if(estado == 11){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido liberar el turno.</p>'
    }
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function mostrarTurnos(turnos){
    document.getElementById('diaTracker').removeAttribute('hidden');
    let head_Table= document.getElementById('turnos_head');
    let body_Table= document.getElementById('turnos_body');
    let puestos = Array.from(new Set(turnos.map(turno => turno.puesto)));
    let head = '<th style="width:60px; display:table-cell;">Horas</th>'
    puestos.forEach(puesto => {
        head += '<th style="width:60px; display:table-cell;">Puesto '+puesto+'</th>';
    })
    let horaActual = turnos[0].hora
    let minutoActual = turnos[0].minuto
    let body='<tr><th>' + String(turnos[0].hora).padStart(2, '0') + ':' + String(turnos[0].minuto).padStart(2, '0') + '</th>'
    turnos.forEach(turno => {
        if(horaActual != turno.hora || minutoActual != turno.minuto){
            body +='</tr><tr><th style="width:60px; display:table-cell;">'+ String(turno.hora).padStart(2, '0') + ':' + String(turno.minuto).padStart(2, '0')  +'</th>'
            horaActual = turno.hora;
            minutoActual = turno.minuto;
        }
        if(turno.dni == null){
            body += '<td style="display:table-cell;" class="btn" onclick="popupTurno('+turno.idturno+')">Disponible +</td>'
        }
        else{
            body += '<td style="display:table-cell;" class="btn" onclick="popUpLiberarTurno('+turno.idturno+', \'' + turno.nombre + '\', \'' + turno.dni + '\')">'+ turno.nombre + '. DNI:' + turno.dni +'</td>'
        }
    });
    body += '</tr>'
    if ( $.fn.DataTable.isDataTable('#turnos') ) {
        $('#turnos').DataTable().destroy();
        $('#turnos tbody').empty();
        $('#turnos thead').empty();
      }
    head_Table.innerHTML = head;
    body_Table.innerHTML = body;
    let table  = $('#turnos').DataTable({
        scrollX: true,
        paging:   false,
        ordering: false,
        info:     false,
       language: {
        search: 'Buscar'
       }    
    });
}

function popupTurno(id){
    document.getElementById('btnReservar').setAttribute('onclick', 'reservar('+id+')');
    document.getElementById('btnReservar').setAttribute('disabled', 'disabled')
    document.getElementById('nom_titular').setAttribute('hidden','hidden');
    let popEl = document.getElementById('popupTurno')
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function checkBtnVerificar(){
    if(document.getElementById('dni').value != ''){
        document.getElementById('btnVerificar').removeAttribute('disabled');
    }
    else{
        document.getElementById('btnVerificar').setAttribute('disabled', 'disabled');
    }
}

function verificarDni(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/verificarUsuario',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            dni: document.getElementById('dni').value
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            if(res.length>0){
                document.getElementById('nom_titular').removeAttribute('hidden');
                document.getElementById('nombre').value = res[0].nombre;
                document.getElementById('btnReservar').removeAttribute('disabled')
            }
            else{
                alert('No se ha encontrado un titular con ese DNI.')
            }
        },
        error: function(res){
            console.log(res)
        }
    });     
}

function reservar(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/reservarTurno',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id,
            dni: document.getElementById('dni').value
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            popup(1);
            visualizarDia();
        },
        error: function(res){
            console.log(res)
            popup(3)
        }    });   
    
}

function borrarColaPopUp(){
    let popEl = document.getElementById('popupBorrar')
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function borrarCola(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/borrarCola',
        type: 'DELETE',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id : document.getElementById('id').value
        }),
        dataType: 'json',
        success: function(res){  
            if(res != -1){
                console.log(res)
                popup(4);
            } 
            else{
                console.log(res)
                popup(7);
            }
            
        },
        error: function(res){
            console.log(res)
            popup(5)
        }
    });       
}

function publicarCola(){  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/publicarCola',
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id : document.getElementById('id').value
        }),
        dataType: 'json',
        success: function(res){  
                console.log(res)
                popup(8);
        },
        error: function(res){
            console.log(res)
            popup(9)
        }
    });       
}

function popUpLiberarTurno(id, nombre, dni){
    let popEl = document.getElementById('popupBorrar')
    document.getElementById('bodyTurnoBorrar').innerHTML = 'Este turno está reservado por ' + nombre + ', DNI: ' + dni +'.<br><u><b>¿Desea liberar el turno?</b></u>'
    document.getElementById('footerTurnoBorrar').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="liberarTurno('+ id + ')">Liberar turno</button>'
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()

    

}

function liberarTurno(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/sociales/reservarTurno',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id
        }),
        dataType: 'json',
        success: function(res){   
            console.log(res)
            popup(10);
            visualizarDia();
        },
        error: function(res){
            console.log(res)
            popup(11)
        }    });  
}

function  exportPDF(){
    //crear tabla
    let tabla = document.getElementById('turnos');
    //
    let doc = new jsPDF('l', 'pt', 'a4');

    // Add text to the PDF
    doc.setFontSize(12); // Set font size
    doc.text(document.getElementById('titulo').innerHTML + '.', 10, 20);
    doc.text('Fecha: ' + fecha.toLocaleDateString() + '.', 10, 40);
    doc.text('Día y hora de la impresión: ' + currentdate.toLocaleString(), 10, 60);
    // Add the table to the PDF
    doc.autoTable({
        html: tabla,
        theme: 'grid',
        styles: {
            halign: 'center'
        },
        headStyles: {
            fillColor: [124, 95, 240]
        },
        alternateRowStyles: {
            fillColor: [231, 215, 252]
        },
        tableLineColor: [124, 95, 240],
        tableLineWidth: 0.1,
        startY: 80 
    });

    let nombre = 'Turnos_' + document.getElementById('datepicker').value;
    doc.save(nombre + '.pdf');
}

function excel() {
    var currentdate = new Date();
    let fecha = new Date(document.getElementById('datepicker').value);
    let tableE = document.createElement('table');
    tableE.innerHTML = '<tr><th colspan="3">'+document.getElementById('titulo').innerHTML +'</th><th colspan="2"> Fecha '+ fecha.toLocaleDateString() + '</th><th colspan="5">Día y hora de la impresión: ' + currentdate.toLocaleString() +'</th></tr><tr></tr>';
    var table = document.getElementById('turnos');
    tableE.innerHTML += table.innerHTML;
    if (!table) {
        console.error("Table element with id 'turnos' not found.");
        return;
    }

    var filename = 'Turnos_' + document.getElementById('datepicker').value + '.xlsx';
    
    /* Convert table to worksheet */
    var ws = table_to_sheet_with_style(tableE);

    /* Generate workbook */
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    /* Generate XLSX file */
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

    /* Create Blob */
    var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });

    /* Trigger download */
    saveAs(blob, filename);
}

/* Helper function to convert data to array buffer */
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}

/* Custom function to convert table to sheet with style */
function table_to_sheet_with_style(table) {
    var ws = XLSX.utils.table_to_sheet(table);

    // Add some basic styling
    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var R = range.s.r; R <= range.e.r; ++R) {
        for (var C = range.s.c; C <= range.e.c; ++C) {
            var cell_address = { c: C, r: R };
            var cell_ref = XLSX.utils.encode_cell(cell_address);
            var cell = ws[cell_ref];
            
            // Add styling to cells
            if (cell && cell.v !== undefined) {
                cell.s = { font: { bold: true } }; // Example: Making text bold
            }
        }
    }

    return ws;
}