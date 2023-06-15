@extends('layouts.app')

@section('content')  
<head><link rel="stylesheet" href="{{asset('css/archivo/index.css')}}">
    <script src="{{ asset('js/archivo/index.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">  
</head>
    <section class="section">
        <div class="section-header">
            <div class="titulo page__heading">Búsqueda de Archivos Digitalizados</div>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        <div class="section-body">            
            @include('layouts.modal.mensajes')            
            <div class="container row barraBusqueda">                
                <div class="row align-items-center col-lg-9">                               
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 flex">     
                        <label id="labelswitch">Elegir entre fechas</label>
                        <label class="switch">
                            <input type="checkbox" name="betwenyears" id="betwenyears" onclick="toggle()">
                            <span class="slider round"></span>
                        </label>          
                         
                        <div id="yearIn">
                            {!! Form::label('Año:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select" id="año" onchange="year()" name="ano">
                            <option value="sel" selected>Seleccionar</option>
                            @for($i=date("Y");$i>=1990;$i--)
                                <option value="{{$i}}">{{$i}}</option>                                     
                            @endfor                    
                        </select>  </div>       
                        <div id="dateIn" hidden>
                            {!! Form::label('Rango de fechas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <input type="date" id='min' name="fecha1" value="sel">
                            <input type="date" id='max' name="fecha2" value="sel">                        
                        </div> 
                    </div>                       
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 flex">
                    {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                            <option value="sel" selected>Seleccionar</option>
                            @foreach ($TipoDocumento as $tipo)                            
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
                            @foreach ($SubTipoDocumento as $subtipo)
                                <option id= "sub{{$i}}" value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->dessubtipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                                @php
                                    $i++;
                                @endphp
                            @endforeach                        
                        </select>                 
                        <P id="placeholder">---</P>    
                    </div>  
                    
                </div>
                <div class="row align-items-center col-lg-9">    
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 flex" hidden>
                        <br>
                        <button class="btn btn-success" id="btn-agregar-tag" type="button" onclick="agregarTag()" disabled>+</button>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3 flex">
                        {!! Form::label('Etiquetas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="tag" onchange="tags()" name="tag">
                                <option value="sel" selected>Seleccionar</option>                                
                                @foreach ($Tags as $tag)                            
                                    <option value="{{$tag->id_tag}}|{{$tag->descripcion}}">{{$tag->descripcion}}</option>                                    
                                @endforeach                        
                            </select>   
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3 flex" >
                            <div id="inp-tag" hidden>                                
                                <div id="tag-comp"></div>
                            </div>                                      
                            <P id="placeholder-tag">---</P>    
                        </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 flex">
                        {!! Form::label('Buscar por otros parámetros:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <input type="text" name="busqueda" id="busq" onkeyup="filtrar()" class="form-control" placeholder="Ej: DNI:00000000 o 00000000">
                        {{--  {!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busq', 'onchange'=>'filtrar()', 'placeholder'=>'Ej: DNI:00000000 o 00000000']) !!}  --}}
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2" id="btnbusq">
                    <label for="btnb">Encuentre lo que busca:</label>
                    <button type="button" class="btn btn-success" id='btnb' disabled onclick="buscarArchivos()">Buscar</button>
                </div>        
                                    
            </div>            
            <div class="row tags-añadidos" id="tags-añadidos" hidden>
                <input type="text" id='tag-acumulado' name="tag-acumulado" hidden>  
            </div>   
            <div>
                 <button onclick="cargarBoletin()" id="areset">Cargar boletín</button>
                <label id="aclaracion">(Por defecto verás los archivos correspondientes al último boletín)</label>
            </div>
            <div class="row abajo card">
                <div class="tabla card-body table-responsive col-xs-9 col-sm-9 col-md-9 col-lg-9 flex">
                    <table id="archivos" class="table display table-hover mt-2" class="display">
                        <thead>
                            <tr>
                                <th class="text-center imprimir" scope="col" style="color:#fff;width:1%;"></th>
                                <th class="text-center tipo" scope="col" style="color:#fff;width:8.5%;">Tipo</th>
                                <th class="text-center sub" scope="col" style="color:#fff;width:15%;">Subtipo</th>                                    
                                <th class="text-center fecha" scope="col" style="color:#fff;width:10%;">Fecha</th>
                                <th class="text-center nro" scope="col" style="color:#fff;width:7%;">Nro Archivo</th>
                                <th class="text-center asun" scope="col" style="color:#fff;width:25%;">Asuntos Claves</th>
                                <th hidden class="path"></th>
                                <th hidden class="orden"></th>
                            </tr>
                        </thead>          
                    </table>
                </div>                
            </div>
            <div class="preview row" id="preview" hidden>
                <div class="card cardpre">
                    <div class="card-body">
                        <button id="cancelar" type="button" class="btn btn-danger" onclick="cancelarbusqueda()">X</button>
                        <h5 class="card-title" id="pdftitle">PDF:</h5> 
                        <p id="despdf"> </p>
                        <object id="pdfver" data="http:\\localhost\Documentos\Cedulas\CED-ADJ-0018146349-20230316.pdf" type="application/pdf" ></object>
                        <a id="linkpdf" href="https://www.africau.edu/images/default/sample.pdf" target="_blank">Ver más</a>
                        {{-- <p id="ruta"></p> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.modal.confirmation') 
@endsection
    
