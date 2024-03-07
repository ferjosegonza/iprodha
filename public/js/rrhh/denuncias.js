$(document).ready(function (){
//window.addEventListener("DOMContentLoaded", (event) =>
    $('#tabla-lista-denuncias').DataTable({
        language: {
                lengthMenu: 'Mostrar _MENU_ registros por pagina',
                zeroRecords: 'No se ha encontrado registros',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No se ha encontrado registros',
                infoFiltered: '(Filtrado de _MAX_ registros totales)',
                search: 'Buscar',
                paginate:{
                    first:"Prim.",
                    last: "Ult.",
                    previous: 'Ant.',
                    next: 'Sig.',
                },
            },
            "aaSorting": []
    });
});

// Muestra y oculta los submenús al hacer clic en los botones
document.getElementById('dropdownDenunciante').addEventListener('click', function () {
    document.getElementById('dropdownDenunciante').classList.toggle('show');
});

document.getElementById('dropdownVictima').addEventListener('click', function () {
    document.getElementById('dropdownVictima').classList.toggle('show');
});

document.getElementById('dropdownDenunciado').addEventListener('click', function () {
    document.getElementById('dropdownDenunciado').classList.toggle('show');
});


function confirmarBorrado(event, es_victima, id_denuncia) {
    let mensaje = '';
    if (es_victima){
        mensaje = 'Tenga en cuenta que el Denunciante es también Víctima, se borrarán ambos registros. ¿Confirma?';
    } else {
        mensaje = '¿Confirma que desea borrar el registro?';
    }

    if (confirm(mensaje)) {
        // Si el usuario confirma, permitimos el envío del formulario
        return true;
    } else {
        // Si el usuario cancela, preventimos el envío del formulario
        event.preventDefault();
        return false;
    }
}