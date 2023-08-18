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

function saveProfesional(){    
    let pro = document.getElementById('profesional')
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
    let fun = document.getElementById('funcionario')
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
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].exp_doc_id+'", "' + res[i].exp_numero + '", "'+res[i].exp_asunto+'")')
                        }
                        else{
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].not_doc_id+'", "' + res[i].not_numero +'", "'+res[i].not_asunto+'")')
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

function guardar(){
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
        url: '/tramite/crear',
        type: 'PUT',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            doc: doc,
            nombre: nombre,
            email:email,
            cel:cel,
            tipo:tipo,
            tramite: JSON.stringify(tramite)
        }),
        dataType: 'json',
        success: function(res){          
            alert('Tramite creado con éxito.')    
            window.location.href = "/notarial/bandeja";
        },
        error: function(res){
            console.log(res)
        }
    }); 

}

function deleteado(table){
    document.getElementById(table).setAttribute('hidden', 'hidden')
}