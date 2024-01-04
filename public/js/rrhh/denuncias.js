//alert('sdf');

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

    $('#modalDenuncia').on('shown.bs.modal', function () {
        $('#fecha').focus();
    });

    // Limpiar el formulario cuando se cierra el modal
    $('#modalDenuncia').on('hide.bs.modal', function () {
        limpiarFormDenuncia();
    });

    // Función p/ cerrar el modal al hacer clic en cualq parte fuera del modal
    /*$(document).on('click', function (e) {
        if ($(e.target).closest('.modal').length === 0 && $(e.target).closest('.btn-ver-denuncia').length === 0){
            location.reload(true);
        }
    })*/
});


function limpiarFormDenuncia() {
    $('#id_modif').val('');
    $('#denuncia_extracto').val('');
    $('#denuncia_descripcion').val('');
    // $('#id_modif').empty();
    // $('#denuncia_extracto').empty();
    // $('#denuncia_descripcion').empty();

    var fechaActual = new Date().toISOString().split('T')[0];
    $('#fecha').val(fechaActual);

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

function cargarModal(id_denuncia, fecha, extracto, descripcion, titulo) {
    $('#modalDenuncia').modal('show');
    $('#id_modif').val(id_denuncia);
    $('#exampleModalLabel').text(titulo+' DENUNCIA');
    var fechaParaMostrar = fecha ? fecha.substr(0, 10) : '';
    $('#fecha').val(fechaParaMostrar);
    $('#denuncia_extracto').val(extracto);
    $('#denuncia_descripcion').val(descripcion);
}

function desactivarModal() {
    $('#fecha, #denuncia_extracto, #denuncia_descripcion').prop('readonly', true);
    $('#denuncia_caracteres').hide();
    $('#elementos_caracteres').hide();
    $('#guardar_denuncia').hide();
}

function activarModal() {
    $('#fecha, #denuncia_extracto, #denuncia_descripcion').prop('readonly', false);
    $('#denuncia_caracteres').show();
    $('#elementos_caracteres').show();
    $('#guardar_denuncia').show();
}

function verDenuncia(id_denuncia, fecha, extracto, descripcion) {
    cargarModal(id_denuncia, fecha, extracto, descripcion, 'VER');
    desactivarModal();
}

function modificarDenuncia(id_denuncia, fecha, extracto, descripcion) {
    cargarModal(id_denuncia, fecha, extracto, descripcion, 'MODIFICAR');
    activarModal();
}

/*$('.btn-ver-denuncia').on('click', function () {
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
/*});*/
