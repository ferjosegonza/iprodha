<ul class="dropdown-menu border border-primary border-2 borde-menu" style="display: none;">
    <li class="dropdown-title">
        Herramientas
    </li>
    @hasrole('HERRAMIENTAS')
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
        <li>
            <a class="nav-link" href="{{ route('phpinfo') }}" title="phpinfo">
                <i class="fab fa-php"style="font-size:2em; "></i><span>PHPinfo</span>
            </a>
        </li>
    @endhasrole
</ul>
