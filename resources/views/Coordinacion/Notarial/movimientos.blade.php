@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/Notarial/movimientos.css')}}">
    <script src="{{ asset('js/Coordinacion/Notarial/movimientos.js') }}"></script>
</head>
<div hidden id="id">{{$tramite->id_tramite}}</div>
<div hidden id='escribano'>{{$asuntos['escribano']}}</div>
<div hidden id='funcionario'>{{$asuntos['funcionario']}}</div>
<div hidden id='documento'>{{$asuntos['documento']}}</div>
<div hidden id='profesional'>{{$asuntos['profesional']}}</div>
<div hidden id='beneficiario'>{{$asuntos['beneficiario']}}</div>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Movimientos del Trámite</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                @include('layouts.modal.mensajes')
                <div class="card col-sm-12">
                    <div class="card-body">
                        <p>Comitente: {{$tramite->nombre_comitente}}, DNI: {{$tramite->dni_comitente}}. {{$tramite->descripcion}}.</p>
                        <div hidden id="prevDocumento"></div>
                        <div hidden id="prevProfesional"></div>
                        <div hidden id="prevFuncionario"></div>
                        <div hidden id="prevBeneficiario"></div>
                        <div hidden id="prevEscribano"></div>
                        <hr>
                        <button class="btn btn-success" onclick="abrirTramite('{{$tramite->id_tramite}}')">Editar información del trámite  </button>
                        <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Agregar movimiento</button>
                    </div>
                </div>
                <div class="card col-lg-12" id="preview" hidden>
                    <div class="card-body">
                        <h5>Información del trámite</h5>
                        <hr>
                        <h4>Datos del comitente</h4>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nroDoc" class="control-label">Número de Documento</label> 
                                <input type="number" id="nroDoc" class="form-control" min="0" value="{{$tramite->dni_comitente}}">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="nombreCom" class="control-label">Nombre Completo</label> 
                                <input type="text" id="nombreCom" class="form-control" value="{{$tramite->nombre_comitente}}">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="email" class="control-label">Email</label> 
                                <input type="email" id="email" class="form-control" value="{{$tramite->mail_contacto}}">   
                            </div>   
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 flex" >
                                <label for="celular" class="control-label">Celular</label> 
                                <input type="tel" id="celular" class="form-control" value="{{$tramite->celular_contacto}}">   
                            </div>   
                        </div>
                        <hr>
                        <h4>Datos del trámite</h4>                        
                        {!! Form::label('Tipo de trámite:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <select class="form-select" id="tipo" name="tipo" >
                            @foreach ($tipos as $tipo)                            
                                @if($tipo->id_tipo == $tramite->id_tipo)
                                <option value="{{$tipo->id_tipo}}" selected>{{$tipo->descripcion}}</option>
                                @else
                                <option value="{{$tipo->id_tipo}}">{{$tipo->descripcion}}</option>
                                @endif
                            @endforeach                        
                        </select>
                        <hr>                       
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="documento()">Documento</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="profesional()">Profesional</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="funcionario()">Funcionario</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="beneficiario()">Beneficiario</button>
                        <button class="btn btn-outline-dark" style="width: 19%" onclick="escribano()">Escribano</button>
                        <div class="row">
                            <div id="tabledoc" hidden">
                                <hr>
                                <h5>Documento</h5>
                                <table class="tablita" id="tdoc">
                                    <thead>
                                        <th hidden>iddoc</th>
                                        <th>Número de Documento</th>
                                        <th>Asunto</th>
                                    </thead>
                                    <tbody id="docbody"></tbody>
                                </table>
                                <button class="btn btn-outline-danger btn-sm btncerrar" onclick="deleteado('tabledoc')">X</button>
                            </div>
                            <div id="tableprof" hidden">
                                <hr>
                                <h5>Profesional</h5>
                                <table class="tablita" id="tprof">
                                    <thead>
                                        <th hidden>idtipo</th>
                                        <th>Tipo</th>
                                        <th hidden>idcaracter</th>
                                        <th>Caracter</th>
                                    </thead>
                                    <tbody id="profbody"></tbody>
                                </table>
                                <button class="btn btn-outline-danger btn-sm btncerrar" onclick="deleteado('tableprof')">X</button>
                            </div>
                            <div id="tablefunc" hidden">
                                <hr>
                                <h5>Funcionario</h5>
                                <table class="tablita" id="tfunc">
                                    <thead>
                                        <th hidden>idtipo</th>
                                        <th>Tipo</th>
                                        <th>Observación</th>
                                    </thead>
                                    <tbody id="funcbody"></tbody>
                                </table>
                                <button class="btn btn-outline-danger btn-sm btncerrar" onclick="deleteado('tablefunc')">X</button>
                            </div>
                            <div id="tablebenef" hidden">
                                <hr>
                                <h5>Beneficiario</h5>
                                <table class="tablita" id="tbenef">
                                    <thead>
                                        <th>DNI</th>
                                        <th>OPE</th>
                                        <th>BARRIO</th>
                                        <th>ADJU</th>
                                        <th>APYNA</th>
                                    </thead>
                                    <tbody id="benefbody"></tbody>
                                </table>
                                <button class="btn btn-outline-danger btn-sm btncerrar" onclick="deleteado('tablebenef')">X</button>
                            </div>
                            <div id="tableesc" hidden">
                                <hr>
                                <h5>Escribano</h5>
                                <table class="tablita" id="tesc">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Matrícula</th>
                                    </thead>
                                    <tbody id="escbody"></tbody>
                                </table>                            
                                <button class="btn btn-outline-danger btn-sm btncerrar" onclick="deleteado('tableesc')">X</button>
                            </div>
                        </div>                         
                        <hr>
                        <div class="grid">
                            <button class="btn btn-primary btnGuardar" id="btnguardar" onclick="modificar()">Modificar</button>
                            <button class="btn btn-secondary btnGuardar" onclick="cancelar()">Cancelar</a>
                        </div>                                
                    </div>
                </div>
                <div class="card col-lg-12">
                    <div class="card-body">
                        <h5>Movimientos del trámite</h5>
                        <table id="tableMovimientos">
                            <thead>
                                <th>Fecha</th>
                                <th>Observación</th>
                                <th>Medio</th>
                            </thead>
                            <tbody id="bodyMovimientos">
                                @foreach ($movimientos as $m)
                                    <tr>
                                        <td>{{$m->fecha}}</td>
                                        <td>{{$m->observacion}}</td>
                                        <td>{{$m->descripcion}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="/notarial/bandeja" class="btn btn-secondary">Volver a la bandeja</a>
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
            {!! Form::text('nomes', null, ['id' => 'nomes', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100', 'onkeyup' => 'checkbuscaresc()']) !!}
            <br>
            <button class="btn btn-primary" onclick="buscarEscribano()" id="btnbuscesc" disabled>Buscar</button>
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
          <button type="button" class="btn btn-primary" onclick="saveEscribano()" disabled id="btnsaveesc">Guardar</button>
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
            <select class="form-select" id="profS" name="profesional" onchange="checkProf()">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($profesional as $p)                            
                    <option value="{{$p->id_profesional}}">{{$p->descripcion}}</option>
                @endforeach                        
            </select>
            <br>
            {!! Form::label('Caracter del profesional:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="caracter" name="caracter" onchange="checkProf()">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($caracter as $c)                            
                    <option value="{{$c->id_caracter}}">{{$c->descripcion}}</option>
                @endforeach                        
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveProfesional()" disabled id="btnprof">Guardar</button>
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
            <select class="form-select" id="funcS" name="funcionario" onchange="checkFunc()">
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
          <button type="button" class="btn btn-primary" onclick="saveFuncionario()" disabled id="btnfunc">Guardar</button>
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
            {!! Form::text('dnibenef', null, ['id' => 'dnibenef', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100', 'onkeyup'=>'checkBuscarBenef()']) !!}
            <br>
            <button class="btn btn-primary" onclick="buscarBeneficiario()" id="btnbuscarbenef" disabled>Buscar</button>
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
          <button type="button" class="btn btn-primary" onclick="saveBeneficiario()" disabled id="btnbenefsave">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" id="modalDoc">
    <div class="modal-dialog modal-lg" role="document">
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
            {!! Form::text('nrodocB', null, ['id' => 'nrodocB', 'class' => 'form-control', 'style' => 'text-transform:uppercase', 'maxlenght'=>'100', 'onkeyup' => 'checkDocBuscar()']) !!}
            {!! Form::label('Tipo de Documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="tipodoc" name="tipodoc" onchange="checkDocBuscar()">
                <option value="sel" selected>Seleccionar</option>
                <option value="nota">Nota</option>
                <option value="exp">Expendiente</option>
            </select>
            <br>
            <button class="btn btn-primary" onclick="buscarDocumento()" disabled id="btndocbuscar">Buscar</button>
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
                <b style="font-size: 15px">Número de Documento: </b><label id="nroDocu"></label> 
                <b style="font-size: 15px">Asunto: </b><label id="asuDoc"></label> 
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveDocumento()" id="btndocguardar" disabled>Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Movimiento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <label for="obs">Observación:</label>
            <input type="text" id="obs" class="form-control" onkeyup="checkGuardar()">
            <label for="medio">Medio:</label>
            <select name="medio" id="medio" class="form-control" onchange="checkGuardar()">
                <option value="sel">Seleccionar</option>
                @foreach ($medio as $m)
                    <option value="{{$m->id_medio}}">{{$m->descripcion}}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" disabled id="btnSave" onclick="guardarMovimiento()">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection