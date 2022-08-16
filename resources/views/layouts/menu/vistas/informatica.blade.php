<ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
    <li class="dropdown-title ">
        Informatica
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
    @canany(['VER-ROL', 'EDITAR-ROL', 'BORRAR-ROL', 'CREAR-ROL'])
        <li>
            <a class="nav-link" href="{{ route('roles.index') }}" title="Roles">
                <i class=" fas fa-user-lock"style="font-size:1.2em; "></i><span>Roles</span>
            </a>
        </li>
    @endcanany
    @canany(['VER-PERMISO', 'EDITAR-PERMISO', 'BORRAR-PERMISO', 'CREAR-PERMISO'])
        <li>
            <a class="nav-link" href="{{ route('permisos.index') }}" title="Permisos">
                <i class="fas fa-exclamation-triangle"style="font-size:1.2em; "></i><span>Permisos</span>
            </a>
        </li>
    @endcanany

    <li>
        <ul class="sidebar-menu">
            <li class="dropdown p-0" aria-placeholder="Herramientas">
                <a href="" class="nav-link has-dropdown justify-content-start">
                    <div>Herramientas</div>
                </a>
                @include('layouts.menu.vistas.herramientas')


            </li>
        </ul>
    </li>

</ul>
