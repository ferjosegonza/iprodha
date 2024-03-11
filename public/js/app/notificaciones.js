var chequeados = []
var selectedGroup = null

function enable(){
    document.getElementById('prev').removeAttribute('disabled')
}

function previsualizar(){
    ocultarPagina()
    let val = document.getElementById('tipo').value
    let tipo = val.split('|')[0]
    let forma = val.split('|')[1]
    console.log('tipo: ' + tipo + ' forma: ' + forma) 
    if(forma == 2){
       document.getElementById('usuarios').removeAttribute('hidden')
    }
    else{
        if(tipo == 1){
            boletas()
        }
        if(tipo == 2){
            adeuda()
        }
    }    
}

function boletas(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'notificaciones/boletas/pendientes',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            console.log(res)
            rellenarTabla(res, 1)
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}

function adeuda(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/boletas/adeuda',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            console.log(res)
            rellenarTabla(res, 2)
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}

function rellenarTabla(res, tipo){    
    let pendientes = document.getElementById('visualizar')
    if(res.length > 0){
        let innerHTML
        if(res.length == 1){
            innerHTML = '<label>Hay 1 notificación pendiente.</label>'
        }
        else{
            innerHTML = '<label>Hay ' + res.length + ' notificaciones pendientes.</label>'
        }
        innerHTML = innerHTML + '<table id="pendientesTabla"><thead><th>Cuil</th><th>Encabezado</th><th>Mensaje</th><th>Fecha</th></thead><tbody>'
        res.forEach((noti) => {
            innerHTML = innerHTML + '<tr><td>'+noti.usuario+'</td><td>'+noti.encabezado+'</td><td>'+noti.mensaje+'</td><td>'+noti.fecha+'</td></tr>'
        })
        if(tipo == 1){
            innerHTML = innerHTML + '</tbody></table><button class="btn btn-primary" onclick="enviarBoletas()">Enviar notificaciones</button>'
        }
        if (tipo==2){
            innerHTML = innerHTML + '</tbody></table><button class="btn btn-primary" onclick="enviarAdeuda()">Enviar notificaciones</button>'
        }
        pendientes.innerHTML = innerHTML
        pendientes.removeAttribute('hidden')
        tabla('#pendientesTabla')
    }
    else{
        pendientes.innerHTML = 'No existen notificaciones pendientes que enviar.'
        pendientes.removeAttribute('hidden')
    }
}

function tabla(id) {
  $(id).DataTable({
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
       order: [[ 1, 'asc' ]]
    })
    
}

function enviarBoletas(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notificaciones/boletas/enviar',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            if(res == 1){
                popup(1)
            }
            else{
                popup(2)
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
            popup(3)
        }   
    });
}

function enviarAdeuda(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notificaciones/boletas/enviarAdeuda',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            if(res == 1){
                popup(1)
            }
            else{
                popup(2)
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
            popup(3)
        }   
    });
}

function popup(tipo){  
    let popEl = document.getElementById('popup')
    if(tipo == 1 ){
        document.getElementById('popTitulo').innerHTML = 'Éxito'     
        document.getElementById('popBody').innerHTML = '<p>Se ha enviado la notificación.</p>'      
    }
    else if(tipo == 2){
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>No se ha podido enviar la notificación.</p>'      
    }    
    else{
        document.getElementById('popTitulo').innerHTML = 'Error'
        document.getElementById('popBody').innerHTML = '<p>Hubo un error desconocido.</p>'      
    }
    let pop= bootstrap.Modal.getOrCreateInstance(popEl)
    pop.show()
}

function ocultarPagina(){
    document.getElementById('visualizar').setAttribute('hidden', 'hidden')
    document.getElementById('usuarios').setAttribute('hidden', 'hidden')
    document.getElementById('TablaUsuarios').setAttribute('hidden', 'hidden')
    document.getElementById('TablaGrupos').setAttribute('hidden', 'hidden')
    document.getElementById('esconderInputGrupo').setAttribute('hidden','hidden');
    document.getElementById('Previsualizar_Grupo').setAttribute('hidden','hidden');
    document.getElementById('Previsualizar_Mensaje').setAttribute('hidden','hidden');
    document.getElementById('btnElegirGrupo').setAttribute('disabled', 'disabled');    
    document.getElementById('btnElegirUsuarios').setAttribute('disabled','disabled')
    seleccionarTodosUsuarios(false)
    selectedGroup=null;
}

function getUsuarios(){   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/usuarios',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            console.log(res);
            mostrarUsuarios(res);
        },
        error: function(response){
            console.log('ERROR');
            console.log(response);
        }   
    });
}

function mostrarUsuarios(users){
    document.getElementById('TablaUsuarios').removeAttribute('hidden');
    document.getElementById('TablaGrupos').setAttribute('hidden', 'hidden');

    let body = document.getElementById('table_body_usuarios');
    let str = ''
    users.forEach(user => {
        str+= '<tr id="'+user.id+'"><td hidden>'+user.id+'</td><td id="cuit_'+user.id+'">'+user.usuario+'</td><td id="nombre_'+user.id+'">'+user.nombre+'</td><td><input type="checkbox" id="check_'+user.id+'" oninput="checkBox('+user.id+')"></td></tr>'
    });
    body.innerHTML=str;
    if (! $.fn.dataTable.isDataTable( '#table_usuarios' )) 
    {   
        tabla('#table_usuarios');
    }
    
}

function checkBox(id){    
    if(document.getElementById('check_'+id).checked){
        document.getElementById(id).classList.add('rowChecked')
        console.log(id + ' checkeado')
        chequeados.push(id)
        
    }
    else{
        document.getElementById(id).classList.remove('rowChecked')
        console.log(id + ' no checkeado')
        let index = chequeados.indexOf(id);
        if (index > -1) { 
            chequeados.splice(index, 1); // 2nd parameter means remove one item only
        }        
    }
    checkBtnGuardarGrupo()
    console.log(chequeados)
    if(chequeados.length>0){
        document.getElementById('btnElegirUsuarios').removeAttribute('disabled')
    }
    else{
        document.getElementById('btnElegirUsuarios').setAttribute('disabled','disabled')
    }
}

function seleccionarTodosUsuarios(bool){    
    let checks = document.querySelectorAll('[id^="check_"]');
    if(bool){
       checks.forEach(check => {
            if(!check.checked){
                check.checked = true;
                checkBox(parseInt(check.id.split('check_')[1]))
            }
        });        
    }
    else{
        checks.forEach(check => {
            if(check.checked){
            check.checked = false;
            checkBox(parseInt(check.id.split('check_')[1]))
        }
        });
    }
}

function getGrupos(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/getGrupos',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
        }),
        dataType: 'json',
        success: function(res) 
        {             
            console.log(res)
            mostrarGrupos(res)
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}

function mostrarGrupos(grupos){
    document.getElementById('TablaGrupos').removeAttribute('hidden');
    document.getElementById('TablaUsuarios').setAttribute('hidden', 'hidden');
    
    let body = document.getElementById('table_body_grupos')
        let str = ''
        grupos.forEach(grupo => {
            str += '<tr id="tr_'+grupo.id_grupo+'" onclick="handleTrClick('+grupo.id_grupo+')"><td hidden>'+grupo.id_grupo+'</td><td>'+grupo.descripcion+'</td></tr>'
        })
        body.innerHTML = str;
        if (! $.fn.dataTable.isDataTable( '#table_grupos' )) 
        {   
            tabla('#table_grupos');
            const table = new DataTable('#table_grupos'); 
        }   
}

function handleTrClick(id){
    if(selectedGroup == null){
        selectedGroup = id; 
        document.getElementById('tr_'+id).classList.add('rowChecked')
        document.getElementById('btnElegirGrupo').removeAttribute('disabled');
    }
    else if(selectedGroup == id){
        selectedGroup = null;
        document.getElementById('tr_'+id).classList.remove('rowChecked')
        document.getElementById('btnElegirGrupo').setAttribute('disabled', 'disabled');
    }
    else{
        document.getElementById('tr_'+selectedGroup).classList.remove('rowChecked')
        selectedGroup = id; 
        document.getElementById('tr_'+id).classList.add('rowChecked')
        document.getElementById('btnElegirGrupo').removeAttribute('disabled');
    }
    console.log(selectedGroup)
}

function crearGrupos(){
    document.getElementById('esconderInputGrupo').removeAttribute('hidden');
    document.getElementById('TablaUsuarios').removeAttribute('hidden');    
    document.getElementById('Previsualizar_Mensaje').setAttribute('hidden','hidden');
    getUsuarios();
}

function abrirUsuarios(){  
    document.getElementById('esconderInputGrupo').setAttribute('hidden','hidden');
    document.getElementById('Previsualizar_Mensaje').setAttribute('hidden','hidden');    
    document.getElementById('btnElegirUsuarios').setAttribute('disabled','disabled');
    chequeados= []
    getUsuarios();
}

function abrirGrupos(){  
    document.getElementById('Previsualizar_Mensaje').setAttribute('hidden','hidden');
    selectedGroup=null;
    document.getElementById('btnElegirGrupo').setAttribute('disabled', 'disabled');
    getGrupos();
}

function prevGuardar(){
    let nombre = document.getElementById('nombreGrupo').value;
    document.getElementById('esconderInputGrupo').setAttribute('hidden','hidden');
    document.getElementById('TablaUsuarios').setAttribute('hidden','hidden');
    document.getElementById('Previsualizar_Grupo').removeAttribute('hidden');
    document.getElementById('nombreGrupoDone').value = nombre;
    let str = '';
    chequeados.forEach(check=>{
        let nombre = document.getElementById('nombre_'+check.toString()).innerHTML
        let cuit = document.getElementById('cuit_'+check.toString()).innerHTML
        str+='<tr><td hidden>'+check+'</td><td>'+cuit+'</td><td>'+nombre+'</td></tr>';
    });
    let body = document.getElementById('previa_grupo_table_body');
    body.innerHTML = str;
    if (! $.fn.dataTable.isDataTable( '#previa_grupo_table' )) 
    {   
        tabla('#previa_grupo_table');
    }   
}

function checkBtnGuardarGrupo(){
    if(document.getElementById('nombreGrupo').value.length>0 && chequeados.length>0){
        document.getElementById('btnGuardarGrupo').removeAttribute('disabled')
    }
    else{
        document.getElementById('btnGuardarGrupo').setAttribute('disabled', 'disabled')
    }
}

function confirmarGrupo(){  
    let nombre = document.getElementById('nombreGrupo').value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/setGruposCabecera',
        type: 'POST',      
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            nombre:nombre,
        }),
        dataType: 'json',
        success: function(idgrupo) 
        {             
            console.log(idgrupo)            
            $.ajax({
                url: 'notificaciones/setGruposDetalle',
                type: 'POST',      
                cache: false,
                data: ({
                    _token: $('#signup-token').val(),
                    ids:chequeados,
                    id_grupo: idgrupo
                }),
                dataType: 'json',
                success: function(res) 
                {             
                    console.log(res)
                    ocultarPagina()
                    getGrupos()
                    
                },
                error: function(response){
                    console.log('ERROR')
                    console.log(response);
                }   
            });
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}


function grupoElegido(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/getGrupoIndividuos',
        type: 'GET',      
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id: selectedGroup
        }),
        dataType: 'json',
        success: function(res) 
        {             
           console.log(res)
           document.getElementById('TablaGrupos').setAttribute('hidden', 'hidden');
           previsualizarMensaje(res)
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}

function previsualizarMensaje(usuarios){
    document.getElementById('Previsualizar_Mensaje').removeAttribute('hidden')
    let str = ''
    usuarios.forEach(user=>{
        str+='<tr><td hidden>'+user.id_usuario+'</td><td>'+user.cuit+'</td><td>'+user.nombre+'</td></tr>'
    })
    document.getElementById('table_usuarios_elegidos_body').innerHTML=str;
    if (! $.fn.dataTable.isDataTable( '#table_usuarios_elegidos' )) 
    {   
        tabla('#table_usuarios_elegidos');    
    }   
}

function usuariosElegidos(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: 'notificaciones/getUsuarios',
        type: 'GET',      
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            ids: chequeados
        }),
        dataType: 'json',
        success: function(res) 
        {             
           console.log(res)
           document.getElementById('TablaUsuarios').setAttribute('hidden', 'hidden');
           previsualizarMensaje(res)
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
        }   
    });
}


function checkMsj(){
    if(document.getElementById('cabecera').value.length>0 && document.getElementById('cuerpo').value.length > 0){
        document.getElementById('btnEnviarMsj').removeAttribute('disabled')
    }
    else{
        document.getElementById('btnEnviarMsj').setAttribute('disabled', 'disabled')
    }
}

function enviarMsj(){    
    let ids = []
    let allTDs = document.getElementById('table_usuarios_elegidos').getElementsByTagName('tr');
    for (let i = 1; i < allTDs.length; i++) {
        ids.push(parseInt(allTDs[i].getElementsByTagName('td')[0].innerHTML))
    }

    let cuerpo = document.getElementById('cuerpo').value;
    let cabecera = document.getElementById('cabecera').value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notificaciones/enviarMsj',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            ids,
            cuerpo,
            cabecera

        }),
        dataType: 'json',
        success: function(res) 
        {             
            if(res == 1){
                popup(1)
            }
            else{
                popup(2)
            }
        },
        error: function(response){
            console.log('ERROR')
            console.log(response);
            popup(3)
        }   
    });
}