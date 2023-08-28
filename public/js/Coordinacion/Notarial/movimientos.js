$(document).ready(function () {
    $('#tableMovimientos').DataTable({
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
    document.getElementById('tablebenef').setAttribute('hidden', 'hidden')
    document.getElementById('tableprof').setAttribute('hidden', 'hidden')
    document.getElementById('tablefunc').setAttribute('hidden', 'hidden')
    document.getElementById('tableesc').setAttribute('hidden', 'hidden')
    document.getElementById('tabledoc').setAttribute('hidden', 'hidden')
    if(document.getElementById('escribano').innerHTML == '1'){
        recuperarEscribano()        
    }
    if(document.getElementById('profesional').innerHTML == '1'){
        recuperarProfesional()
    }
    if(document.getElementById('documento').innerHTML == '1'){
        recuperarDocumento()
    }
    if(document.getElementById('funcionario').innerHTML == '1'){
        recuperarFuncionario()
    }
    if(document.getElementById('beneficiario').innerHTML == '1'){
        recuperarBeneficiario()
    }
});

function recuperarEscribano(){
    let id = document.getElementById('id').innerHTML
    console.log(id)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getEscribano',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res)       
            let prev = document.getElementById('prevEscribano')
            let email = res.email
            if(res.email == null){
                email = '-'
            }
            let tel = res.telef1
            if(res.telef1 == null){
                tel = '-'
            }
            prev.innerHTML = '<hr><h6>Escribano/a:</h6><table><tr><th>Nombre</th><td>'+res.nombre+'</td><th>Matricula</th><td>'+res.matricula+'</td><th>CUIT</th><td>'+res.cuit+'</td></tr><tr><th>Email</th><td>'+email+'</td><th>Teléfono</th><td>'+tel+'</td></tr></table>'         
            prev.removeAttribute('hidden') 
            let body = document.getElementById('escbody')
            let tr = document.createElement('tr')
            tr.innerHTML = '<td>'+ res.nombre +'</td>' + '<td>'+ res.matricula +'</td>'  
            body.appendChild(tr)
            document.getElementById('tableesc').removeAttribute('hidden')
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function recuperarFuncionario(){
    let id = document.getElementById('id').innerHTML
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getFuncionario',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res)      
            let prev = document.getElementById('prevFuncionario')
            let obs = res.observacion
            if(res.observacion == null){
                obs = '-'
            }
            prev.innerHTML = '<hr><h6>Funcionario/a:</h6><table><tr><th>Descripción</th><td>'+res.descripcion+'</td><th>Observación</th><td>'+obs+'</td></tr></table>'         
            prev.removeAttribute('hidden')         
            let body = document.getElementById('funcbody')
            let tr = document.createElement('tr')
            tr.innerHTML = '<td hidden>'+ res.id_tipo+'</td>' +'<td>'+ res.descripcion +'</td>' + '<td>'+ obs +'</td>'  
            body.appendChild(tr)
            document.getElementById('tablefunc').removeAttribute('hidden')       
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function recuperarBeneficiario(){
    let id = document.getElementById('id').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getBeneficiario',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res) 
            let prev = document.getElementById('prevBeneficiario')
            prev.innerHTML = '<hr><h6>Beneficiario/a:</h6><table><tr><th>DNI</th><td>'+res.dni+'</td><th>Ope</th><td>'+res.ope+'</td><th>Barrio</th><td>'+res.barrio+'</td><th>Adju</th><td>'+res.adju+'</td></tr><tr><th>APYNA</th><td>'+res.apyna+'</td></tr></table>'         
            prev.removeAttribute('hidden')            
            let body = document.getElementById('benefbody')
            let tr = document.createElement('tr')
            tr.innerHTML = '<td>'+ res.dni+'</td>' +'<td>'+ res.ope+'</td>' + '<td>'+ res.barrio +'</td>' + '<td>'+ res.adju +'</td>' + '<td>'+ res.apyna +'</td>'  
            body.appendChild(tr)
            document.getElementById('tablebenef').removeAttribute('hidden')                
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function recuperarProfesional(){
    let id = document.getElementById('id').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getProfesional',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res)   
            let prev = document.getElementById('prevProfesional')
            prev.innerHTML = '<hr><h6>Profesional:</h6><table><tr><th>Profesional</th><td>'+res.prof+'</td><th>Caracter</th><td>'+res.car+'</td></tr></table>'         
            prev.removeAttribute('hidden') 
            let body = document.getElementById('profbody')
            let tr = document.createElement('tr')
            tr.innerHTML = '<td hidden>'+ res.id_profesional+'</td>' +'<td>'+ res.prof+'</td>' + '<td hidden>'+ res.id_caracter +'</td>' + '<td>'+ res.car +'</td>' 
            body.appendChild(tr)
            document.getElementById('tableprof').removeAttribute('hidden')                         
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function recuperarDocumento(){
    let id = document.getElementById('id').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getDocumento',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res)   
            let prev = document.getElementById('prevDocumento')
            let asun
            if(res[0].tipo == 'NOTA'){
                asun = res[0].not_asunto
            }
            else{
                asun = res[0].exp_asunto
            }
            prev.innerHTML = '<hr><h6>Documento:</h6><table><tr><th>Número de Documento</th><td>'+res[0].numero+'</td><th>Asunto</th><td>'+asun+'</td></tr></table>'         
            prev.removeAttribute('hidden')        
            let body = document.getElementById('docbody')
            let tr = document.createElement('tr')
            tr.innerHTML= '<td hidden>'+ res[0].doc_id +'</td>' + '<td>'+ res[0].numero +'</td>' + '<td>'+ asun +'</td>'
            body.append(tr)
            document.getElementById('tabledoc').removeAttribute('hidden')             
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function checkGuardar(tipo){
    let btn
    let sel
    let inp
    if(tipo == '1'){
        btn = document.getElementById('btnSave')
        sel = document.getElementById('medio')
        inp = document.getElementById('obs')
    }
    else{
        btn = document.getElementById('btnSave2')
        sel = document.getElementById('medio2')
        inp = document.getElementById('obs2')
    }
    
    if(sel.value != 'sel' && inp.value != ''){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function guardarMovimiento(){
    let obs = document.getElementById('obs').value
    let medio = document.getElementById('medio').value
    let id = document.getElementById('id').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/nuevoMovimiento',
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            obs:obs,
            medio:medio,
            id:id
        }),
        dataType: 'json',
        success: function(res){              
            console.log(res)            
            actualizarTabla()
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function actualizarTabla(){
    let id = document.getElementById('id').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/getmovimientos',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            id:id
        }),
        dataType: 'json',
        success: function(res){    
            console.log(res)
            $('#modal').modal('show'); 
            $('#modal').modal('hide'); 
            //hide the modal

            $('body').removeClass('modal-open'); 
            //modal-open class is added on body so it has to be removed

            $('.modal-backdrop').remove();
            //need to remove div with modal-backdrop class            
            
            location.reload() 
            /* let body = document.getElementById('bodyMovimientos')
            console.log(body.childNodes)
            while (body.firstChild) {
                body.removeChild(body.firstChild);
            }
            for(let i = 0; i<res.length; i++){
                let tr = document.createElement('tr')
                tr.innerHTML = '<td>'+res[i].fecha+'</td>' + '<td>'+res[i].observacion+'</td>'+'<td>'+res[i].descripcion+'</td>'
                body.appendChild(tr)
            }
            $('#tableMovimientos').DataTable().draw(); */
                   
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function abrirTramite(id){
    document.getElementById("preview").removeAttribute('hidden')
}

function escribano(){
    let modalEl = document.getElementById('modalEsc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function profesional(){
    let modalEl = document.getElementById('modalProf')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function funcionario(){
    let modalEl = document.getElementById('modalFunc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function beneficiario(){
    let modalEl = document.getElementById('modalBenef')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function documento(){
    let modalEl = document.getElementById('modalDoc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function checkDocBuscar(){
    let btn = document.getElementById('btndocbuscar')
    let nrodoc = document.getElementById('nrodocB')
    let select = document.getElementById('tipodoc')
    if(nrodoc.value != '' && select.value != 'sel'){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function checkProf(){
    let pro = document.getElementById('profesional')
    let car = document.getElementById('caracter')
    let btn = document.getElementById('btnprof')
    if(pro.value!='sel' && car.value!='sel'){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function checkFunc(){
    let btn = document.getElementById('btnfunc')
    let select = document.getElementById('funcionario')
    if(select.value != 'sel'){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function checkBuscarBenef(){
    let btn = document.getElementById('btnbuscarbenef')
    let input = document.getElementById('dnibenef')
    if(input.value != ''){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function checkEscribano(){
    let btn = document.getElementById('btnbuscesc')
    let input = document.getElementById('escS')
    if(input.value != 'sel'){
        btn.removeAttribute('disabled')
    }
    else{
        btn.setAttribute('disabled', 'disabled')
    }
}

function seleccionarEscribano(){      
    let sel = document.getElementById('escS')
    document.getElementById('nomEsc').innerHTML = sel.options[sel.selectedIndex].text
    document.getElementById('matEsc').innerHTML = sel.value
    document.getElementById('EscSeleccionado').removeAttribute('hidden')
    document.getElementById('resultadoEsc').setAttribute('hidden', 'hidden')
    document.getElementById('btnsaveesc').removeAttribute('disabled')
}

function saveEscribano(){
    let nom = document.getElementById('nomEsc').innerHTML
    let mat = document.getElementById('matEsc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ nom +'</td>' + '<td>'+ mat +'</td>'
    let body = document.getElementById('escbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
    document.getElementById('tableesc').removeAttribute('hidden')
    let modalEl = document.getElementById('modalEsc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function buscarBeneficiario(){
    let dni = document.getElementById('dnibenef').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notarial/beneficiario',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            dni:dni
        }),
        dataType: 'json',
        success: function(res){              
            console.log(res)
            if(res.length>0){
                let body = document.getElementById('bodybenef')
                while(body.hasChildNodes()){
                    body.removeChild(body.lastChild)
                }
                for(let i=0; i<res.length; i++){                    
                    let tr=document.createElement('tr')
                    tr.innerHTML='<td>'+res[i].ope+'</td><td>'+res[i].barrio+'</td><td>'+res[i].adju+'</td><td>'+res[i].apyna+'</td>'
                    tr.className= 'hoverable'
                    tr.setAttribute('onclick', 'seleccionarBeneficiario("'+res[i].ope+'","'+res[i].barrio+'","'+res[i].adju+'","'+res[i].apyna+'","'+res[i].nrdoca+'")')
                    body.appendChild(tr)
                }
                document.getElementById('resultadoBen').removeAttribute('hidden')
            }
            else{
                alert('No se encontraron resultados')
            }
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

function seleccionarBeneficiario(ope, barrio, adju, apyna, doc){
    document.getElementById('dniBef').innerHTML = doc
    document.getElementById('opeBef').innerHTML = ope
    document.getElementById('barBef').innerHTML = barrio
    document.getElementById('adjBef').innerHTML = adju
    document.getElementById('apynaBef').innerHTML = apyna
    document.getElementById('BenefSeleccionado').removeAttribute('hidden')
    document.getElementById('resultadoBen').setAttribute('hidden','hidden')
    document.getElementById('btnbenefsave').removeAttribute('disabled')
}

function saveBeneficiario(){
    let doc = document.getElementById('dniBef').innerHTML
    let ope =  document.getElementById('opeBef').innerHTML
    let barrio = document.getElementById('barBef').innerHTML 
    let adju = document.getElementById('adjBef').innerHTML
    let apyna = document.getElementById('apynaBef').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ doc +'</td>' + '<td>'+ ope +'</td>' + '<td>'+ barrio +'</td>' + '<td>'+ adju +'</td>' + '<td>'+ apyna +'</td>'
    let body = document.getElementById('benefbody')
    while(body.hasChildNodes()){
        body.removeChild(body.lastChild)
    }
    body.appendChild(tr)
    document.getElementById('tablebenef').removeAttribute('hidden')
    let modalEl = document.getElementById('modalBenef')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function buscarDocumento(){    
    if(document.getElementById('tipodoc').value != 'sel'){
        let tipo = document.getElementById('tipodoc').value
        let nro = document.getElementById('nrodocB').value
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/notarial/documento',
            type: 'GET',
            cache: false,
            data: ({
                _token: $('#signup-token').val(),
                tipo:tipo,
                nro:nro
            }),
            dataType: 'json',
            success: function(res){              
                console.log(res)
                if(res.length>0){
                    let body = document.getElementById('bodydoc')
                    while(body.hasChildNodes()){
                        body.removeChild(body.lastChild)
                    }
                    for(let i=0; i<res.length; i++){                    
                        let tr=document.createElement('tr')
                        if(tipo == 'exp'){
                            tr.innerHTML='<td hidden>'+res[i].exp_doc_id+'</td><td>'+res[i].exp_numero+'</td><td>'+res[i].exp_asunto+'</td>'
                        }
                        else{
                            tr.innerHTML='<td hidden>'+res[i].not_doc_id+'</td><td>'+res[i].not_numero+'</td><td>'+res[i].not_asunto+'</td>'
                        }
                        tr.className= 'hoverable'
                        if(tipo == 'exp'){
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].exp_doc_id+'", "' + res[i].exp_numero + '", "'+res[i].exp_asunto.replaceAll('\"', '\\"')+'")')
                        }
                        else{
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].not_doc_id+'", "' + res[i].not_numero +'", "'+res[i].not_asunto.replaceAll('\"', '\\"')+'")')
                        }
                        
                        body.appendChild(tr)
                    }
                    document.getElementById('resultadoDoc').removeAttribute('hidden')
                }
                else{
                    alert('No se encontraron resultados')
                }
            },
            error: function(res){
                console.log(res)
            }
        }); 
    }
}
function seleccionarDocumento(id, nro, asun){
    console.log(nro)
    document.getElementById('idDoc').innerHTML = id
    document.getElementById('nroDocu').innerHTML = nro
    document.getElementById('asuDoc').innerHTML = asun
    document.getElementById('DocSeleccionado').removeAttribute('hidden')
    document.getElementById('resultadoDoc').setAttribute('hidden','hidden')
    document.getElementById('btndocguardar').removeAttribute('disabled')
}

function saveDocumento(){
    let id = document.getElementById('idDoc').innerHTML
    let nro = document.getElementById('nroDocu').innerHTML
    let asun = document.getElementById('asuDoc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td hidden>'+ id +'</td>' + '<td>'+ nro +'</td>' + '<td>'+ asun +'</td>'
    let body = document.getElementById('docbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
    document.getElementById('tabledoc').removeAttribute('hidden')
    let modalEl = document.getElementById('modalDoc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function deleteado(table){
    document.getElementById(table).setAttribute('hidden', 'hidden')
}

function saveProfesional(){    
    let pro = document.getElementById('profS')
    let car = document.getElementById('caracter')
    if(pro.value != 'sel' && car.value != 'sel'){
        let tr = document.createElement('tr')
        tr.innerHTML = '<td hidden>'+ pro.value +'</td>' +'<td>'+ pro.options[pro.selectedIndex].text +'</td>' + '<td hidden>'+ car.value +'</td>'+ '<td>'+ car.options[car.selectedIndex].text +'</td>'
        let body = document.getElementById('profbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
        document.getElementById('tableprof').removeAttribute('hidden')
        let modalEl = document.getElementById('modalProf')
        let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
        modal.hide();
    }
    else{
        alert('No se pueden guardar campos vacíos.')
    }    

}

function saveFuncionario(){    
    let fun = document.getElementById('funcS')
    let obs = document.getElementById('obsFunc').value
    if(fun.value != 'sel'){
        let tr = document.createElement('tr')
        tr.innerHTML = '<td hidden>'+ fun.value +'</td>' +'<td>'+ fun.options[fun.selectedIndex].text +'</td>' + '<td>'+ obs +'</td>'
        let body = document.getElementById('funcbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
        document.getElementById('tablefunc').removeAttribute('hidden')
        let modalEl = document.getElementById('modalFunc')
        let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
        modal.hide();
    }
    else{
        alert('No se pueden guardar campos vacíos.')
    }    
}

function saveEscribano(){
    let nom = document.getElementById('nomEsc').innerHTML
    let mat = document.getElementById('matEsc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ nom +'</td>' + '<td>'+ mat +'</td>'
    let body = document.getElementById('escbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
    document.getElementById('tableesc').removeAttribute('hidden')
    let modalEl = document.getElementById('modalEsc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function saveBeneficiario(){
    let doc = document.getElementById('dniBef').innerHTML
    let ope =  document.getElementById('opeBef').innerHTML
    let barrio = document.getElementById('barBef').innerHTML 
    let adju = document.getElementById('adjBef').innerHTML
    let apyna = document.getElementById('apynaBef').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ doc +'</td>' + '<td>'+ ope +'</td>' + '<td>'+ barrio +'</td>' + '<td>'+ adju +'</td>' + '<td>'+ apyna +'</td>'
    let body = document.getElementById('benefbody')
    while(body.hasChildNodes()){
        body.removeChild(body.lastChild)
    }
    body.appendChild(tr)
    document.getElementById('tablebenef').removeAttribute('hidden')
    let modalEl = document.getElementById('modalBenef')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function saveDocumento(){
    let id = document.getElementById('idDoc').innerHTML
    let nro = document.getElementById('nroDocu').innerHTML
    let asun = document.getElementById('asuDoc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td hidden>'+ id +'</td>' + '<td>'+ nro +'</td>' + '<td>'+ asun +'</td>'
    let body = document.getElementById('docbody')
        while(body.hasChildNodes()){
            body.removeChild(body.lastChild)
        }
        body.appendChild(tr)
    document.getElementById('tabledoc').removeAttribute('hidden')
    let modalEl = document.getElementById('modalDoc')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.hide();
}

function modificar(){
    let id = document.getElementById('id').innerHTML
    let doc = document.getElementById('nroDoc').value
    let nombre = document.getElementById('nombreCom').value
    let email = document.getElementById('email').value
    let cel = document.getElementById('celular').value
    let tipo = document.getElementById('tipo').value
    let tramite = {'documento' : 0, 'documento_id': null, 'profesional' : 0, 'profesional_id':null, 
    'profesional_car' : null, 'funcionario': 0,'funcionario_id' : null, 'funcionario_obs' : null, 
    'beneficiario' : 0, 'beneficiario_dni' : null, 'beneficiario_ope' : null, 'beneficiario_bar' : null,
    'beneficiario_adj' : null, 'escribano' : 0, 'escribano_mat' : null}
   
    if(! $('#tabledoc').is(':hidden')){
        tramite['documento'] = 1
        tramite['documento_id'] = document.getElementById('tdoc').rows[1].cells[0].innerHTML
    }
    if(! $('#tableprof').is(':hidden')){
        tramite['profesional'] = 1
        tramite['profesional_id']= document.getElementById('tprof').rows[1].cells[0].innerHTML
        tramite['profesional_car'] = document.getElementById('tprof').rows[1].cells[2].innerHTML
    }
    if(! $('#tablefunc').is(':hidden')){
        tramite['funcionario']= 1
        tramite['funcionario_id']= document.getElementById('tfunc').rows[1].cells[0].innerHTML
        tramite['funcionario_obs']= document.getElementById('tfunc').rows[1].cells[2].innerHTML
    }
    if(! $('#tablebenef').is(':hidden')){
        tramite['beneficiario']= 1
        tramite['beneficiario_dni']= document.getElementById('tbenef').rows[1].cells[0].innerHTML
        tramite['beneficiario_ope']= document.getElementById('tbenef').rows[1].cells[1].innerHTML
        tramite['beneficiario_bar']= document.getElementById('tbenef').rows[1].cells[2].innerHTML
        tramite['beneficiario_adj']= document.getElementById('tbenef').rows[1].cells[3].innerHTML
    }
    if(! $('#tableesc').is(':hidden')){
        tramite['escribano']= 1
        tramite['escribano_mat']= document.getElementById('tesc').rows[1].cells[1].innerHTML
    }

    console.log(tramite)
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/modificar',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            doc: doc,
            nombre: nombre,
            email:email,
            cel:cel,
            tipo:tipo,
            id:id,
            tramite: JSON.stringify(tramite)
        }),
        dataType: 'json',
        success: function(res){          
            console.log(res)
            alert('Tramite modificado con éxito.')    
            window.location.href = "/tramite/" + id + "/movimientos"; 
        },
        error: function(res){
            console.log(res)
        }
    }); 
}

window.addEventListener("DOMContentLoaded", (event) => {
    let btn = document.getElementById('btnguardar')
    let doc = document.getElementById('nroDoc')
    let nombre = document.getElementById('nombreCom')
    let email = document.getElementById('email')
    let cel = document.getElementById('celular')
    let tramite = document.getElementById('tipo')

    const checkGuardar = () => {
        if(doc.value != '' && nombre.value != '' && (email.value != '' || cel.value != '') && tramite.value != 'sel'){
            btn.removeAttribute('disabled')
        }
        else{
            btn.setAttribute('disabled', 'disabled')
        }
    }
   
    doc.addEventListener('keyup', checkGuardar)
    nombre.addEventListener('keyup', checkGuardar)
    email.addEventListener('keyup', checkGuardar)
    cel.addEventListener('keyup', checkGuardar)
    tramite.addEventListener('change', checkGuardar)
});

function cancelar(){
    document.getElementById('preview').setAttribute('hidden', 'hidden')
}

function abrirModificarMovimiento(id, obs, med){
    let modalEl = document.getElementById('modalMov')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
    document.getElementById('obs2').value = obs
    document.getElementById('medio2').value = med
    document.getElementById('idmov').innerHTML = id;
} 

function modificarMovimiento(){
    let obs = document.getElementById('obs2').value
    let medio = document.getElementById('medio2').value
    let id = document.getElementById('id').innerHTML
    let idmov=document.getElementById('idmov').innerHTML
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tramite/modificarMovimiento',
        type: 'POST',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            obs:obs,
            medio:medio,
            id:id,
            idmov:idmov
        }),
        dataType: 'json',
        success: function(res){   
            alert('El movimiento se actualizó con éxito')           
            console.log(res)            
            actualizarTabla()
        },
        error: function(res){
            console.log(res)
        }
    }); 
}