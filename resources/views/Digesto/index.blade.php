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
                        <button type="button" class="btn btn-success btn-block" id='btn-buscar' onclick="buscarArchivo()">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="archivo-on" hidden>
            <div class="col-lg-12 row">
                <button type="button" class="btn btn-sm" id='btn-volver'>Volver al buscador</button>
            </div>
            <div class="card col-lg-4" id='preview-org'>
                <div class="card-head">
                    <h5>Original</h5>                    
                </div>
                <div class="card-body">
                    <div id='info-original'></div>
                </div>
            </div>
            <div class="card col-lg-8" id='buscador-modif'>
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
                                <button type="button" class="btn btn-success btn-block" id='btn-buscar' onclick="buscarArchivoModificador()">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
    </div>
</section>
@include('layouts.modal.confirmation') 

@endsection
