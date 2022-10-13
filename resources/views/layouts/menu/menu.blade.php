<li class="side-menus  {{ Request::is('*') ? 'active' : '' }}">
    <a class=" dropdown-title dropdown-title">
        <i class=" fas fa-building"></i><span>IPRODHA</span>
    </a>
</li>

@hasrole('ADMIN')
    @foreach ($menus  as $item)
        @if ($loop->first)  
            @continue
        @endif
        @if ($item['tipo'] != '2' || is_null($item['tipo']))
            @continue
        @endif
        @include('layouts.menu.menu-recursivoAdmin', ['item' => $item])
    @endforeach
@else
    @foreach ($menus  as $item)
        @if ($loop->first)  
            @continue
        @endif
        @if ($item['tipo'] != '2' || is_null($item['tipo']))
            @continue
        @endif
        @include('layouts.menu.menu-recursivo', ['item' => $item])
    @endforeach
@endhasrole


