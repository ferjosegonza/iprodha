@hasrole('INFORMATICA')
    <li class="m-0 p-0">
        <ul class="sidebar-menu m-0 p-0">
            <li class="dropdown py-0" aria-placeholder="Informatica">
                <a href="" class="nav-link has-dropdown justify-content-start">
                    <div>Informatica</div>
                </a>
                @include('layouts.menu.vistas.informatica')


            </li>
        </ul>
    </li>
@endhasrole

@hasrole('HERRAMIENTAS')
    <li>
        <ul class="sidebar-menu ">
            <li class="dropdown py-0" aria-placeholder="Herramientas">
                <a href="" class="nav-link has-dropdown justify-content-start">
                    <div>Herramientas</div>
                </a>
                
                @include('layouts.menu.vistas.herramientas')


            </li>
        </ul>
    </li>
@endhasrole
