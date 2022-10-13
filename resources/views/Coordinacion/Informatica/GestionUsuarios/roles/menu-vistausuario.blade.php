
@foreach ($arbol  as $item)
  
    @if ($item['tipo'] != '1' || is_null($item['tipo']))
        @break
    @endif
    @include('Coordinacion.Informatica.GestionUsuarios.roles.menu-recursivo-vistausuario', ['item' => $item])
@endforeach

