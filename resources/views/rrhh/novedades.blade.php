@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/rrhh/novedades.css')}}">
    <script src="{{ asset('js/Coordinacion/rrhh/novedades.js') }}"></script>
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
                                {!! Form::number('dni', null, ['id'=>'dni', 'class' => 'form-control']) !!}
                                <button class="btn btn-success" id="buscar" onclick="buscarAgente()" disabled>Buscar</button>
                           </div>                          
                           <div id="resultados" hidden>
                                <hr>
                                <h4>Información del Agente</h4>
                                <div class="row">
                                    <div class=" col-lg-4"> 
                                        <label for="nombre" class="control-label">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" disabled>                              
                                    </div>
                                    <div class=" col-lg-4"> 
                                        <label for="apellido" class="control-label">Apellido</label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" disabled>       
                                    </div>
                                </div>    
                                <hr>
                                <h5>Historial del Agente</h5>
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
