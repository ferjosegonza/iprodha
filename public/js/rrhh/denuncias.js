$(document).ready(function (){
//window.addEventListener("DOMContentLoaded", (event) =>
    $('#example').DataTable({
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

function limpiarFormDenuncia() {
    console.log('BotonModal clickeado');
    $('#id_modif').empty();

    var fechaActual = new Date().toISOString().split('T')[0];
    $('#fecha').val(fechaActual);

    $('#denuncia_extracto').empty();
    $('#denuncia_descripcion').empty();
}

$('#botonCerrar').on('click', function () {
    location.reload(true);
    //limpiarFormDenuncia();
});

/*$('#botonModal').on('click', function () {
    //location.reload(true);
    //limpiarFormDenuncia();
});*/


/*$('#example tbody').on('click', '.borrar-denuncia', function (e) {
    e.stopPropagation(); // Evita que el evento se propague a la fila
    // Resto del código para borrar la denuncia (código anterior)
});*/

$('.btn-ver-denuncia').on('click', 'tr',function () {
    //e.stopPropagation();
    //if (!$(e.target).hasClass('borrar-denuncia')) {
        $('#exampleModalLabel').text('VER DENUNCIA');
        $('#guardar_denuncia').text('MODIFICAR');
        // Obtener los datos de la fila clickeada
        var idDenuncia = $(this).data('id_denuncia');
        var fecha = $(this).data('fecha');
        var extracto = $(this).data('extracto');
        var descripcion = $(this).data('descripcion');
        var fechaParaMostrar = fecha ? fecha.substr(0, 10) : ''; // Verificar si fecha tiene valor

        alert('idDenuncia: '+idDenuncia+ '\nfecha: fecha' + '\nextracto: '+extracto);

        // Rellenar el formulario del modal con los datos a updetear
        $('#id_modif').val(idDenuncia);
        $('#fecha').val(fechaParaMostrar);
        $('#denuncia_extracto').val(extracto);
        $('#denuncia_descripcion').val(descripcion);

        // Agregar la acción de editar al formulario del modal
        var form = $('#modalDenuncia form');
        //form.attr('action', '/denuncia/editar/' + idDenuncia);

        /*var datosActuales = '<h6>Datos actuales:</h6>'+
                            '<b>Fecha:</b> '+fechaParaMostrar+
                            '<br><b>Extracto:</b> '+extracto+
                            '<br><b>Descripción:</b> '+descripcion;
        $('#modifDenuncia').html(datosActuales);*/
    //}
});
