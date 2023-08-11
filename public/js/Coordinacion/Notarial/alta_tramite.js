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
        document.getElementById('profbody').appendChild(tr)
        document.getElementById('tableprof').removeAttribute('hidden')
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
        document.getElementById('funcbody').appendChild(tr)
        document.getElementById('tablefunc').removeAttribute('hidden')
    }
    else{
        alert('No se pueden guardar campos vacíos.')
    }    
}

function buscarEscribano(){  
    let nom = document.getElementById('nomes').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/notarial/escribano',
        type: 'GET',
        cache: false,
        data: ({
            _token: $('#signup-token').val(),
            nom:nom
        }),
        dataType: 'json',
        success: function(res){              
            console.log(res)
            if(res.length>0){
                let body = document.getElementById('bodyesc')
                for(let i=0; i<res.length; i++){
                    let email
                    if(res[i].email == null){
                        email = '-'
                    } 
                    else{
                        email= res[i].email
                    }
                    let tr=document.createElement('tr')
                    tr.innerHTML='<td>'+res[i].nombre+'</td><td>'+res[i].matricula+'</td><td>'+res[i].cuit+'</td><td>'+res[i].telef1+'</td><td>'+email+'</td>'
                    tr.className= 'hoverable'
                    tr.setAttribute('onclick', 'seleccionarEscribano("'+res[i].matricula+'","'+res[i].nombre+'")')
                    body.appendChild(tr)
                }
                document.getElementById('resultadoEsc').removeAttribute('hidden')
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

function seleccionarEscribano(mat, nom){  
    document.getElementById('nomEsc').innerHTML = nom 
    document.getElementById('matEsc').innerHTML = mat
    document.getElementById('EscSeleccionado').removeAttribute('hidden')
    document.getElementById('resultadoEsc').setAttribute('hidden', 'hidden')
}

function saveEscribano(){
    let nom = document.getElementById('nomEsc').innerHTML
    let mat = document.getElementById('matEsc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ nom +'</td>' + '<td>'+ mat +'</td>'
    document.getElementById('escbody').appendChild(tr)
    document.getElementById('tableesc').removeAttribute('hidden')
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
}

function saveBeneficiario(){
    let doc = document.getElementById('dniBef').innerHTML
    let ope =  document.getElementById('opeBef').innerHTML
    let barrio = document.getElementById('barBef').innerHTML 
    let adju = document.getElementById('adjBef').innerHTML
    let apyna = document.getElementById('apynaBef').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td>'+ doc +'</td>' + '<td>'+ ope +'</td>' + '<td>'+ barrio +'</td>' + '<td>'+ adju +'</td>' + '<td>'+ apyna +'</td>'
    document.getElementById('benefbody').appendChild(tr)
    document.getElementById('tablebenef').removeAttribute('hidden')
}

function buscarDocumento(){    
    if(document.getElementById('tipodoc').value != 'sel'){
        let tipo = document.getElementById('tipodoc').value
        let nro = document.getElementById('nrodoc').value
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
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].exp_doc_id+'","'+res[i].exp_numero+'","'+res[i].exp_asunto+'")')
                        }
                        else{
                            tr.setAttribute('onclick', 'seleccionarDocumento("'+res[i].not_doc_id+'","'+res[i].not_numero+'","'+res[i].not_asunto+'")')
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
    document.getElementById('idDoc').innerHTML = id
    document.getElementById('nroDoc').innerHTML = nro
    document.getElementById('asuDoc').innerHTML = asun
    document.getElementById('DocSeleccionado').removeAttribute('hidden')
    document.getElementById('resultadoDoc').setAttribute('hidden','hidden')
}

function saveDocumento(){
    let id = document.getElementById('idDoc').innerHTML
    let nro = document.getElementById('nroDoc').innerHTML
    let asun = document.getElementById('asuDoc').innerHTML
    let tr = document.createElement('tr')
    tr.innerHTML = '<td hidden>'+ id +'</td>' + '<td>'+ nro +'</td>' + '<td>'+ asun +'</td>'
    document.getElementById('docbody').appendChild(tr)
    document.getElementById('tabledoc').removeAttribute('hidden')
}