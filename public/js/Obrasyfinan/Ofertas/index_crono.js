// var t = $('#example').DataTable();
$(function(){
    $('#mes').on('change', onSelectMesChange);
    $('#addRow').on('click', nuevoCrono);
    $('#item').on('change', mostrarAcumulado);
});

function nuevoCrono(){
  let mes = $("#mes").val();
  let avance = $("#avance").val();
  let item = $("#item").val();

  if(mes != null && item != 0){
    $.when($.ajax({
        type: "post",
        url: '/ofecrono/'+mes+'/'+item+'/buscar',
        data: {
             mes: mes,
             item: item,
             avance: avance,
         },
        success: function (response) {
            if(response == 1){
                $.when($.ajax({
                    type: "post",
                    url: '/ofecrono/'+item+'/comprobar',
                    data: {
                    item: item,
                    },
                success: function (response) {
                    let totalAv = parseFloat(response) + parseFloat(avance);
                    if(totalAv <= 100){
                        $.when($.ajax({
                            type: "post",
                            url: '/ofecrono/'+mes+'/'+item+'/'+avance+'/nuevo',
                            data: {
                                item: item,
                            },
                        success: function (response) {
                            onSelectMesChange();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                        }));
                    }else{
                        alert('El item supera el avance del 100%');
                    }
                    },
                error: function (error) {
                    console.log(error);
                }
                }));
            }else{
                existeItem();
            }
         },
         error: function (error) {
             console.log(error);
         }
        }));
  }else{
    alert('Seleccione un mes y un item');
  }
    limpiarItems();
}

function mostrarAcumulado(){
    let item = $("#item").val();
    var acu = document.getElementById("acu");
    $.when($.ajax({
        type: "post",
        url: '/ofecrono/'+item+'/comprobar',
        data: {
        item: item,
        },
    success: function (response) {
        if(response != 0){
            acu.innerHTML = '%acu: '+response;
        }else{
            acu.innerHTML = '%acu: 00.0000';
        }
        
        },
    error: function (error) {
        console.log(error);
    }
    }));
}

function existeItem() {
    alert ("El item ya existe en el mes.");
}

function limpiarItems(){
    var selItem = document.getElementById("item");
    var inputItem = document.getElementById("avance");
    var acu = document.getElementById("acu");
    selItem.value = "0";
    if (inputItem) {
        inputItem.value = '';
    }
    acu.innerHTML = '%acu: 00.0000';
}

function onSelectMesChange(){
    
    // let mes = $(this).val();
    let mes = $("#mes").val();
    
    $.when($.ajax({
        type: "post",
        url: '/ofecrono/'+obra+'/'+mes+'/items',
        data: {
             periodo: mes
         },
        success: function (response) {
            $('#example').DataTable().clear().draw();
            response.forEach(element => {
                element.importe = new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(element.importe);
                element.costo = new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(element.costo);
                element.incidencia = Number.parseFloat(element.incidencia);
                $('#example').DataTable().row.add([element.nom_item, element.avance, element.poravaacuitem, element.incidencia, element.importe, element.costo, '<td><button type="button" class="btn btn-danger borrar" id="removeRow" value="'+element.idcrono+'">Eliminar</button>']).draw();
            });
         },
         error: function (error) {
             console.log(error);
         }
    }));
    limpiarItems();
}

$(document).ready(function pintarTabla() {
    var t = $('#example').DataTable({
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
            "aaSorting": [],
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
              var monTotal = api
                  .column( 1 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
          var tueTotal = api
                  .column( 2 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
              var wedTotal = api
                  .column( 3 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
           var thuTotal = api
                  .column( 4 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
           var importeTotal = api
                  .column( 5 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );

          var costoTotal = api
                  .column( 6 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
              
                  
              // Update footer by showing the total with the reference of the column index 
          $( api.column( 0 ).footer() ).html('Totales');
            //   $( api.column( 1 ).footer() ).html(monTotal.toFixed(4));
            //   $( api.column( 2 ).footer() ).html(tueTotal);
              // $( api.column( 3 ).footer() ).html(wedTotal);
              $( api.column( 4 ).footer() ).html(new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(thuTotal.toFixed(2)));
              $( api.column( 5 ).footer() ).html(new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(importeTotal.toFixed(8)));
            //   $( api.column( 6 ).footer() ).html(costoTotal.toFixed(8));
          },
    });

    $('#example').on( 'click', '.borrar', function () {
        let idcrono = $(this).val();
        console.log(idcrono);
        $.when($.ajax({
            type: "delete",
            url: '/ofecrono/'+idcrono,
            data: {
            idcrono: idcrono,
            },
        success: function (response) {
            onSelectMesChange();
            },
        error: function (error) {
            console.log(error);
        }
        }));
        // t.row( $(this).parents('tr')).remove().draw();
    } );

});


$("input[data-type='avance']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "");
  // return n;
  // return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    if(left_side.length >= 3 && left_side != 100){
        left_side = left_side.substring(0, 2);
    }

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 4);
    // left_side = right_side.substring(0, 2);
    // join number by .
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);

    if(input_val > 100){
      input_val = input_val.substring(0, 2);
    };
    
    // input_val = "$" + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".0000";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}
