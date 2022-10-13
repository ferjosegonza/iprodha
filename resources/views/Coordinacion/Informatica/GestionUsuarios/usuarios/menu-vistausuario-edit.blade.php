
@foreach ($arbol  as $item)
    @if ($loop->first)  
        @continue
    @endif

    @if ($item['tipo'] != '2' || is_null($item['tipo']))
        @continue
    @endif
    @php
        $bandera=1;
    @endphp
    @include('Coordinacion.Informatica.GestionUsuarios.usuarios.menu-recursivo-vistausuario-edit', ['item' => $item])
@endforeach

