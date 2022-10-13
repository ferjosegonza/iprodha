    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>{{ $item['nommenu'] }}</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu m-0" style="display: none;">
            <li class="dropdown-title pt-3 minititulo">
                {{ $item['nommenu'] }}
            </li>
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    @if ($submenu['tipo'] == '0')
                            <li>
                                <a class="nav-link" href="{{ $submenu['nomvista'] ? route(strtolower($submenu['nomvista'])) : '' }}"
                                    title="{{ $submenu['nommenu'] }}">
                                    <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>{{ $submenu['nommenu'] }}</span>
                                </a>
                            </li>
                    @else
                        @include('layouts.menu.menu-recursivoAdmin', ['item' => $submenu])
                    @endif
                @else
                    @include('layouts.menu.menu-recursivoAdmin', ['item' => $submenu])
                @endif
            @endforeach
        </ul>
    </li>

