@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/Notarial/alta_tramite.css')}}">
    <script src="{{ asset('js/Coordinacion/Notarial/alta_tramite.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Dar de alta un trámite</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                @include('layouts.modal.mensajes')
                <div class="card col-sm-12">
                    <div class="card-body"> 
                        <h4>Datos del comitente</h4>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nro" class="control-label">Número de Documento</label> 
                                <input type="number" id="nro" class="form-control" min="0">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nro" class="control-label">Nombre Completo</label> 
                                <input type="text" id="nro" class="form-control">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nro" class="control-label">Email</label> 
                                <input type="email" id="nro" class="form-control">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nro" class="control-label">Celular</label> 
                                <input type="tel" id="nro" class="form-control">   
                            </div>   
                        </div>
                        <hr>
                        <h4>Datos del trámite</h4>                        
                        {!! Form::label('Tipo de trámite:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="sel" selected>Seleccionar</option>
                            @foreach ($tipos as $tipo)                            
                                <option value="{{$tipo->id_tipo}}">{{$tipo->descripcion}}</option>
                            @endforeach                        
                        </select>
                        <hr>                        
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="documento()">Documento</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="profesional()">Profesional</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="funcionario()">Funcionario</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="beneficiario()">Beneficiario</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="escribano()">Escribano</button>
                        <hr>
                        <div id="tabledoc" hidden>
                            <h5>Documento</h5>
                            <table class="tablita">
                                <thead>
                                    <th hidden>iddoc</th>
                                    <th>Número de Documento</th>
                                    <th>Asunto</th>
                                </thead>
                                <tbody id="docbody"></tbody>
                            </table>
                            <hr>
                        </div>
                        <div id="tableprof" hidden>
                            <h5>Profesional</h5>
                            <table class="tablita">
                                <thead>
                                    <th hidden>idtipo</th>
                                    <th>Tipo</th>
                                    <th hidden>idcaracter</th>
                                    <th>Caracter</th>
                                </thead>
                                <tbody id="profbody"></tbody>
                            </table>
                            <hr>
                        </div>
                        <div id="tablefunc" hidden>
                            <h5>Funcionario</h5>
                            <table class="tablita">
                                <thead>
                                    <th hidden>idtipo</th>
                                    <th>Tipo</th>
                                    <th>Observación</th>
                                </thead>
                                <tbody id="funcbody"></tbody>
                            </table>
                            <hr>
                        </div>
                        <div id="tablebenef" hidden>
                            <h5>Beneficiario</h5>
                            <table class="tablita">
                                <thead>
                                    <th>DNI</th>
                                    <th>OPE</th>
                                    <th>BARRIO</th>
                                    <th>ADJU</th>
                                    <th>APYNA</th>
                                </thead>
                                <tbody id="benefbody"></tbody>
                            </table>
                            <hr>
                        </div>
                        <div id="tableesc" hidden>
                            <h5>Escribano</h5>
                            <table class="tablita">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Matrícula</th>
                                </thead>
                                <tbody id="escbody"></tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEsc">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un escribano</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
           <h5>Buscar escribano</h5>
            {!! Form::label('Apellido y nombre:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            {!! Form::text('nomes', null, ['id' => 'nomes', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100']) !!}
            <button class="btn btn-primary" onclick="buscarEscribano()">Buscar</button>
            <div id="resultadoEsc" hidden>
                <br>
                <h5>Seleccionar un escribano: </h5>
                <table>
                    <th>Nombre</th>
                    <th>Matricula</th>
                    <th>Cuit</th>                    
                    <th>Teléfono</th>
                    <th>Email</th>
                    <tbody id="bodyesc">

                    </tbody>
                </table>
            </div>
            <div id="EscSeleccionado" hidden>
                <br>    
                <h5>Escribano seleccionado:</h5>
                <b style="font-size: 15px">NOMBRE: </b><label id="nomEsc"></label> 
                <b style="font-size: 15px">MATRICULA: </b><label id="matEsc"></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveEscribano()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalProf">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un profesional</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
            {!! Form::label('Tipo de profesional', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="profesional" name="profesional">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($profesional as $p)                            
                    <option value="{{$p->id_profesional}}">{{$p->descripcion}}</option>
                @endforeach                        
            </select>
            <br>
            {!! Form::label('Caracter del profesional:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="caracter" name="caracter">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($caracter as $c)                            
                    <option value="{{$c->id_caracter}}">{{$c->descripcion}}</option>
                @endforeach                        
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveProfesional()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalFunc">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un funcionario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
            {!! Form::label('Funcionario:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="funcionario" name="funcionario">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($funcionario as $f)                            
                    <option value="{{$f->id_tipo}}">{{$f->descripcion}}</option>
                @endforeach                        
            </select>
            <br>
            {!! Form::label('Observación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            {!! Form::text('obs', null, ['id' => 'obsFunc', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100']) !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveFuncionario()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalBenef">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un beneficiario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
            <h5>Buscar beneficiario</h5>
            {!! Form::label('DNI:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            {!! Form::text('dnibenef', null, ['id' => 'dnibenef', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100']) !!}
            <button class="btn btn-primary" onclick="buscarBeneficiario()">Buscar</button>
            <div id="resultadoBen" hidden>
                <br>
                <h5>Seleccionar un beneficiario: </h5>
                <table>
                    <th>Ope</th>
                    <th>Barrio</th>
                    <th>Adju</th>                    
                    <th>APYNA</th>
                    <tbody id="bodybenef">

                    </tbody>
                </table>
            </div>
            <div id="BenefSeleccionado" hidden>
                <br>    
                <h5>Beneficiario seleccionado:</h5>
                <b style="font-size: 15px">DNI: </b><label id="dniBef"></label> 
                <b style="font-size: 15px">OPE: </b><label id="opeBef"></label> 
                <b style="font-size: 15px">ADJU: </b><label id="adjBef"></label>
                <b style="font-size: 15px">BARRIO: </b><label id="barBef"></label>
                <b style="font-size: 15px">APYNA: </b><label id="apynaBef"></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveBeneficiario()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalDoc">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un beneficiario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
            <h5>Buscar documento</h5>
            {!! Form::label('Número de Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            {!! Form::text('nrodoc', null, ['id' => 'nrodoc', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100']) !!}
            {!! Form::label('Tipo de Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="tipodoc" name="tipodoc">
                <option value="sel" selected>Seleccionar</option>
                <option value="nota">Nota</option>
                <option value="exp">Expendiente</option>
            </select>
            <button class="btn btn-primary" onclick="buscarDocumento()">Buscar</button>
            <div id="resultadoDoc" hidden>
                <br>
                <h5 id="titulodoc"></h5>
                <table>
                    <th hidden>id</th>  
                    <th id>Número de Documento</th>
                    <th>Asunto</th>      
                    <tbody id="bodydoc">

                    </tbody>
                </table>
            </div>
            <div id="DocSeleccionado" hidden>
                <br>    
                <h5>Documento seleccionado:</h5>
                <label hidden id="idDoc"></label>
                <b style="font-size: 15px">Número de Documento: </b><label id="nroDoc"></label> 
                <b style="font-size: 15px">Asunto: </b><label id="asuDoc"></label> 
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveDocumento()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
