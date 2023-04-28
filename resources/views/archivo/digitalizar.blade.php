@extends('layouts.app')

@section('content')  
<head>
    <link rel="stylesheet" href="{{asset('css/archivo/digitalizacion.css')}}">
    <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Digitalización de Archivos</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body">            
         @include('layouts.modal.mensajes')
         <div class="row">
            <section class="card" id="taggeo">
                <div class="card-head">
                    <h4>Sistema de Taggeo</h4>
                </div>
                <div class="card-body">
                    <hr>
                    <h5>Cabecera</h5>
                    <hr>
                    <div class="row rowtag">
                        <div class="col-lg-4">
                            {!! Form::label('*Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                                <option value="sel" selected>Seleccionar</option>
                                @foreach ($TipoDocumento as $tipo)                           
                                    <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                                @endforeach                        
                            </select>   
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('*Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select" id="subtipo" name="subtipo" hidden>
                                <option value="sel" selected>Seleccionar</option>
                                @php
                                $i=0; 
                                @endphp
                                @foreach ($SubTipoDocumento as $subtipo)
                                    <option id= "sub{{$i}}" value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}">{{$subtipo->dessubtipoarchivo}}</option>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach                        
                            </select>                 
                            <P id="placeholder">---</P>    
                        </div>
                        <div class="col-lg-2">
                            {!! Form::label('*Fecha:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::date('fecha', null, [
                                'min' => '1990-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fecha',
                                'class' => 'form-control']) !!}
                        </div>                
                        <div class="col-lg-1 ">
                            {!! Form::label('*Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::number('orden', 1, ['class' => 'form-control', 'id'=>'orden', 'min'=>'1', 'max'=>'5']) !!}
                        </div>          
                    </div>
                    <div class="row rowtag">
                        {{-- <div class="col-lg-3">
                            {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="empresa" name="empresa">
                                <option value="sel" selected>Seleccionar</option>
                                @foreach ($Empresas as $emp)                           
                                    <option value="{{$emp->id_emp}}">{{$emp->nom_emp}}</option>
                                @endforeach                        
                            </select>   
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="local" name="local">
                                <option value="sel" selected>Seleccionar</option>
                                @foreach ($Localidades as $loc)                           
                                    <option value="{{$loc->id_loc}}">{{$loc->nom_loc}}</option>
                                @endforeach                        
                            </select>   
                        </div> --}}
                       
                        <div class="col-lg-3">
                            {!! Form::label('*Nº Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('doc', null, ['class' => 'form-control no-spin', 'id'=>'doc', 'min'=>'0']) !!}
                        </div>
                        <div class="col-lg-8">
                            {!! Form::label('Asunto:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            {!! Form::textarea('asunto', null, [
                            'rows' => '10',
                            'class' => 'form-control',
                            'id'    =>  'asunto',
                            'style' => 'text-transform:uppercase',
                            'maxlenght'=>'200',
                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("charasun", "asunto", 200)',
                        ]) !!}
                        <label for="asunto" id="charasun">Quedan 200 caracteres.</label>
                        </div>
                          
                    </div>                                       
                    <hr>              
                    <div class="row rowbot">
                        <div class="col-lg-3 btnes flex">
                            <input type="radio" class="btn-check" name="opcion" id="guardar" autocomplete="off" onclick="existeCheck()" disabled>
                            <label class="btn btn-outline-success btn-block" for="guardar">Agregar</label>
                        </div>                    
                        <div class="col-lg-3 btnes flex">
                            <input type="radio" class="btn-check" name="opcion" id="modificar" autocomplete="off" onclick="existeCheck()" disabled>
                            <label class="btn btn-outline-primary btn-block" for="modificar">Modificar</label>
                        </div>                            
                        <div class="col-lg-3 btnes flex">
                            <input type="radio" class="btn-check" name="opcion" id="borrar" autocomplete="off" onclick="existeCheck()" disabled>
                            <label class="btn btn-outline-danger btn-block" for="borrar">Borrar</label>    
                        </div>                        
                    </div>
                    <hr>
                    <div id="sectags" hidden>
                        <div class="row rowtag">
                            <div id="pdfver" hidden>          
                                <label for="pdfver">PDF Actual:</label>                                                                
                                <object id="pdfver" data="" type="application/pdf"></object>
                                <a href="" id="linkpdf"></a>     
                                <br>
                                {!! Form::label('Cambiar pdf:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                                {!! Form::file('pdf', ['accept' => 'application/pdf', 'id'=>'pdf'])!!}
                            </div>
                            <div id="pdfguar" hidden>
                                {!! Form::label('Subir archivo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                                {!! Form::file('pdf', ['accept' => 'application/pdf', 'id'=>'pdf'])!!}
                            </div>                                                
                        </div> 
                        <hr>
                        <h5>Claves</h5>
                        <hr>
                        <div id="showtags">
                            <div id="sec-obligatorio">
                                <h6>Claves Obligatorias</h6>
                                <div id="comp-obligatorio" class="container-fluid">
                                </div>
                                
                                <hr>
                            </div>
                            <div id="sec-recomendado">
                                <h6>Claves Recomendadas</h6>
                                <div id="comp-recomendado" class="container-fluid">           

                                </div>
                                <hr>
                            </div>
                            <div id="sec-opcional">
                                <h6>Otras Claves</h6>
                                
                                <div id="comp-opcional" class="container-fluid"></div>
                                <br>
                                <div class="row">
                                <div id="agregar" hidden>
                                {!! Form::label('Agregar una clave:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                <select class="form-select" id="tag" name="tag" onchange="completartag()">
                                    <option value="sel" selected>Seleccionar</option>                                    
                                    @foreach ($Tags as $tag)
                                        <option value="{{$tag->id_tag}}">{{$tag->descripcion}}</option>
                                    @endforeach       
                                </select>  
                                <button class="btn btn-success" id='btn-tag' onclick="agregarTag()">Agregar</button>
                                </div>  
                                <div id="tag-agregar" class="row">
                                </div>
                                <button class="btn btn-success" id='btn-conf' onclick="confirmar()" hidden>Confirmar</button>
                                </div> 
                            </div>
                            </div>                          
                            
                        </div>
                        <hr>{!! Form::textarea('claves', null, ['id'=>'claves','maxlenght'=>'1040', 'style' => 'text-transform:uppercase', 'class' => 'form-control', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("characla", "claves", 1040)'])!!}
                        <label for="claves" id="characla">Quedan 1040 caracteres.</label>
                        <hr>
                        <div class="row rowbot">
                            <div class="col-lg-4 btnes flex" id="div-btnborrar" hidden> 
                                <button id="btnborrar" class="btn btn-danger btn-block">Borrar</button>
                            </div>
                            <div class="col-lg-4 btnes flex" id="div-btnmodificar" hidden> 
                                <button id="btnmodificar" class="btn btn-primary btn-block">Modificar</button>
                            </div>
                            <div class="col-lg-4 btnes flex" id="div-btnguardar" hidden> 
                                <button id="btnguardar" class="btn btn-success btn-block">Guardar</button>
                            </div>                        
                        </div>
                    </div>                    
                </div>
            </section>            
         </div>
    </div>    
</section>

@include('layouts.modal.confirmation') 

@endsection

