@extends('layouts.app')

@section('content')  
<head>
    <link rel="stylesheet" href="{{asset('css/digesto/index.css')}}">
    <script src="{{ asset('js/Coordinacion/Digesto/index.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Añadir Modificaciones</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body">    
        @include('layouts.modal.mensajes')      
        <div class="row" id='buscador-org'>
            <div class="card col-lg-12">
                <div class="card-head">
                    <h4>Buscar archivo original</h4>
                </div>
                <div class="card-body row">
                    <div class="col-lg-3">
                        {!! Form::label('*Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                            @foreach ($tipos as $tipo)                           
                                <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                            @endforeach                        
                        </select>   
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('*Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                        <select class="form-select" id="subtipo" name="subtipo">
                            @foreach ($subtipos as $subtipo)
                                <option value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                            @endforeach                        
                        </select>    
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('*Nº Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                        {!! Form::number('doc', null, ['class' => 'form-control no-spin', 'id'=>'doc', 'min'=>'0']) !!}
                    </div>
                    <div class="col-lg-3"> 
                        <button type="button" class="btn btn-success btn-block" id='btn-buscar' onclick="buscarArchivo()" disabled>Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="archivo-on" hidden>
            <div class="col-lg-12 row">
                <button type="button" class="btn btn-sm" id='btn-volver' onclick='volveralbuscador()'>Volver al buscador</button>
            </div>
            <div class="card col-lg-6" id='preview-org' hidden>
                <div class="card-head">
                    <h5>Original</h5>                    
                </div>
                <div class="card-body row">
                    <div id='claves-org'></div>
                    <br> 
                    <embed src="#" width="100%" height="450" id="emb-org">
                    <div class="col-lg-6">
                        <h6>Áreas que afecta:</h6>
                        <table id="areas-afectadas"></table>
                    </div>
                    <div class="col-lg-6 row">
                        <div class="col-lg-11"><h6>Agregar un área:</h6>
                            <select class="form-select" id="area_select" onchange="checkBtnAgregar()" name="area_select">
                                <option value="sel" selected>Seleccionar</option>
                                @foreach ($areas as $area)                           
                                    <option value="{{$area->idarea}}">{{$area->area}}</option>
                                @endforeach                        
                            </select>   
                        </div>
                        <button class="btn btn-sm btn-success col-lg-1" id="btn-agregar-area" onclick="add_area()" disabled>+</button>
                    </div>
                </div>
            </div>
            <div class="card col-lg-6" id='buscador-modif' hidden>
                <div class="card-head">
                    <h5>Buscar archivo que modifica el original</h5>                    
                </div>
                <div class="card-body">
                    <div>
                        <div class="card-body row">
                            <div class="col-lg-3">
                                {!! Form::label('*Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                                <select class="form-select" id="tipo2" onchange="tipos()" name="tipo2">
                                    @foreach ($tipos as $tipo)                           
                                        <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                                    @endforeach                        
                                </select>   
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('*Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                <select class="form-select" id="subtipo2" name="subtipo2">
                                    @foreach ($subtipos as $subtipo)
                                        <option value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                                    @endforeach                        
                                </select>    
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('*Nº Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::number('doc2', null, ['class' => 'form-control no-spin', 'id'=>'doc2', 'min'=>'0']) !!}
                            </div>
                            <div class="col-lg-3"> 
                                <button type="button" class="btn btn-success btn-block" id='btn-buscar2' onclick="buscarArchivoModificador()" disabled>Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 card" id='preview-modificador' hidden>
                <div class="col-lg-12">
                    <div class="card-head">
                        <h5>Modificador</h5>
                    </div>
                    <div class="card-body">
                        <div id='claves-modif'></div>
                        <br> 
                        <embed src="#" width="100%" height="450" id="emb-modif">
                    </div>
                </div>
                <div class="col-lg-12">
                    <h6>Cargar Observaciones</h6>
                    <textarea id="observaciones" onkeyup="contadorchar('lab-obs','observaciones',500)"></textarea>
                    <label for="observaciones" id="lab-obs">Quedan 500 caracteres</label>
                    <button type="button" class="btn btn-success btn-block" onclick="guardar()">Guardar Relación</button>
                </div>        
            </div>
        </div>          
    </div>
</section>
<div class="modal fade modal-sm" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="popTitulo"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="popBody">
        </div>
        <div class="modal-footer">
          <button id='ok' type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="volveralbuscador()">Ok</button>
        </div>
      </div>
    </div>
</div>
@include('layouts.modal.confirmation') 

@endsection
