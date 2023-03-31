<style>
    .notify {
      min-width: 18rem;
      min-height: 4rem;
    }

    .notificaciones:hover {
        font-size: 10px;
        background-color: rgb(250, 233, 211);
    }

    .cardnotify {
        --bs-card-spacer-y: 3px;
        --bs-card-spacer-x: 5px;
        --bs-card-title-spacer-y: -0.5rem;
        --bs-card-border-width: 0.5px;
        --bs-card-border-color: var(--bs-border-color-translucent);
        --bs-card-border-radius: 0.375rem;
        --bs-card-box-shadow: ;
        --bs-card-inner-border-radius: calc(0.375rem - 1px);
        --bs-card-cap-padding-y: 0.5rem;
        --bs-card-cap-padding-x: 1rem;
        --bs-card-cap-bg: rgba(0, 0, 0, 0.03);
        --bs-card-cap-color: ;
        --bs-card-height: ;
        --bs-card-color: ;
        --bs-card-bg: rgb(253, 244, 232);
        --bs-card-img-overlay-padding: 1rem;
        --bs-card-group-margin: 0.75rem;
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        height: var(--bs-card-height);
        word-wrap: break-word;
        background-color: var(--bs-card-bg);
        background-clip: border-box;
        border: var(--bs-card-border-width) solid var(--bs-card-border-color);
        border-radius: var(--bs-card-border-radius);
    }
</style>
<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a id="plegable" href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">

    @if($user = \Illuminate\Support\Facades\Auth::user())
        <div class="row">
            <div class="col my-auto">
                @php
                    $bandera=0;
                    $contador=0;
                    $terminado=0;
                        foreach ($notificaciones as $notificacion) {
                            if ($notificacion->idestado ==1) {
                                $bandera=1;
                            }
                            if ($notificacion->idestado ==3) {
                                $terminado=1;
                            }
                            $contador = $contador +1;
                        }
                    $count = 0;    
                @endphp
                @if($notificaciones != null and $terminado!=$contador)
                    <li class="dropstart" style='$dropdown-min-width: 25rem;'>                        
                        @if($bandera==1)
                            <a href="#"  id="mydrop" class="" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: #f9f9f9;">
                                <i class="fas fa-bell fs-5" ></i>
                                <span id="punto" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                            </a>
                            <ul class="dropdown-menu notify">
                            <!-- Dropdown menu links -->                        
                                @foreach($notificaciones as $notificacion)
                                    @if($count<3)  
                                        @if ($notificacion->idestado != 3)                            
                                            <div class="cardnotify m-2">
                                                <a class="notificaciones" href='{{route('notif.ver', $notificacion->idnotificacion)}}' style="text-decoration: none; color:#6c757d">
                                                    <div class="card-body">
                                                        @if($notificacion->idestado == 1)
                                                            <div style="color: red; font-size: 11px">NUEVO</div>
                                                        @endif 
                                                            <div style="color: rgb(59, 59, 59)">{{$notificacion->fecha}}</div>                                                    
                                                            <h5 class="card-title" style="font-size: 14px">{{strtoupper($notificacion->getMensaje->titulo)}}</h5>
                                                            <p class="card-text">{{$notificacion->getMensaje->mensaje}}</p>
                                                    </div>
                                                </a>
                                            </div>                                    
                                            @php
                                            $count = $count+1;
                                            @endphp
                                        @endif
                                    @else                    
                                        <footer> <a href={{route('notif.verTodo', 125)}} style="text-decoration: none; color:#6c757d; font-size:20px;" class="d-flex justify-content-center">Ver más</a> 
                                        </footer>               
                                    @break                     
                                    @endif   
                                @endforeach      
                            </ul>
                        @else
                        <a href="#"  id="mydrop" class="" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: #f9f9f9;">
                            <i class="fas fa-bell fs-5" ></i>
                        </a>
                        <ul class="dropdown-menu notify">
                        <!-- Dropdown menu links -->                        
                                @foreach($notificaciones as $notificacion)
                                    @if($count<3)  
                                        @if ($notificacion->idestado != 3)                            
                                            <div class="cardnotify m-2">
                                                <a class="notificaciones" href='{{route('notif.ver', $notificacion->idnotificacion)}}' style="text-decoration: none; color:#6c757d">
                                                    <div class="card-body">
                                                        @if($notificacion->idestado == 1)
                                                        <div style="color: red">NUEVO: GENERADO EL {{$notificacion->fecha}}</div>
                                                        <h5 class="card-title">{{strtoupper($notificacion->getMensaje->titulo)}}</h5>
                                                        @else
                                                        <div style="color: rgb(59, 59, 59)">GENERADO EL {{$notificacion->fecha}}</div>
                                                        <h5 class="card-title">{{strtoupper($notificacion->getMensaje->titulo)}}</h5>
                                                        @endif                                    
                                                        <p class="card-text">{{$notificacion->getMensaje->mensaje}}</p>
                                                    </div>
                                                </a>
                                            </div>                                    
                                            @php
                                            $count = $count+1;
                                            @endphp
                                        @endif
                                    @else                    
                                        <footer> <a href={{route('notif.verTodo', 125)}} style="text-decoration: none; color:#6c757d; font-size:20px;" class="d-flex justify-content-center">Ver más</a> 
                                        </footer>   
                                    @break                                                                 
                                    @endif   
                                @endforeach 
                        </ul>
                        @endif
                    </li>
                @else
                    <li class="dropstart" style='$dropdown-min-width: 25rem;'>
                        <a href="#"  id="mydrop" class="" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: #f9f9f9;">
                            <i class="fas fa-bell fs-5" ></i>
                        </a>
                        <ul class="dropdown-menu notify">
                            <div class="cardnotify m-2">
                                <div class="card-body">  
                                    <p class="card-text">No hay notificaciones pendientes.</p>
                                </div>       
                            </div>
                        </ul>
                    </li>
                @endif
            </div>
            <div class="col">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"
                       class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
                        <img alt="image" src="{{ asset('img/logo3.png') }}"
                             class="rounded-circle mr-1 thumbnail-rounded user-thumbnail "style="width: 40px">
                        <div class="d-sm-none d-lg-inline-block">
                            Bienvenido, {{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
                    </a>
        
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">
                            Hola, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                        <a class="dropdown-item has-icon edit-profile" href="#" data-toggle="modal" data-target="#editProfileModal" data-id="{{ \Auth::id() }}">
                            <i class="fa fa-user"></i>Editar Perfil</a>
                        <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#" data-id="{{ \Auth::id() }}"><i
                                    class="fa fa-lock"> </i>Cambiar Contraseña</a>
                        <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                           onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </div>
        </div>
        
        {{-- <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/logo3.png') }}"
                     class="rounded-circle mr-1 thumbnail-rounded user-thumbnail "style="width: 40px">
                <div class="d-sm-none d-lg-inline-block">
                    Bienvenido, {{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Hola, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                <a class="dropdown-item has-icon edit-profile" href="#" data-toggle="modal" data-target="#editProfileModal" data-id="{{ \Auth::id() }}">
                    <i class="fa fa-user"></i>Editar Perfil</a>
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#" data-id="{{ \Auth::id() }}"><i
                            class="fa fa-lock"> </i>Cambiar Contraseña</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li> --}}
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{--                <img alt="image" src="#" class="rounded-circle mr-1">--}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('messages.common.login') }}
                    / {{ __('messages.common.register') }}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>
            </div>
        </li>
    @endif
</ul>


