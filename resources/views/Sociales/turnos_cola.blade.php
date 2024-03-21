@extends('layouts.app')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/sociales/cola.css') }}">
        <script src="{{ asset('js/Sociales/cola.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
        <script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    </head>
    <section class="section">
        <div class="section-header">            
            <h3 class="page__heading">Generar Turnos</h3>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <input type="text" hidden value="{{$cola->idcola}}" id="id">
                    <h5 style="margin: 1%" id="titulo">{{ $cola->descripcion }} - {{$cola->denominacion}}</h5>        
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
                    <div>                           
                        <div id="calendarioTracker" class="row">
                            <label for="datepicker">Seleccionar Fecha:</label>
                            <input style="width: 60%; margin-left:1%" class="form-control nofecha" type="date" id="datepicker" min={{$cola->fecha_desde}} max={{$cola->fecha_hasta}} onchange="fecha()">
                            <button class="btn btn-sm btn-success" style="width: 10%; margin-left:5%;" onclick="visualizarDia()">Visualizar día</button>
                        </div>     
                            <div id="diaTracker" hidden>     
                            <hr>                 
                            Imprimir reporte del día: 
                            <br>         
                            <i onclick="exportPDF()" class="fa fa-file-pdf fa-2x" style="color: #ff0000;"></i>
                            <i onclick="excel('xlsx')" class="fa fa-file-excel fa-2x" style="color: #008a09;"></i>
                            <table id="turnos" style="width: 100%">
                                <thead id="turnos_head">
                                </thead>
                                <tbody id="turnos_body">                                        
                                </tbody>
                            </table>
                        </div>                            
                    </div>
                    <div class="row" style="display: grid;">
                        <a style="width:7%;justify-self: end;" href="/sociales/turnos" class="btn btn-primary">Volver </a>
                    </div>
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
              <h5 class="modal-title">Turno</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="bodyTurnoBorrar">
            </div>
            <div class="modal-footer" id="footerTurnoBorrar">
                
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