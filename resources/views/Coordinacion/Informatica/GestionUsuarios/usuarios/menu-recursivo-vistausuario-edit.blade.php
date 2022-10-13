<li class=" ">
    <input type="checkbox" name="list" id="nivel{{ $item['idmenu'] }}">
    <label for="nivel{{ $item['idmenu'] }}"><i class="fas fa-home"></i><span>{{ $item['nommenu'] }}</span></label>
    @php
        $bandera2 = false;
    @endphp
    @foreach ($userGrupo as $grupo)
        @if ($grupo->name == ($item['idmenu'].$item['nommenu']))
            {{ Form::checkbox('grupos[]', $item['idmenu'], true, ['onclick' => '', 'class' => 'name grupocheck'.$item['idmenu']]) }}
            @php
                $bandera2 = true;
            @endphp
            @break
        @endif
    @endforeach
    @if (!$bandera2)
        {{ Form::checkbox('grupos[]', $item['idmenu'], false, ['onclick' => '', 'class' => 'name grupocheck'.$item['idmenu']]) }}
    @endif
    @php
        $bandera2 = false;
    @endphp
    @if ($item['visible'] == 1)
        <i class="far fa-eye ms-5"></i>
    @else
        <i class="fas fa-eye-slash ms-5 text-danger"></i>
    @endif
    <ul class="interior">
        @foreach ($item['submenu'] as $submenu)
            @if ($submenu['submenu'] == [])
            @if ($submenu['tipo']=='0')

                <li>
                    <div>
                        <span>{{ $submenu['nommenu'] }}</span>
                        <button class="btnSinEstilo" onclick="buscarvista('{{$submenu['rol']}}')">
                            <i class=" ms-5 text-danger">Ver</i>
                        </button>
                        @if ($submenu['visible'] == 1)
                            <i class="far fa-eye ms-2"></i>
                        @else
                            <i class="fas fa-eye-slash ms-2 text-danger"></i>
                        @endif
                    </div>
                </li>
                @else
                @include('Coordinacion.Informatica.GestionUsuarios.usuarios.menu-recursivo-vistausuario-edit', [
                    'item' => $submenu,
                ])
                @endif
            @else
                @include('Coordinacion.Informatica.GestionUsuarios.usuarios.menu-recursivo-vistausuario-edit', [
                    'item' => $submenu,
                ])
            @endif
        @endforeach
    </ul>
</li>
{{----
<li>
    <input type="checkbox" name="list" id="nivel1-1">
    <label for="nivel1-1">Nivel 1</label>
    <ul class="interior">
        <li>
            <input type="checkbox" name="list" id="nivel2-1">
            <label for="nivel2-1">Nivel 2</label>
            <ul class="interior">
            <li><a href="#r">Nivel 3</a></li>
            <li><a href="#r">Nivel 3</a></li>
            </ul>
        </li>
        <li>
            <input type="checkbox" name="list" id="nivel2-2">
            <label for="nivel2-2">Nivel 2</label>
            <ul class="interior">
            <li><a href="#r">Nivel 3</a></li>
            <li><a href="#r">Nivel 3</a></li>
            <li><a href="#r">Nivel 3</a></li>
            <li><a href="#r">Nivel 3</a></li>
            </ul>
        </li>
    </ul>
</li>--}}
