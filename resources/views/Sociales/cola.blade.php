@extends('layouts.app')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/sociales/cola.css') }}">
        <script src="{{ asset('js/Sociales/cola.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <a href="/sociales/turnos" class="btn"><i class="fas fa-arrow-left fa-lg"></i> Volver </a>
            <h3 class="page__heading">Generar Turnos</h3>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <input type="text" hidden value="{{$cola->idcola}}" id="id">
                    <h5 style="margin: 1%">{{ $cola->descripcion }}</h5>                
                    <hr>
                </div>
                <div class="card-body">       
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="fecha_desde" class="form-label">Desde:</label>              
                            <input id="fecha_desde" type="date" disabled value="{{substr($cola->fecha_desde, 0, -9)}}" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="fecha_hasta" class="form-label">Hasta:</label>              
                            <input id="fecha_hasta" type="date" disabled value="{{substr($cola->fecha_hasta, 0, -9)}}" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="puestos" class="form-label">Puestos:</label>              
                            <input id="puestos" type="text" disabled value="{{$cola->cant_puestos}}" class="form-control">                  
                        </div>
                    </div>
                    <br>                    
                    <u> Días de la semana:</u>
                    {{$str}}                    
                    <hr>
                    @if ($cola->publicado == 0)
                        <button class="btn btn-danger" onclick="borrarColaPopUp()">Borrar cola</button>
                    @endif
                    @if($turnos != 1)
                        <button class="btn btn-primary" onclick='generarTurnos()'>Generar turnos</button>
                    @else
                        <div>
                            <hr>                            
                            <div id="calendarioTracker" class="row">
                                <label for="datepicker">Seleccionar Fecha:</label>
                                <input style="width: 60%; margin-left:1%" class="form-control nofecha" type="date" id="datepicker" min={{$cola->fecha_desde}} max={{$cola->fecha_hasta}} onchange="fecha()">
                                <button class="btn btn-sm btn-success" style="width: 10%; margin-left:5%;" onclick="visualizarDia()">Visualizar día</button>
                            </div>     
                             <div id="diaTracker" hidden>     
                                <hr>                         
                                <table id="turnos" style="width: 100%">
                                    <thead id="turnos_head">
                                    </thead>
                                    <tbody id="turnos_body">                                        
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    @endif
                </div>
            </div>        
        </div>
    </section>

    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="popTitulo"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="popBody">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="popupBorrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Borrar Cola</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea borrar esta cola? No podrá recuperarla
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="borrarCola()">Borrar</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="popupTurno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Reservar un turno</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <label for="dni">Ingrese el DNI del titular:</label>
                <input type="number" id="dni" class="form-control" oninput="checkBtnVerificar()">
                <button class="btn btn-primary" onclick="verificarDni()" id="btnVerificar" disabled>Verificar</button>
                <div id="nom_titular" hidden>
                    <label for="nombre">Titular:</label>
                    <input type="nombre" id="nombre" class="form-control" disabled>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" disabled data-bs-dismiss="modal" id="btnReservar">Reservar</button>
            </div>
          </div>
        </div>
    </div>
    @include('layouts.favorito.editar', ['modo' => 'Agregar'])
    @include('layouts.modal.confirmation') 
@endsection