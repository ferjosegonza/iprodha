<div class="" style="margin-left: 15px">
    {!! Form::open(array('route' => ['favorito.agregar', Route::currentRouteName()],'method'=>'GET', 'name' => 'formulario1')) !!}
        {!! Form::text('titulo', null, array('class' => 'form-control', 'id'=>'titulos', 'hidden')) !!}
        <button id="botonfav" type="submit" class="btn btn-outline-dark mr-2" >Favorito <i class="far fa-star"></i></button> 
    {!! Form::close() !!}
</div>

<script>
    $(document).ready(function() { 
        var titulo = document.getElementById('titulos');
        const tituloPag = document.getElementsByClassName('page__heading');
        // titulo.setAttribute('value', tituloPag[0].innerHTML);
        titulo.value = tituloPag[0].innerHTML;
    });
</script>