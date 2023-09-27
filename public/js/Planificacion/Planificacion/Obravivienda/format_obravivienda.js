$("input[data-type='limitcarac10']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 10);
    }
});

$("input[data-type='limitcarac12']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 12);
    }
});

$("input[data-type='limitcarac2']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 2);
    }
});

$("input[data-type='limitcarac3']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 3);
    }
});

$("input[data-type='limitcarac4']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 4);
    }
});

$("input[data-type='limitcarac5']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 5);
    }
});

$("input[data-type='limitcarac6']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 6);
    }
});

$("input[data-type='limitcarac80']").on({
    keyup: function() {
        // this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatInputViv($(this), 78);
    }
});

function limitesCaracter(opc){
    switch (opc) {
        case 1:
            return 10;
            break;
    
        default:
            break;
    }
}

function formatInputViv(input, maxC){
    // let maxC = limitesCaracter(opc);
    let input_val = input.val();
    // console.log(input_val, maxC);

    // original length
    let original_len = input_val.length;

    if(original_len > maxC){
        input_val = input_val.substring(0, original_len-1);
    }

    input_val = input_val.replace(/[,.]/g,'');

    // send updated string to input
    input.val(input_val);
}




// function formatPorc(input, blur) {
//     // get input value
//     var input_val = input.val();
//     var original_len = input_val.length;
//     // console.log(original_len);
//     // don't validate empty input
//     if (input_val === ""){ 
//         return;
//     }
    

//     if (input_val === "0"){ 
//         input_val = input_val.replace(/[0-]/g,'');
//     }

//     if(input_val > 100){
//         input_val = input_val.substring(0, original_len-1);
//     }

//     input_val = input_val.replace(/[,.]/g,'');
//     // console.log(input_val);
//     // console.log(input_val);

//     // send updated string to input
//     input.val(input_val);
// }