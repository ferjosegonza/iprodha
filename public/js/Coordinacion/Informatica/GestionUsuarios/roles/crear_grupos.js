
        $('#visible').on('change', function() {

            $('#menus').html('');
            if ($('#visible').val() == 0) {
                html = '<div class="row ms-3 mt-3">' +
                    '<div class="col-xs-12">' +
                    '<label class="col-xs-12">Seleccione un Menu:</label>' +
                    '</div>' +
                    '<div class="col-xs-12 col-sm-12 col-md-6 ">' +
                    '</div>' +
                    '</div>';
                $('#menus').append(html);
                buscarmenus();
            } else {
                $('#menus').html('');
            }
        });
        var currentValueRadio = -1;

        function handleRadioClick(myRadio) {
            $('#btnnuevo').click();
            if (myRadio != currentValueRadio) {
                $('#check' + myRadio).css("color", "#fc271c");
                $("#check" + currentValueRadio).css("color", "#fff ");
                //$("#check"+currentValueRadio).css("color", "#6C757D ");
                currentValueRadio = myRadio;
            }
        }

        
        function nuevomenu() {
            $("#btnguardar" ).removeClass( "btn-warning btn-danger" ).addClass( "btn-success" );
            $("#nomvista").prop("disabled", false);
            $("#path").prop("disabled", false);
            $("#nomarchivo").prop("disabled", false);
            $("#nomarchivo").val('');
            $("#rol-permiso-automatico").prop("disabled", false);
            $("#path").val('');
            $("#nomvista").val('');
            $("#rol-permiso-automatico").val('');
            $('#btnguardar').prop('disabled',false)
            $("#menuhoja").prop("disabled", false);
            $("#idmenupadre").prop("disabled", false);

            
            $("#permiso").css("display", "none");
            $("#rooles").css("display", "none");
                        
            $("#name").prop("disabled", false);
            $('#edit').val(0)
        }
        function editar() {
            $("#btnguardar" ).removeClass( "btn-warning btn-success" ).addClass( "btn-danger" );
            $('#btnguardar').prop('disabled',false)
            $("#menuhoja").prop("disabled", true)
            $("#idmenupadre").prop("disabled", true);
            $('#edit').val(1)
        }
        $(document).ready(function () {
            $('#tags').select2({ 
                language: {
                    errorLoading: function() {
                        return "No hay resultado";
                    },
                    loadingMore: function() {
                    return "Cargando mas resultados";
                    },
                    inputTooShort: function () {
                        return "Debe ingresar mas caracteres..";
                    },
                    noResults: function() {
                    return "No hay resultado";        
                    },
                    searching: function() {
                    return "Buscando..";
                    }
                    },
                ajax: {
                    dataType: 'json',
                    url: 'http://192.168.10.84/roles/vistas',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function (response) {
                    return {
                        results: response
                    }
                    },
                    cache:true
                }
            });
            
        });
        var rol = '';
        function buscarvista() {
            nombre = $('#nomvista').val().toUpperCase();
            if (nombre=='') {
                $('#path').val('');
                $('#nomarchivo').val('');                 
                $('#rr'+vista.rol).prop('checked', false);
                $("#permiso").css("display", "none");
                $("#rooles").css("display", "none");
                return
            }
            $.ajax({
                type: "get",
                url: "http://192.168.10.84/roles/buscarvista",
                data: {
                    nombre: nombre
                },
                success: function(response) {
                    if (response.vista) {
                        vista = response.vista;
                        $('#path').val(vista.path);
                        $('#nomarchivo').val(vista.nomarchivo);                 
                        $('#rr'+vista.rol).click();
                        rol=vista.rol;
                        $("#permiso").css("display", "block");
                        $("#rooles").css("display", "block");
                    }else{        
                        $('#path').val('');
                        $('#nomarchivo').val('');                 
                        $("#permiso").css("display", "none");
                        $("#rooles").css("display", "none");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };


        function buscarpermisos(id) {
            $.when($.ajax({
                type: "post",
                url: "http://192.168.10.84/usuarios/buscarpermisosdelrol",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#permisos").remove();
                    html = '<ul class="ms-4" id="permisos">';
                    response.forEach(element => {
                        html = html + '<li id="li' + element.name +
                            '" class="my-0 "><label class="my-0" id="3' + element.name + '">' +
                            element.name + '</label></li>';
                    });
                    html = html + '</ul>';
                    $("#lista_permisos").append(html);
                    //$("#r"+id).prop('disabled',false);
                },
                error: function(error) {
                    console.log(error);
                }
            }));
        };

        function buscarroles(val) {
            var estilo = '';
            if (val == 2) {
                estilo = 'text-danger';
            }
            var nameroles = $("#nameroles").val();
            $.when($.ajax({
                type: "post",
                url: "http://192.168.10.84/usuarios/rolesconpermisos",
                data: {
                    name2: nameroles
                },
                success: function(response) {

                    $("#radio tr").each(function(index) {
                        if (!$(this).find('td:nth-child(2)').find('input:nth-child(1)').prop(
                                'checked')) {
                            $(this).remove()
                        }
                    });

                    html = '';
                    response.forEach(element => {
                        html = '<tr id="trradio' + element.id +
                            '"><td style="width: 90%"><label><input onclick="buscarpermisos(' +
                            element.id + ')" id="rr' + element.id +
                            '" class="name " name="roless" type="radio" value="' + element.id +
                            '">  ' + element.name + '</label></td></tr>';
                        $("#radio").append(html);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            }));

        };

        function cargarMenu(e) {
            
            $('#id').val('');
            $('#name').val('');
            $('#nomvista').val('');
            $('#path').val('');
            $('#nomarchivo').val('');
            $('#nomvista').val('');
            $('#registro').val(0);
            $('#menuhoja').val(1);                        
            $("#menuhoja").prop("disabled", false);
            $("#idmenupadre").prop("disabled", false);
            $('#rol-permiso-automatico').val('');
            $("#vvista").css("display", "none");
            $("#permiso").css("display", "none");
            $("#rooles").css("display", "none");
            $.ajax({
                type: "post",
                url: "http://192.168.10.84/roles/buscarmenu",
                data: {
                    id: e
                },
                success: function(response) {
                    menu = response.menupadre;
                    orden = response.orden;
                    if (menu.tipo != 0) {
                        $("#idmenupadre").val(menu.idmenu);
                        $('#orden').html('');
                        html = '<option value=""></option>';

                        $.each(orden, function(index, value) {
                            html = html + '<option value="' + index + '">' + index + '</option>';
                        });
                        html = html + '<option value="' + orden.length + '">' + orden.length +
                        ' Nuevo</option>';
                        $('#orden').html(html);
                        $("#orden").val(orden.length);
                        $("#visibles").val(1);
                    } else {
                        $('#orden').html('');
                        $("#visibles").val(1);
                    }

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        $('#menuhoja').on('change', function() {
                $("#menuhoja").prop("disabled", false);
                
            if ($('#menuhoja').val() == 0) {
                $("#vvista").css("display", "block");
            } else {
                $("#vvista").css("display", "none");
                $("#permiso").css("display", "none");
                $("#rooles").css("display", "none");
            }
        });
        $('#rol-permiso-automatico').on('change', function() {
            if ($('#rol-permiso-automatico').val() == 0) {
                $("#permiso").css("display", "block");
                $("#rooles").css("display", "block");
            } else {
                $("#permiso").css("display", "none");
                $("#rooles").css("display", "none");
            }
        });


        function eliminarmenu(nom,id) {
                //obtengo el nombre
                let nombre = nom;
                //cambio los valores del modal -- ruta -- mensaje
                $('#eliminar').attr('action','http://192.168.10.84/roles/eliminarmenu/'+id);
                $('#contenidoModal').text('Seguro que desea Eliminar el Menu \"'+nombre+'\"');
                $('#exampleModal').modal('show');
        }

        function buscarmenus() {
            $.ajax({
                type: "post",
                url: "http://192.168.10.84/roles/buscarmenus",
                data: {},
                success: function(response) {
                    console.log(response);
                    $("#menus").html('');
                    html = '<ul style="list-style: none;" id="vista">';

                    response.forEach(element => {

                        if ($('.vistacheck' + element.id).is(':checked')) {
                            html = html + '<li id="li' + element.idvista +
                                '" class="my-0 "><label class="my-0" ><input id="v' + element.idvista +
                                '" checked onclick="" class="name me-2 radiocheck' + element.idvista +
                                '" name="vista" type="radio" value="' + element.idvista + '">' + element
                                .nomvista + '</label></li>';
                        } else {
                            html = html + '<li id="li' + element.idvista +
                                '" class="my-0 "><label class="my-0" ><input id="v' + element.idvista +
                                '" onclick="" class="name me-2 radiocheck' + element.idvista +
                                '" name="vista" type="radio" value="' + element.idvista + '">' + element
                                .nomvista + '</label></li>';
                        }
                    });
                    html = html + '</ul>';
                    $("#menus").append(html);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        
        function editarmenu(id) {
            
            $('#btneditar').click();
            $('#registro').val(1);
            $('#id').val(id);
            $.ajax({
                type: "post",
                url: "http://192.168.10.84/roles/editarmenu",
                data: {
                    id: id
                },
                success: function(response) {
                    MenuM = response.MenuM;
                    $('#name').val(MenuM.nommenu);

                    $("#idmenupadre").val(MenuM.idmenupadre);
                    $.when($.ajax({
                        type: "post",
                        url: "http://192.168.10.84/roles/buscarordengrupo",
                        data: {
                            id: $('#idmenupadre').val()
                        },
                        success: function(response) {
                            let html = '';
                            let cant = 0;
                            $("#orden").html('');
                            response.forEach(element => {

                                cant = cant + 1;
                                html = html + '<option  value="' + element.orden + '">' + element
                                    .orden + '</option>';
                            });
                            html = html + '<option value="' + cant + '">' + cant + ' Nuevo</option>';
                            $("#orden").append(html);
                            $("#orden").val(cant);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })).then(function( x ) {
                        $("#orden").val(MenuM.orden);
                        });
                    

                    $("#visibles").val(MenuM.visible);
                    
                    if (MenuM.tipo == 0) {
                        
                        $("#name").prop("disabled", false);
                        $("#nomvista").prop("disabled", true);
                        $("#path").prop("disabled", true);
                        $("#nomarchivo").prop("disabled", true);
                        $("#rol-permiso-automatico").prop("disabled", true);
                        rol = response.rol;
                        permiso = response.permiso;
                        $("#menuhoja").val(0);
                        vista = response.Grant_vista;
                        $('#path').val(vista.path);
                        $('#nomvista').val(vista.nomvista);
                        $('#nomarchivo').val(vista.nomarchivo);                 
                        $('#rr'+vista.rol).click();
                        $('#namepermiso').val(permiso.name);
                        $('#namepermisobtn').click();
                        setTimeout(function() { 
                            $('.permisoscheck'+permiso.id).prop('checked', true);
                            $("#permiso").css("display", "block");
                        }, 1000);
                        $("#rooles").css("display", "block");
                        $("#vvista").css("display", "block");

                    }else{
                        
                        $("#name").prop("disabled", false);
                        $("#nomvista").prop("disabled", false);
                        $("#path").prop("disabled", false);
                        $("#nomarchivo").prop("disabled", false);
                        $("#rol-permiso-automatico").prop("disabled", false);

                        $("#menuhoja").val(1);
                        $("#menuhoja").prop("disabled", true);
                        
                        $("#idmenupadre").prop("disabled", true);
                        $('#nomvista').val('');
                        $('#path').val('');
                        $('#nomarchivo').val(''); 
                        $('#namepermiso').val('');   
                        $('#namepermisobtn').click();            
                        $("#permiso").css("display", "none");
                        $("#rooles").css("display", "none");
                        $("#vvista").css("display", "none");
                    }
                    

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function buscarpermisosname() {
            $("#checkpermisos").prop('checked', false);
            var namepermiso = $("#namepermiso").val();
            $.when($.ajax({
                type: "post",
                url: "http://192.168.10.84/usuarios/buscarpermisos",
                data: {
                    name3: namepermiso
                },
                success: function(response) {
                    console.log(response)
                    $("#permisos2").empty();
                    response.forEach(element => {
                        html = '<label id="2' + element.name +
                            '"><input class="name permisos10 permisoscheck' + element.id +
                            '" name="permiso" type="radio" value="' + element.id + '">  ' + element
                            .name + '</label>';
                        $("#permisos2").append(html);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            }));
        };
        

        $('#idmenupadre').on('change', function() {
            $.ajax({
                type: "post",
                url: "http://192.168.10.84/roles/buscarordengrupo",
                data: {
                    id: $('#idmenupadre').val()
                },
                success: function(response) {
                    console.log(response);
                    let html = '';
                    let cant = 0;
                    $("#orden").html('');
                    response.forEach(element => {

                        cant = cant + 1;
                        html = html + '<option  value="' + element.orden + '">' + element
                            .orden + '</option>';
                    });
                    html = html + '<option value="' + cant + '">' + cant + ' Nuevo</option>';
                    $("#orden").append(html);
                    $("#orden").val(cant);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        });
        