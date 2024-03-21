@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/sociales/turnos.css')}}">
    <script src="{{ asset('js/Sociales/turnos.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Generar Turnos</h3>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-head"><h5>Colas</h5></div>
            <div class="card-body"> 
                <a href="nueva_cola"><button class="btn btn-outline-success">Generar nueva cola de turnos</button></a>
                <hr>
                <table id="colas" style="width: 100%">
                    <button class="btn btn-outline-secondary btn-sm" onclick="filter('t')">Ver todas las colas</button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="filter('c')">Ver las colas cerradas</button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="filter('p')">Ver las colas pendientes</button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="filter('pu')">Ver las colas publicadas</button>
                    <thead>
                        <th hidden></th>
                        <th>Descripción</th>
                        <th>Trámite</th>
                        <th>Estado</th>
                        <th>Puestos</th>
                        <th>Desde</th>
                        <th>Hasta</th>                    
                        <th>Duración del turno</th>    
                        <th>Acción</th>
                    </thead>
                    <tbody>
                        @foreach ($colas as $cola)
                            <tr>
                                <td hidden>{{$cola->idcola}}</td>
                                <td>{{$cola->descripcion}}</td>
                                <td>{{$cola->denominacion}}</td>
                                <td>                                    
                                    @if(date('Y-m-d',strtotime($cola->fecha_hasta)) > date("Y-m-d"))
                                        @if ($cola->publicado == 0)
                                        Pendiente
                                        @else
                                        Publicada
                                        @endif
                                    @else
                                        Cerrada
                                    @endif
                                </td>
                                <td>{{strtotime($cola->cant_puestos)}}</td>
                                <td>{{$cola->fecha_desde}}</td>
                                <td>{{$cola->fecha_hasta}}</td>
                                <td>{{$cola->duracion_turno}} min.</td>
                                <td>
                                    <a href="cola/{{$cola->idcola}}" class="btn btn-outline-primary">Configurar cola</a>
                                    @if($cola->turnos != 0)
                                        <a href="turnos_cola/{{$cola->idcola}}" class="btn btn-outline-primary">Turnos</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>        
    </div>
</section>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
