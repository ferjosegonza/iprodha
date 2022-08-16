$("#periodo").change(function () {
    $("#buscar1").css("display", 'block');

    $("#buscar").css("display", 'none');
    $("#empresa").css("display", 'none');
    $("#programa").css("display", 'none');

    $("#empresa").empty().append('<option selected >Empresas</option>');
    $("#programa").empty().append('<option selected >Programas</option>');
    $("#empresa").attr("placeholder", "Empresas");
    $("#programa").attr("placeholder", "Programas");

});

$('#buscar1').click(function () {

    var periodo = $("#periodo").val();
    $("#buscar1").css("display", 'none');

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/estadoobrasempresas",
        data: {
            periodo: periodo
        },
        success: function (response) {
            response.forEach(element => {
                console.log(element.nom_emp);
                $("#empresa").append("<option value='" + element.nom_emp + "' >" + element.nom_emp + "</option>");
            });
            
        },
        error: function (error) {
            console.log(error);
        }
    }));

    $.when($.ajax({
        type: "post",
        url: "http://192.168.10.84/estadoobrasprogramas",
        data: {
            periodo: periodo
        },
        success: function (response) {
            response.forEach(element => {
                console.log(element.operatoria);
                $("#programa").append("<option value='" + element.operatoria + "' >" + element.operatoria + "</option>");
            });
            
        },
        error: function (error) {
            console.log(error);
        }
    }));

    $("#programa").css("display", 'block');
    $("#empresa").css("display", 'block');
    $("#buscar").css("display", 'block');
    

});
