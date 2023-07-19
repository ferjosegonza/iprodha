@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/rrhh/crear_novedades.css')}}">
    <script src="{{ asset('js/Coordinacion/rrhh/crear_novedades.js') }}"></script>
</head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Historial del Agente</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-12">
                    @include('layouts.modal.mensajes')
                    <div class="card col-sm-12">
                        <div class="card-body"> 
                            <div hidden id="id">{{$agente->idagente}}</div>
                            <div hidden id="idhistorial"></div>
                            Modificando el historial del agente {{$agente->apellido}}, {{$agente->nombre}}. Número de Documento: {{$agente->nrodoc}}
                            <hr>
                            <h5>Historial Actual</h5>
                            <table id="historial">
                                <thead>
                                    <th>Fecha</th>
                                    <th>Novedad</th>
                                    <th>Archivo</th>
                                    <th>Observacion</th>
                                    <th>Editar</th>
                                </thead>
                                <tbody id='info-historial'>
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <a href="/rrhh/novedades" class="btn btn-light">Volver a la página anterior</a>
                            <button class="btn btn-success" onclick="mostrarCrear()" id="btncrear">Crear nueva instancia del historial</button>
                            <button class="btn btn-danger" id="btnocultar" onclick="ocultarCrear()" hidden>X</button>
                            
                            <br>
                            <div id="crear" hidden>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="fecha" class="control-label">Fecha</label>
                                        <input class="form-control" id="fecha" type="date">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="detalle" class="control-label">Detalle</label>
                                        <input type="text" id="detalle" class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="observacion" class="control-label">Observacion</label>
                                        <input type="text" id="observacion" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                    <table hidden id="docsasociados">                                    
                                    <thead>
                                        <th>Documento avalador</th>
                                        <th>Eliminar</th>
                                        <th hidden></th>
                                    </thead>
                                    <tbody id='infoasociados'>

                                    </tbody>
                                    </table>
                                </div>
                                
                                <br>
                                <input type="radio" class="btn-check" id="btnguardar" name="options" onclick="guardar()" disabled>
                                <label for="btnguardar" class="btn btn-success" id="lbl-guardar">Guardar instancia</label>
                                <input type="radio" class="btn-check" id="btnmodificar" name="options" onclick="modificar()" disabled>
                                <label for="btnmodificar" class="btn btn-success" id="lbl-modificar">Modificar instancia</label>
                                <input type= "radio" class="btn-check" id="btndoc" onclick="documento()" name="options">
                                <label for="btndoc" class="btn btn-primary">Agregar documento avalador</label>
                                <div id="documento" hidden>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex">
                                            {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                                            <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                                                <option value="sel" selected>Seleccionar</option>
                                                @foreach ($tipos as $tipo)                            
                                                    <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                                                @endforeach                        
                                            </select>   
                                        </div>    
                                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                            {!! Form::label('Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            <select class="form-select" id="subtipo" onchange="subtipos()" name="subtipo" hidden>
                                                <option value="sel" selected>Seleccionar</option>
                                                @php
                                                $i=0; 
                                                @endphp
                                                @foreach ($subtipos as $subtipo)
                                                    <option value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach                        
                                            </select>                 
                                            <P id="placeholder">---</P>    
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                            <label for="nro" class="control-label">Número de Documento</label> 
                                            <input type="text" id="nro" class="form-control">   
                                        </div>     
                                        <div class="col-lg-3">
                                            <br>
                                            <button class="btn btn-success" onclick="buscarArchivos()">Buscar</button>    
                                        </div>         
                                    </div>     
                                    <div class="row">
                                        <div id="elegirArchivo" class="col-lg-12" hidden>
                                            <table id="archivos">
                                                <thead>
                                                    <th>Documento</th>
                                                    <th>Claves</th>
                                                </thead>
                                                <tbody id="infoarchivos">

                                                </tbody>
                                            </table>                                
                                        </div>      
                                        <div id="previewpdf" hidden class="col-lg-6"> 
                                            <h5 id="title-preview"></h5>
                                            <embed src="#" id="pdfembed">
                                            <button class="btn btn-primary" id="btn-preview">Guardar como documento avalatorio</button>
                                        </div>
                                    </div>
                                                                          
                                </div>                    
                            </div>  
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
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="popBody">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="ocultarCrear()">Ok</button>
                </div>
              </div>
            </div>
        </div>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
