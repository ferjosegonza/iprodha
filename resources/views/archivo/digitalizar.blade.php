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
         <div id="padre" class="row">            
            <section class="card" id="taggeo">
                <form id="formArchivo" method="POST" enctype="multipart/form-data">
                <div class="card-head">
                    <h4>Sistema de Taggeo</h4>
                </div>
                <div class="card-body">
                    <hr>
                    <h5>Cabecera</h5>
                    <hr>
                    <div class="row rowtag">
                        <div class="col-lg-3">
                            {!! Form::label('*Visibilidad del documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="encabezado" name="enc" onchange="encabezados()">
                                <option value="1" selected>Público</option>
                                <option value="3">Privado</option>                       
                            </select>   
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('*Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
                                <option value="sel" selected>Seleccionar</option>
                                @foreach ($TipoDocumento as $tipo)                           
                                    <option value="{{$tipo->id_tipocabecera}}|{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                                @endforeach                        
                            </select>   
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('*Subtipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <select class="form-select" id="subtipo" name="subtipo" hidden>
                                <option value="sel" selected>Seleccionar</option>
                                @php
                                $i=0; 
                                @endphp
                                @foreach ($SubTipoDocumento as $subtipo)
                                    <option id= "sub{{$i}}" value="{{$subtipo->id_tipoarchivo}}|{{$subtipo->id_subtipoarchivo}}_{{$subtipo->id_tipocabecera}}">{{$subtipo->dessubtipoarchivo}}</option>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach                        
                            </select>                 
                            <P id="placeholder">---</P>    
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('*Fecha:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::date('fecha', null, [
                                'min' => '1978-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'fecha',
                                'class' => 'form-control',
                                'onkeydown'=>"return false"]) !!}
                            <span id="avisofecha" hidden>¡Cuidado! Se excede la fecha de hoy</span>
                        </div>                
                               
                    </div>
                    <div class="row rowtag">   
                        <div class="col-lg-1 ">
                            {!! Form::label('*Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::number('orden', 1, ['class' => 'form-control', 'id'=>'orden', 'min'=>'1', 'max'=>'5']) !!}
                        </div>                       
                        <div class="col-lg-3">
                            {!! Form::label('*Nº Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::number('doc', null, ['class' => 'form-control no-spin', 'id'=>'doc', 'min'=>'0']) !!}
                        </div>
                        <div class="col-lg-8">
                            {!! Form::label('Asunto:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                            {!! Form::text('asunto', null, [
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
                            <input type="radio" class="btn-check" name="opcion" id="modificar" autocomplete="off" onclick="checkArchivos()" disabled>
                            <label class="btn btn-outline-primary btn-block" for="modificar">Modificar</label>
                        </div>                           
                    </div>
                    
                    <div id="sectags" hidden>
                        <div class="row rowtag">
                            <div id="sec-pdf" hidden>
                                <hr>
                                <h6 >Archivo PDF</h6>
                                <div id="pdfguar" > 
                                    <button type='button' class="btn btn-warning" onclick="modalPdf()" id="btnsubirpdf">Subir PDF</button>
                                </div>                                
                                <div id="previewpdf" hidden>    
                                    <span hidden id="spanPdf"></span>                                  
                                    <table id="radio-pdf">
                                        <td><a onclick="cambiarDireccionPDF('N')"><i class="fas fa-ban"></i></a></td>
                                        <td><a onclick="cambiarDireccionPDF('V')"><i class="fas fa-file-alt"></i></a></td>
                                        <td><a onclick="cambiarDireccionPDF('H')"><i class="fas fa-pager"></i></a></td>
                                    </table>
                                    <embed id="embedpdf" 
                                    src=""
                                    width="100%"
                                    height="400">
                                </div>
                            </div>                                                
                        </div> 
                        <hr>                        
                        <h5>Claves</h5>
                        <hr>
                        <div id="showtags">
                            <div id="sec-obligatorio">
                                <h6>Claves Obligatorios</h6>
                                <div id="comp-obligatorio" class="container-fluid"></div>
                                <hr>
                            </div>
                            <div id="sec-recomendado">
                                <h6>Claves Recomendadas</h6>
                                <div id="comp-recomendado" class="container-fluid"></div>
                                <hr>
                            </div>
                            <div id="sec-opcional">
                                <h6>Otras Claves</h6>
                                <div id="comp-opcional" class="container-fluid"></div>
                                <br>
                                <div class="row" id="agregar" hidden>
                                    <div class="col-lg-10">
                                    {!! Form::label('Agregar una clave:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    <select class="form-select" id="tag" name="tag" onchange="completarTag()">
                                        <option value="sel" selected>Seleccionar</option>                                    
                                        @foreach ($Tags as $tag)
                                            <option value="{{$tag->id_tag}}|{{$tag->descripcion}}">{{$tag->descripcion}}</option>
                                        @endforeach       
                                    </select>  
                                    </div>
                                    <div class="col-lg-1">
                                        <br>
                                        <button class="btn btn-success" id='btn-tag' onclick="agregarTag()" type="button" disabled>+</button>
                                    </div>                 
                                        <div id="tag-agregar" class="row" hidden>
                                    </div>
                                </div> 
                            </div>
                            </div>                          
                             <hr>{!! Form::textarea('claves', null, ['id'=>'claves','maxlenght'=>'1040', 'style' => 'text-transform:uppercase', 'class' => 'form-control', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("characla", "claves", 1040)'])!!}
                            <label for="claves" id="characla">Quedan 1040 caracteres.</label>
                            <hr>
                            <div class="row rowbot">                          
                                <div class="col-lg-4 btnes flex" id="div-btnguardar" hidden>                                
                                    <button id="btnguardar" class="btn btn-success btn-block" type="button" onclick="modal(1)">Guardar</button>                                
                                </div> 
                                <div class="col-lg-4 btnes flex" id="div-btnmodificar" hidden> 
                                    <button id="btnmodificar" class="btn btn-primary btn-block" type="button" onclick="modal(2)">Modificar</button>
                                </div>              
                            </div>
                        </div>    
                    </div>                    
                </div>            
            </form> 
            </section>                   
         </div>
    </div>    
</section>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnConfirmarAccion"></button>
        </div>
      </div>
    </div>
</div>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="ocultarPagina()">Ok</button>
        </div>
      </div>
    </div>
</div>
@include('layouts.modal.confirmation') 

@endsection


