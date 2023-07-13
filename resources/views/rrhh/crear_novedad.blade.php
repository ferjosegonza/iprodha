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
                            Creando una nueva novedad que formará parte del historial del agente {{$agente->apellido}}, {{$agente->nombre}}. Número de Documento: {{$agente->nrodoc}}
                            <hr>
                            <h5>Historial Actual</h5>
                            <table>
                                <thead></thead>
                            </table>
                            <hr>
                            <div id="crear">
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
                                <button class="btn btn-success" id="btndoc" onclick="documento()">Agregar documento avalador</button>
                                <div id="documento" hidden>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 flex">
                                            {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                                            <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                                                <option value="sel" selected>Seleccionar</option>
                                                @foreach ($tipos as $tipo)                            
                                                    <option value="{{$tipo->id_tipoarchivo}}|{{$tipo->nombre_corto}}">{{$tipo->nombre_corto}}</option>
                                                @endforeach                        
                                            </select>   
                                        </div>    
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 flex" >
                                            {!! Form::label('Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                            <select class="form-select" id="subtipo" onchange="subtipos()" name="subtipo" hidden>
                                                <option value="sel" selected>Seleccionar</option>
                                                @php
                                                $i=0; 
                                                @endphp
                                                @foreach ($subtipos as $subtipo)
                                                    <option id= "sub{{$i}}" value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->dessubtipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach                        
                                            </select>                 
                                            <P id="placeholder">---</P>    
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 flex" >
                                            <label for="nro" class="control-label">Número de Documento</label> 
                                            <input type="text" id="nro" class="form-control">   
                                        </div>              
                                    </div>       
                                    <button class="btn btn-success">Buscar</button>
                                </div>                    
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </section>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
