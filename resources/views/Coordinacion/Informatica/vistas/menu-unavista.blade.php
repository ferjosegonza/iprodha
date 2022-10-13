
@foreach ($arbol  as $item)
  
    @if ($item['tipo'] != '1' || is_null($item['tipo']))
        @break
    @endif
    @include('Coordinacion.Informatica.vistas.menu-recursivo-unavista', ['item' => $item])
@endforeach

