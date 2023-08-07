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
                        <h4>Datos del trámite</h4>                        
                        {!! Form::label('Tipo de trámite:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
                        <select class="form-select" id="tipo" onchange="tipos()" name="tipo">
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
                        <table id="tableprof" hidden>
                            <thead>
                                <th hidden>idtipo</th>
                                <th>Tipo</th>
                                <th hidden>idcaracter</th>
                                <th>Caracter</th>
                            </thead>
                            <tbody id="profbody"></tbody>
                        </table>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal" tabindex="-1" role="dialog" id="modalEsc">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo">Agregar un escribano</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalBody">
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" id="modalBoton"></button>
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
            {!! Form::label('Caracter del profesional:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;' ]) !!}
            <select class="form-select" id="caracter" name="caracter">
                <option value="sel" selected>Seleccionar</option>
                @foreach ($caracter as $c)                            
                    <option value="{{$c->id_caracter}}">{{$c->descripcion}}</option>
                @endforeach                        
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="modalBoton" onclick="saveProfesional()">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
