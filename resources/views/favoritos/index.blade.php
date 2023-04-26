{{-- views->inicio --}}
<style>
#iconoContent :hover{
  color: rgb(24, 23, 23);
}
</style>
<h4>Mis favoritos:</h3>
    <div class="row">
        @foreach($Favoritos as $Favorito)
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body border border-warning rounded" style="--bs-border-opacity: .3;">
                      <div class="row">
                        <div class="col-sm-3 col-md-9 col-lg-11">
                          <h5 class="card-title">{{ $Favorito->titulo }}</h5>
                        </div>
                        <div class="col-sm-1 col-md-3 col-lg-1">
                          <div class="dropdown">
                            <a id="iconoContent" href="" data-bs-toggle="dropdown" style="text-decoration: none; color: #6c757d">
                              <i id= "icono"class="fas fa-ellipsis-v fs-5"></i>
                            </a>
                            <ul class="dropdown-menu">
                              <li>
                                {!! Form::open(['id' => 'editar'.$Favorito->ruta,'method' => 'GET', 'route' => ['favorito.edit', $Favorito->idfav], 'style' => 'display:inline']) !!}
                                  <a class="dropdown-item" href="#" onclick="document.getElementById('editar{{$Favorito->ruta}}').submit()">Editar</a>
                                {!! Form::close() !!}

                                {{-- {!! Form::model($Favorito,
                                 ['method' => 'PATCH',
                                 'id' => 'editar'.$Favorito->ruta,
                                 'route' => ['favorito.update',
                                  $Favorito->ruta]]) !!}
                              
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalUno" data-ruta="{{$Favorito->ruta}}" data-descri="{{$Favorito->descripcion}}" onclick="document.getElementById('editar{{$Favorito->ruta}}').submit()">Editar</a>
                                {!! Form::close() !!} --}}

                              </li>
                              <li>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'class' => 'formulario',
                                    'route' => ['favorito.destroy', $Favorito->idfav],
                                    'style' => 'display:inline',
                                    'id' => 'laruta'.$Favorito->ruta,
                                ]) !!}
                                  <a onclick="document.getElementById('laruta{{$Favorito->ruta}}').submit()" class="dropdown-item" href="#">Borrar</a>
                                {!! Form::close() !!}
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                        
                      <p class="card-text">{{ $Favorito->descripcion}}</p>
                      <a href="{{ route($Favorito->ruta) }}" class="btn btn-warning" target="_blank">Abrir</a>
                    </div>
                </div>
            </div>
            {{-- @include('layouts.favorito.editar', ['modo' => 'Agregar']) --}}
        @endforeach
      </div>

<script>
  $('#exampleModalUno').on('shown.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    // var button = document.getElementById('editaar');
    var ruta = button.dataset.ruta;
    var textA = document.getElementById('descrip');
    console.log(ruta);
    // modal.find('#descript').text( ruta );
    textA.value = ruta;
        
  });
</script>