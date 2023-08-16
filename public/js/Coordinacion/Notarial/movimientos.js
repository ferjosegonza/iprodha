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
});

function checkGuardar(){
    let btn = document.getElementById('btnSave')
    let sel = document.getElementById('medio')
    let inp = document.getElementById('obs')
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