@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/rrhh/novedades.css')}}">
    <script src="{{ asset('js/Coordinacion/rrhh/novedades.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>


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
                           <div id='buscador'> 
                                <h5>Buscar por DNI</h5>
                                {!! Form::number('dni', null, ['id'=>'dni', 'class' => 'form-control', 'min' => '0']) !!}
                                <button class="btn btn-success" id="buscar" onclick="buscarAgente()" disabled>Buscar</button>                                
                           </div>                          
                           <div id="resultados" hidden>
                                <hr>
                                <h4>Información del Agente</h4>
                                <div id="dnipdf"hidden>
                                    <button class="btn btn-secondary" onclick="mostrarDni()">Ver DNI del agente</button>
                                    <br>
                                    <embed id="dniemb" src="#" type="" width="600" height="300" hidden>
                                </div>
                                <div class="row">
                                    <div class=" col-lg-2"> 
                                        <label for="dni2" class="control-label">DNI</label>
                                        <input type="text" id="dni2" class="form-control" disabled>                              
                                    </div>
                                    <div class=" col-lg-2"> 
                                        <label for="nombre" class="control-label">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" disabled>                              
                                    </div>
                                    <div class=" col-lg-2"> 
                                        <label for="apellido" class="control-label">Apellido</label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" disabled>       
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="agrupamiento" class="control-label">Agrupamiento</label>
                                        <input type="text" id="agrupamiento" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="categoria" class="control-label">Categoria</label>
                                        <input type="text" id="categoria" class="form-control" disabled>
                                    </div>
                                </div>    
                                <hr>
                                <h5>Historial del Agente</h5>                                
                                <i onclick="excel('xlsx')" class="fa fa-file-excel fa-2x" style="color: #008a09;"></i>
                                <i onclick="exportPDF()" class="fa fa-file-pdf fa-2x" style="color: #ff0000;"></i>
                                <table id="historial"> 
                                    <thead>
                                        <th>Fecha</th>
                                        <th>Novedad</th>
                                        <th>Archivo</th>
                                        <th>Observacion</th>
                                    </thead>
                                    <tbody id='info-historial'>

                                    </tbody>
                                </table>             
                                <button class="btn btn-primary" onclick="redirect()">Crear o modificar el historial</button>        
                                                      
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitulo"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                      
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnConfirmarAccion">Crear</button>
            </div>
          </div>
        </div>
    </div>
    <div hidden id="id"></div>
    <div hidden id="url"></div>
    @include('layouts.favorito.editar', ['modo' => 'Agregar'])
    @include('layouts.modal.confirmation') 
    @endsection
