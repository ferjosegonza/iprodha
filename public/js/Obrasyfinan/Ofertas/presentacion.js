
$(document).ready(function () {
    $('#crono').DataTable({
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No se han encontrado registros',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'No se han encontrado registros',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            paginate:{
                first:"Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },
        order: [[ 0, 'asc' ]],
    });
});

$(document).ready(function () {
    $('#example').DataTable({
        "bSort":false,
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No se han encontrado registros',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'No se han encontrado registros',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            paginate:{
                first:"Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },
        order: [[ 1, 'asc' ]],
    });
});


$(document).ready(function () {
    var table = $('#items').DataTable({
        //ajax: '/ofeobra/{idobra}/presentar',
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            { data: 'orden' },
           
            { data: 'item' },
            { data: 'tipo' },
            { data: 'monto' },
             { data: 'id',
            searchable: false,
            visible: false }
        ],
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'No se han encontrado registros',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'No se han encontrado registros',
            infoFiltered: '(Filtrado de _MAX_ registros totales)',
            search: 'Buscar',
            paginate:{
                first:"Prim.",
                last: "Ult.",
                previous: 'Ant.',
                next: 'Sig.',
            },
        },
        order: [[ 1, 'asc' ]],
    });
    // Add event listener for opening and closing details
    $('#items tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row             
                row.child(format(row.data())).show();                
                //console.log(row.data());
                tr.addClass('shown');
                //console.log(tr);
        }
    });
});


function format ( rowData ) {
    var div = $('<div/>')
        .addClass( 'loading' )
        //.text( 'Loading...' );
    let route = '/ofeobra/'+rowData.obra+'/items/'+rowData.id;
    //let route= 'ofeobra.subitems';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax( {
        type: "GET",
        url: route,
        cache: false,
        data: JSON.stringify({
            _token: $('#signup-token').val(),
            iditem: rowData.id
        }),
        dataType: 'json',
        success: function (json) { 
            let USDollar = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',});
            div.removeClass('loading');  
            //console.log(json);                    
            //console.log( Object.keys(json.response.data).length); 
            div.html(json.html);                 
            //div.addClass('class="col-xs-12 col-sm-12 col-md-12"');
            div.append('<div class="table-responsive subitems' + rowData.id + '">');
            $(".subitems"+rowData.id).append("<table class='table table-hover mt-2 tablasubitems" +rowData.id +"' class='display'> <thead> <th class='text-center' scope='col' style='color:#fff;width:20%;height:25px;'>Denominación</th> <th class='text-center' scope='col' style='color:#fff;width:20%;height:25px;'>Costo unitario</th> <th class='text-center' scope='col' style='color:#fff;width:20%;height:25px;'>Cantidad</th> <th class='text-center' scope='col' style='color:#fff;width:20%;height:25px;'>Monto Total</th> </thead>");
            
            $(".tablasubitems"+rowData.id).append(' <tbody> ')
            $.each(json.response.data, function(index) {                    
                $(".tablasubitems"+rowData.id).append("<tr>" + 
                "<td class= 'text-center' style='width:25%;height:25px;'> " + json.response.data[index].denominacion + " </td> " 
                +  "<td class= 'text-center' style='width:25%;height:25px;'> " + USDollar.format(json.response.data[index].costounitario) + " </td> "  
                +  "<td class= 'text-center' style='width:25%;height:25px;'> " +json.response.data[index].cantidad + " </td> "
                +  "<td class= 'text-center' style='width:25%;height:25px;'> " + USDollar.format(json.response.data[index].cantidad * json.response.data[index].costounitario) + " </td> "  
                + "</tr> ");                    
            });     
            $(".tablasubitems"+rowData.id).append("</tbody>");
            $(".subitems"+rowData.id).append("</table> </div>");
            
            
        },   
        error: function(response){
            //console.log(response);
        }         
    });     
    //console.log(response);
    //console.log(div);
    return div;
}

$(".formulario").on('submit', function(evt){
    evt.preventDefault();  
    $('#presentar').attr('action',$(this).attr("action"));
    $('#exampleModalCo').modal('show');    
});

$(document).ready(function pintarTabla() {
    var t = $('#cronogramaa').DataTable({
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
            
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
   
              // converting to interger to find total
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
   
              // computing column Total of the complete result
            var variables = {};
            var prefijo = 'mes';
            for (var i = 1; i <= contadorMes; i++) {
                variables[prefijo + i] = api
                    .column( i+1 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
            };
              
                  
              // Update footer by showing the total with the reference of the column index 
          $( api.column( 1 ).footer() ).html('TOTAL MES').addClass('text-center');
          for (var i = 1; i <= contadorMes; i++) {
            $( api.column( i+1 ).footer() ).html(variables['mes'.concat('', i)].toFixed(4)).addClass('text-center');
          } 
          
            //    $( api.column( 1 ).footer() ).html(monTotal.toFixed(2));
            //    $( api.column( 2 ).footer() ).html(variables['mes1'].toFixed(2));
            //    $( api.column( 3 ).footer() ).html(wedTotal.toFixed(2));
            //   $( api.column( 4 ).footer() ).html(thuTotal.toFixed(2));
            //   $( api.column( 5 ).footer() ).html(importeTotal.toFixed(2));
            //   $( api.column( 6 ).footer() ).html(costoTotal.toFixed(8));
          },
    });
});