//El formato es 0000/0000 

$("input[data-type='numlic']").on({
  keyup: function() {
      this.value = this.value.replace(/[^0-9./]/g, '').replace(/(\..*?)\..*/g, '$1');
      formatNumlic($(this));
  },
  blur: function() { 
      formatNumlic($(this), "blur");
  }
});

function formatNumlic(input, blur) {

  var input_val = input.val();
  var original_len = input_val.length;
  let last_c = input_val.charAt(input_val.length - 1)

  // don't validate empty input
  if (input_val === ""){ 
      return;
  }
  
  var side_pos = input_val.indexOf("/");

  // split number by decimal point
  var left_side = input_val.substring(0, side_pos);
  var right_side = input_val.substring(side_pos);
  

  if(original_len == 4 && last_c != "/"){
    input_val = input_val + "/";
  }

  input_val = input_val.replace(/[,.]/g,'');
  
  if (right_side.length > 5) {
    right_side = right_side.substring(0, right_side.length-1);
  }

  if (left_side.length > 4) {
    left_side = left_side.substring(0, left_side.length-1);
  }

  // send updated string to input
  if(original_len > 4){
    input_val = left_side + right_side;
  }
  
  input.val(input_val);
}