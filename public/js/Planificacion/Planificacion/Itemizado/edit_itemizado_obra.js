$(function(){
    $('.item-costo').on('keyup', calculoSubtotal);
});

function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "");
    // return n;
    // return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  
}

function controlInput(input) {
    // don't validate empty input
    if (input === "") { return; }
    
    // check for decimal
    if (input.indexOf(".") >= 0) {
        var decimal_pos = input.indexOf(".");
        var left_side = input.substring(0, decimal_pos);
        var right_side = input.substring(decimal_pos);
        right_side = right_side.replace('.', '');

        if(right_side.length >= 3){
        right_side = right_side.substring(0, 2);
        right_side  = formatNumber(right_side);
        }

        left_side = formatNumber(left_side);
        let numero = left_side +"."+right_side;
        return numero; 
    }else{
        input = formatNumber(input);
        return input;
    }
}

function calculoSubtotal(){
    var resume_table = document.getElementById("items");
    var casillaSubTotal = document.getElementById("nuevo-subtotal"); 
    let totalColumn = resume_table.rows.length;
    let costo = 0;
    let totalNuevo = 0;
    let inputArreglado = '';

    for (var i = 1; i < (totalColumn-2) ; i++) {
        row = resume_table.rows[i];
        col = row.cells[2];
        inputArreglado = controlInput(col.children[0].children[1].value);
        //console.log(inputArreglado);
        col.children[0].children[1].value = inputArreglado;
        costo = parseFloat(inputArreglado);
        totalNuevo += costo;
    }
    
    valorSubTotal = totalNuevo.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

    casillaSubTotal.innerHTML = '$ '+valorSubTotal;
    comprobarSubtotal();
}

function comprobarSubtotal(){
    let btnGuardar = document.getElementById("btn-guardar");
    let nuevo_subtotal = document.getElementById("nuevo-subtotal");
    let actual_subtotal = document.getElementById("actual-subtotal");
    let nue_subtotal = nuevo_subtotal.innerText;
    let act_subtotal = actual_subtotal.innerText;
    act_subtotal = act_subtotal.replace('$ ', "").replace(/\./g, "").replace(',', '.');
    act_subtotal = parseFloat(act_subtotal);
    
    nue_subtotal = nue_subtotal.replace('$ ', "").replace(/\./g, "").replace(',', '.');
    nue_subtotal = parseFloat(nue_subtotal);

    if(nue_subtotal == act_subtotal){
        nuevo_subtotal.style.color = "green";
        btnGuardar.disabled = false;
    }else{
        nuevo_subtotal.style.color = "red";
        btnGuardar.disabled = true;
    }
}

