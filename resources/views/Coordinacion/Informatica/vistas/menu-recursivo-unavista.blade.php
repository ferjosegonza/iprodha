<li class=" ">
        @if ($item['nommenu'] == 'IPRODHA')
            <input type="checkbox" name="list" id="nivel{{ $item['idmenu'] }}">
            
            <label
                for="nivel{{ $item['idmenu'] }}"><span>{{ $item['nommenu'] . '   - id ' . $item['idmenu'] }}</span></label>
            <ul class="interior1">
        @else
            <input type="checkbox" checked name="list" id="nivel{{ $item['idmenu'] }}">
            
            <label
                for="nivel{{ $item['idmenu'] }}"><span>{{ $item['nommenu'] . '   - id ' . $item['idmenu'] }}</span></label>
            
            @if ($item['visible'] == 1)
                <i class="far fa-eye ms-2"></i>
            @else
                <i class="fas fa-eye-slash ms-2 text-danger"></i>
            @endif
            <ul class="interior">
        @endif
        @foreach ($item['submenu'] as $submenu)
            @if ($submenu['submenu'] == [])
                @if ($submenu['tipo'] == '0')
                    <li class="d-flex ms-2">
                        <div>
                            <i class="fas fa-clipboard-list text-success"style="font-size:1.2em; "></i> -
                            <span class="text-success">{{ $submenu['nommenu'] . '   - id ' . $submenu['idmenu'] }}</span>
                        </div>
                        <div>
                            <i class="fas fa-trash-alt ms-4 ms-2 text-black"
                                onclick="eliminarmenu('{{ $submenu['nommenu'] }}',{{ $submenu['idmenu'] }})"></i>
                            @if ($submenu['visible'] == 1)
                                <i class="far fa-eye ms-2"></i>
                            @else
                                <i class="fas fa-eye-slash ms-2 text-danger"></i>
                            @endif
                        </div>
                    </li>
                @else
                    @include('Coordinacion.Informatica.vistas.menu-recursivo-unavista', [
                        'item' => $submenu,
                    ])
                @endif
            @else
                @include('Coordinacion.Informatica.vistas.menu-recursivo-unavista', [
                    'item' => $submenu,
                ])
            @endif
        @endforeach
    </ul>
</li>
