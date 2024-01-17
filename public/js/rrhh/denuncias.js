//alert('sdf');

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

    // $('#modalDenuncia').on('shown.bs.modal', function () {
    //     $('#fecha').focus();
    // });

    // // Limpiar el formulario cuando se cierra el modal
    // $('#modalDenuncia').on('hide.bs.modal', function () {
    //     limpiarFormDenuncia();
    // });

    // cerrarAmbosModalesDenuncia();

    // Función p/ cerrar el modal al hacer clic en cualq parte fuera del modal
    /*$(document).on('click', function (e) {
        if ($(e.target).closest('.modal').length === 0 && $(e.target).closest('.btn-ver-denuncia').length === 0){
            location.reload(true);
        }
    })*/
});


// function limpiarFormDenuncia() {
//     //$('#id_modif').val('');
//     $('#denuncia_extracto').val('');
//     $('#denuncia_descripcion').val('');
//     //$('#form_nva_denuncia').attr('method', 'post');
//     //$('#form_nva_denuncia').attr('route', 'denuncia.guardar');
//     // $('#id_modif').empty();
//     // $('#denuncia_extracto').empty();
//     // $('#denuncia_descripcion').empty();

//     var fechaActual = new Date().toISOString().split('T')[0];
//     $('#fecha').val(fechaActual);
// }

// $('#botonCerrar').on('click', function () {
//     location.reload(true);
//     //limpiarFormDenuncia();
// });


// function abrirModalDenunciaNueva() {
//     $('#modalNuevaDenuncia').modal('show');
//     $('#modalModificarDenuncia').modal('hide');
// }

// function abrirModalModificarDenuncia() {
//     $('#modalNuevaDenuncia').modal('hide');
//     $('#modalModificarDenuncia').modal('show');
// }

// function cerrarAmbosModalesDenuncia() {
//     $('#modalNuevaDenuncia').modal('hide');
//     $('#modalModificarDenuncia').modal('hide');
// }

// function cargarModal(id_denuncia, fecha, extracto, descripcion, titulo) {
//     abrirModalDenunciaNueva();
//     $('#id_modif').val(id_denuncia);
//     $('#exampleModalLabel').text(titulo+' DENUNCIA');
//     var fechaParaMostrar = fecha ? fecha.substr(0, 10) : '';
//     $('#fecha').val(fechaParaMostrar);
//     $('#denuncia_extracto').val(extracto);
//     $('#denuncia_descripcion').val(descripcion);
// }

// function desactivarModal() {
//     $('#fecha, #denuncia_extracto, #denuncia_descripcion').prop('readonly', true);
//     $('#denuncia_caracteres').hide();
//     $('#elementos_caracteres').hide();
//     $('#guardar_denuncia').hide();
// }

// function activarModal() {
//     $('#fecha, #denuncia_extracto, #denuncia_descripcion').prop('readonly', false);
//     $('#denuncia_caracteres').show();
//     $('#elementos_caracteres').show();
//     $('#guardar_denuncia').show();
// }

// function verDenuncia(id_denuncia, fecha, extracto, descripcion) {
//     cargarModal(id_denuncia, fecha, extracto, descripcion, 'VER');
//     desactivarModal();
//     $('#modal-nueva-denuncia').css('display', 'block');
//     $('#modal-modif-denuncia').css('display', 'none');
// }

// function modificarDenuncia(id_denuncia, fecha, extracto, descripcion) {
//     //let newFecha = fecha.substr(0, 10);
//     //alert('id_denuncia: '+id_denuncia+'\nfecha: '+fecha+'\nnewFecha'+newFecha+'\nextracto: '+extracto+'\ndescripcion: '+descripcion);
//     activarModal();
//     $('#modal-nueva-denuncia').css('display', 'none');
//     $('#modal-modif-denuncia').css('display', 'block');
//     //cargarModal(id_denuncia, newFecha, extracto, descripcion, 'MODIFICAR');
//     // let action = $('#form_nva_denuncia').attr('action');
//     // action = action.substring(0, action.lastIndexOf('/')+1)+'modificar';
//     // $('#form_nva_denuncia').attr('action', action);
//     // $('#form_nva_denuncia').attr('method', 'PUT');
//     // $('#form_nva_denuncia').attr('route', 'denuncia.modificar');
//     // $('#form_nva_denuncia').querySelector('input[name="_method"]').value = 'PUT';

//     // var form = document.getElementById('form_denuncia');
//     // form.querySelector('input[name="_method"]').value = 'PUT';
// }

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
