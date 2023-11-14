(function (){
    $('.form-prevent-multiple-submits').on('submit', function(){
        // console.log('hola');
        $('.button-prevent-multiple-submits').attr('disabled', 'true');
    })
})();