<li class="side-menus  {{ Request::is('*') ? 'active' : '' }}">
    <a class=" dropdown-title">
        <i class=" fas fa-building"></i><span>IPRODHA</span>
    </a>
</li>





@hasrole('COORDINACION')
    <li class="dropdown ">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>Coordinacion</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu m-0" style="display: none;">
            <li class="dropdown-title pt-3">
                Coordinacion
            </li>

            @include('layouts.menu.SegundoNivel.Coordinacion')

        </ul>
    </li>
@endhasrole


@canany(['VER-ROL', 'EDITAR-ROL', 'BORRAR-ROL', 'CREAR-ROL', 'VER-PERMISO', 'EDITAR-PERMISO', 'BORRAR-PERMISO',
    'CREAR-PERMISO', 'VER-USUARIO', 'EDITAR-USUARIO', 'BORRAR-USUARIO', 'CREAR-USUARIO'])


    <li class="dropdown">
        <a href="" class="nav-link has-dropdown ">
            <i class="fas fa-home"></i><span>Administración</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Administración
            </li>

           
            <li>
                <a class="nav-link" href="{{ route('home.index') }}" title="Permisos">
                    <i class="fas fa-house-user "style="font-size:1.2em; "></i><span>Home</span>
                </a>
            </li>
            @canany(['VER-USUARIO', 'EDITAR-USUARIO', 'BORRAR-USUARIO', 'CREAR-USUARIO'])
                <li>
                    <a class="nav-link" href="{{ route('usuarios.index') }}" title="Usuarios">
                        <i class=" fas fa-users"style="font-size:1.2em; "></i><span>Usuarios</span>
                    </a>
                </li>
            @endcanany

            @hasrole('ADMIN')
                <li>
                    <a class="nav-link" href="{{ route('logApp.index') }}" title="Error Log">
                        <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Log App</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('logAuditar') }}" title="Error Auditoria">
                        <i class="fas fa-clipboard-list"style="font-size:1.2em; "></i><span>Log Auditoria</span>
                    </a>
                </li>
            @endhasrole
            @hasrole('ADMIN')
                <li>
                    <a class="nav-link" href="{{ route('phpinfo') }}" title="phpinfo">
                        <i class="fab fa-php"style="font-size:2em; "></i><span>PHPinfo</span>
                    </a>
                </li>
            @endhasrole
        </ul>
    </li>
@endcanany


@canany(['VER-ESTADOOBRAS', 'EDITAR-ESTADOOBRAS', 'BORRAR-ESTADOOBRAS', 'CREAR-ESTADOOBRAS'])
    <li class="dropdown">
        <a href="" class="nav-link has-dropdown">
            <i class="fas fa-home"></i><span>Presidencia</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Presidencia
            </li>
            @canany(['VER-ESTADOOBRAS', 'EDITAR-ESTADOOBRAS', 'BORRAR-ESTADOOBRAS', 'CREAR-ESTADOOBRAS'])
                <li>
                    <a class="nav-link" href="{{ route('estadoobras.index') }}" title="Usuarios">
                        <i class=" fas fa-warehouse"style="font-size:1.2em; "></i><span>Pagos X Obras</span>
                    </a>
                </li>
            @endcanany
        </ul>
    </li>
@endcanany



@canany(['VER-OBRAS', 'CREAR-OBRAS', 'EDITAR-OBRAS', 'BORRAR-OBRAS', 'VER-CONCEPTOFACTURACION',
    'EDITAR-CONCEPTOFACTURACION', 'BORRAR-CONCEPTOFACTURACION', 'CREAR-CONCEPTOFACTURACION', 'VER-IPROUSUARIO',
    'EDITAR-IPROUSUARIO', 'BORRAR-IPROUSUARIO', 'CREAR-IPROUSUARIO', 'VER-CATEGORIALABORAL', 'CREAR-CATEGORIALABORAL',
    'EDITAR-CATEGORIALABORAL', 'BORRAR-CATEGORIALABORAL'])
    <li class="dropdown">
        <a href="" class="nav-link has-dropdown">
            <i class="fas fa-home"></i><span>Informática</span>
        </a>
        <ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
            <li class="dropdown-title pt-3">
                Informática
            </li>
            @canany(['VER-CONCEPTOFACTURACION', 'EDITAR-CONCEPTOFACTURACION', 'BORRAR-CONCEPTOFACTURACION',
                'CREAR-CONCEPTOFACTURACION'])
                <li>
                    <a class="nav-link" href="{{ route('conceptofacturacion.index') }}" title="Usuarios">
                        <i class=" fas fa-users"style="font-size:1.2em; "></i><span>Concepto Factura</span>
                    </a>
                </li>
            @endcanany
            @canany(['VER-IPROUSUARIO', 'EDITAR-IPROUSUARIO', 'BORRAR-IPROUSUARIO', 'CREAR-IPROUSUARIO'])
                <li>
                    <a class="nav-link" href="{{ route('iprousuarios.index') }}" title="Usuarios Iprodha">
                        <i class=" fas fa-users"style="font-size:1.2em; "></i><span>Usuarios Iprodha</span>
                    </a>
                </li>
            @endcanany

            @canany(['VER-OBRAS', 'CREAR-OBRAS', 'EDITAR-OBRAS', 'BORRAR-OBRAS'])
                <li>
                    <a class="nav-link" href="{{ route('obras.index') }}" title="Obras">
                        <i class="fas fa-warehouse"style="font-size:1.2em; "></i><span>Listados de Obras</span>
                    </a>
                </li>
            @endcanany
            {{-- Lisandro --}}
            @canany(['VER-CATEGORIALABORAL', 'CREAR-CATEGORIALABORAL', 'EDITAR-CATEGORIALABORAL',
                'BORRAR-CATEGORIALABORAL'])
                <li>
                    <a class="nav-link" href="{{ route('categorialaboral.index') }}" title="">
                        <i class="fas fa-list-alt"style="font-size:1.2em; "></i><span>Categoria Laboral</span>
                    </a>
                </li>
            @endcanany
            {{-- @canany(['VER-CATEGORIALABORAL', 'CREAR-CATEGORIALABORAL', 'EDITAR-CATEGORIALABORAL', 'BORRAR-CATEGORIALABORAL'])
            <li>
                <a class="nav-link" href="{{ route('tarea.index') }}" title="">
                    <i class="fas fa-list-alt"style="font-size:1.2em; "></i><span>Tareas</span>
                </a>
            </li>
            @endcanany
            @canany(['VER-CATEGORIALABORAL', 'CREAR-CATEGORIALABORAL', 'EDITAR-CATEGORIALABORAL', 'BORRAR-CATEGORIALABORAL'])
            <li>
                <a class="nav-link" href="{{ route('solucionador.index') }}" title="">
                    <i class="fas fa-list-alt"style="font-size:1.2em; "></i><span>Solucionador</span>
                </a>
            </li>
            @endcanany --}}
        </ul>
    </li>
@endcanany
