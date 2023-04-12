@extends('layouts.app')
@section('content')  

<head><link rel="stylesheet" href="{{asset('css/archivo/index.css')}}"></head>

    <section class="section">
        <div class="section-header">
            <div class="titulo page__heading">Búsqueda de Archivos Digitalizados</div>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        <div class="section-body">            
            @include('layouts.modal.mensajes')
            <div class="row barraBusqueda">                
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 flex">                        
                    {!! Form::label('Año:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    <select class="form-select" id="año" onchange="year()">
                        <option value="sel" selected>Seleccionar</option>
                        @for($i=date("Y");$i>=1990;$i--)
                            <option value="{{$i}}">{{$i}}</option>                                     
                        @endfor                    
                    </select>   
                    
                </div>                       
                <div class="col-xs-2 col-sm-3 col-md-3 col-lg-3 flex">
                {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                    <select class="form-select" id="tipo" onchange="tipos()">
                        <option value="" selected>Seleccionar</option>
                        @php
                               $i=0; 
                        @endphp
                        @foreach ($TipoDocumento as $tipo)                            
                            <option value="{{$tipo->id_tipoarchivo}}{{$tipo->nombre_corto}}">{{$tipo->nombre_corto}}</option>
                            @php
                                $i++;
                            @endphp
                        @endforeach                        
                    </select>   
                </div>    
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 flex" >
                    {!! Form::label('Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    <select class="form-select" id="subtipo" onchange="subtipos()" hidden>
                        <option value="" selected>Seleccionar</option>
                        @php
                        $i=0; 
                        @endphp
                        @foreach ($SubTipoDocumento as $subtipo)
                            <option id= "sub{{$i}}" value="{{$subtipo->id_tipoarchivo}}{{$subtipo->dessubtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                            @php
                                $i++;
                            @endphp
                        @endforeach                        
                    </select>                 
                    <P id="placeholder">---</P>    
                </div>                
                </div>  
                <div class="archivos">                    
                </div>
            </div>
            <div class="row abajo">
                <div class="tabla table-responsive col-xs-9 col-sm-9 col-md-9 col-lg-9 flex">
                    <table id="archivos" class="table display table-hover mt-2" class="display">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="color:#fff;width:1%;"></th>
                                <th class="text-center tipo" scope="col" style="color:#fff;width:8.5%;">Tipo</th>
                                <th class="text-center sub" scope="col" style="color:#fff;width:15%;">Subtipo</th>                                    
                                <th class="text-center fecha" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                <th class="text-center nro" scope="col" style="color:#fff;width:7%;">Nro Archivo</th>
                                <th class="text-center asun" scope="col" style="color:#fff;width:25%;">Asuntos Claves</th>
                                <th hidden></th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach ($archivos as $archivo)
                            <tr>
                                <td> <button class="btn"><i class="fas fa-print" style="color: #ff9f79;"></i></button></td>
                                <td>{{$archivo->nombre_corto}}</td>
                                <td>{{$archivo->dessubtipoarchivo}}</td>
                                <td>{{$archivo->dia_archivo}}-{{$archivo->mes_archivo}}-{{$archivo->ano_archivo}}</td>
                                <td>{{$archivo->nro_archivo}}</td>
                                <td>{{$archivo->claves_archivo}}</td>      
                                <td hidden>{{$archivo->path_archivo . $archivo->nombre_archivo}} </td>              
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="preview col-xs-3 col-sm-3 col-md-3 col-lg-3 flex" id="preview" hidden>
                    <div class="card cardpre">
                        <div class="card-body">
                            <button id="cancelar" class="btn btn-danger" onclick="cancelarbusqueda()">X</button>
                            <h5 class="card-title" id="pdftitle">PDF:</h5> 
                            <p id="despdf"> </p>
                            <object id="pdfver" data="http:\\localhost\Documentos\Cedulas\CED-ADJ-0018146349-20230316.pdf" type="application/pdf" ></object>
                            <a id="linkpdf" href="https://www.africau.edu/images/default/sample.pdf" target="_blank">Ver más</a>
                            {{-- <p id="ruta"></p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.modal.confirmation') 
@endsection
    
@section('js')
<script src="{{ asset('js/archivo/index.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
@endsection