<li class=" ">
        @if ($item['nommenu'] == 'IPRODHA')
            <input type="checkbox" name="list" id="nivel{{ $item['idmenu'] }}">
            <i class="fas fa-bowling-ball rounded-circle me-2"
                onclick="handleRadioClick({{ $item['idmenu'] }});cargarMenu({{ $item['idmenu'] }})"
                id="check{{ $item['idmenu'] }}" style="color:#fff ;border:1px solid Black"></i>
            <label
                for="nivel{{ $item['idmenu'] }}"><span>{{ $item['nommenu'] . '   - id ' . $item['idmenu'] }}</span></label>
            <ul class="interior1">
        @else
            <input type="checkbox" name="list" id="nivel{{ $item['idmenu'] }}">
            <i class="fas fa-bowling-ball rounded-circle me-2"
                onclick="handleRadioClick({{ $item['idmenu'] }});cargarMenu({{ $item['idmenu'] }})"
                id="check{{ $item['idmenu'] }}" style="color:#fff ;border:1px solid Black"></i>
            <label
                for="nivel{{ $item['idmenu'] }}"><span>{{ $item['nommenu'] . '   - id ' . $item['idmenu'] }}</span></label>
            <i class="fas fa-edit ms-4 text-danger" onclick="editarmenu({{ $submenu['idmenu'] }})"></i>
            <i class="fas fa-trash-alt ms-2 text-black"
                onclick="eliminarmenu('{{ $submenu['nommenu'] }}',{{ $submenu['idmenu'] }})"></i>
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
                            <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i> -
                            <span>{{ $submenu['nommenu'] . '   - id ' . $submenu['idmenu'] }}</span>
                        </div>
                        <div>
                            <i class="fas fa-edit ms-4 text-muted" onclick="editarmenu({{ $submenu['idmenu'] }})"></i>
                            <i class="fas fa-trash-alt ms-2 text-black"
                                onclick="eliminarmenu('{{ $submenu['nommenu'] }}',{{ $submenu['idmenu'] }})"></i>
                            @if ($submenu['visible'] == 1)
                                <i class="far fa-eye ms-2"></i>
                            @else
                                <i class="fas fa-eye-slash ms-2 text-danger"></i>
                            @endif
                            {{-- <i class="fas fa-bowling-ball rounded-circle ms-3" onclick="handleRadioClick({{$submenu['idmenu']}});cargarMenu({{$submenu['idmenu']}})"  id="check{{$submenu['idmenu']}}" style="color:#fff ;border:1px solid Black" id="check{{$item['idmenu']}}"></i> --}}
                        </div>
                    </li>
                @else
                    @include('Coordinacion.Informatica.GestionUsuarios.roles.menu-recursivo-vistausuario', [
                        'item' => $submenu,
                    ])
                @endif
            @else
                @include('Coordinacion.Informatica.GestionUsuarios.roles.menu-recursivo-vistausuario', [
                    'item' => $submenu,
                ])
            @endif
        @endforeach
    </ul>
</li>
