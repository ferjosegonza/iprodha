@extends('layouts.app')

@section('content')  
<head>
    <link rel="stylesheet" href="{{asset('css/digesto/buscador.css')}}">
    <script src="{{ asset('js/Coordinacion/Digesto/buscador.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Buscar Archivo Sujeto a Modificaciones</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body">    
        <div class="row card">
            <div class="card-head">
                <h5>Buscador</h5>                
            </div>
            <div class="card-body row">
                <p>Podrá encontrar un archivo y a qué cadena de modificaciones pertenece.</p>
                <div class="col-lg-2">
                    {!! Form::label('*Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                    <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                        @foreach ($tipos as $tipo)                           
                            <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                        @endforeach                        
                    </select>   
                </div>
                <div class="col-lg-2">
                    {!! Form::label('*Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    <select class="form-select" id="subtipo" name="subtipo">
                        @foreach ($subtipos as $subtipo)
                            <option value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                        @endforeach                        
                    </select>    
                </div>
                <div class="col-lg-2">
                    {!! Form::label('*Nº Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::number('doc', null, ['class' => 'form-control no-spin', 'id'=>'doc', 'min'=>'0']) !!}
                </div>
                <div class="col-lg-2">
                    {!! Form::label('*Año Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::number('año', null, ['class' => 'form-control no-spin', 'id'=>'año', 'min'=>'0']) !!}
                </div> 
                <div class="col-lg-2"> 
                    <button type="button" class="btn btn-success btn-block" id='btn-buscar' onclick="buscarArchivo()" disabled>Buscar</button>
                </div>
            </div>            
        </div>
        <div class="card row" id="preview" hidden>
            <div class="card-head">
                <h5>Archivo encontrado </h5> 
            </div>
            <div class="card-body">
                <div id='nro'></div>
                <div id='obs'></div>
                <embed src="#" type="" id="pdf">
                {!! Form::open(['route' => 'digesto.modificaciones', 'method' => 'GET']) !!}
                <input type="number" name="id" id="id" hidden>
                <button class="btn btn-success btn-block" id="btn">Buscar</button>
                {!! Form::close() !!}
            </div>
        </div>
        @include('layouts.modal.mensajes')        
    </div>
</section>
@include('layouts.modal.confirmation') 
@endsection