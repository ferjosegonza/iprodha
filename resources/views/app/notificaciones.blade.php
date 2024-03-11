@extends('layouts.app')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/app/notificaciones.css')}}">
    <script src="{{ asset('js/app/notificaciones.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Notificación de App</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body">
         @include('layouts.modal.mensajes')
         <div class="card">
            <div class="card-head">
                <h5>Enviar notificaciones</h5>
            </div>
            <div class="card-body row center">
                <div class="col-lg-10">
                    <label for="tipo">Seleccionar tipo de noticación</label>
                    <select class="form-select" id="tipo" name="tipo" onchange="enable()">
                        <option value="" disabled selected hidden>SELECCIONAR</option>
                        @foreach ($tipos_not as $tipo)
                            <option value="{{$tipo->id_tipo}}|{{$tipo->forma}}">{{$tipo->descripcion}}</option>
                        @endforeach
                    </select></div>
                <div class="col-lg-2" style="margin-top: 1%">
                    <button class="btn btn-primary" disabled id="prev" onclick="previsualizar()">Previsualizar</button>
                </div>
            </div>
         </div>
        <div class="card" hidden id="usuarios">
            <div class="card-body">
                <input type="radio" class="btn-check" id="radioUsuarios" name="radio" value="usuario" autocomplete="off" onclick="abrirUsuarios()"/>
                <label class="btn btn-outline-primary" for="radioUsuarios">Usuarios</label>
                <input type="radio" class="btn-check" id="radioGrupos" name="radio" value="grupo" autocomplete="off" onclick="abrirGrupos()"/>
                <label class="btn btn-outline-primary" for="radioGrupos">Grupos</label>
            </div>
        </div>
        <div id="TablaGrupos"class="card" hidden>
            <div class="card-body">
                <button class="btn btn-outline-secondary" style="margin-bottom: 1%" onclick="crearGrupos()">Crear nuevo grupo</button>
                <table id="table_grupos">
                    <thead>                        
                        <th hidden></th>
                        <th>Nombre</th>
                    </thead>
                    <tbody id="table_body_grupos">
                    </tbody>
                </table>
                <button class="btn btn-block btn-outline-primary" disabled id="btnElegirGrupo" onclick="grupoElegido()">Elegir Grupo</button>
            </div>
        </div>
        <div id="TablaUsuarios" class="card" hidden>
            <div class="card-body">
                <div id="esconderInputGrupo" hidden style="margin-bottom: 1%">
                    <div style="display: flex">
                       <button onclick="mostrarGrupos()" class="btn btn-danger">←</button>
                        <button id="btnGuardarGrupo" style="right: 0;
                        position: absolute;
                        margin-right: 2%;" class="btn btn-success" disabled onclick="prevGuardar()">Guardar Grupo</button> 
                    </div>                    
                    <div style="margin-top: 1%">
                        <label for="nombreGrupo" class="form-label">Nombre del grupo:</label>
                        <input type="text" id="nombreGrupo" class="form-control" onkeyup="checkBtnGuardarGrupo()" size="20">
                    </div>                    
                </div>
                <div style="margin-bottom: 1%">
                    <label>Seleccionar: </label>
                    <button class="btn" style="border-color: rgb(216, 216, 216)" onclick="seleccionarTodosUsuarios(true)">Todos</button>
                    <button class="btn" style="border-color: rgb(216, 216, 216)" onclick="seleccionarTodosUsuarios(false)">Ninguno</button>
                </div>                
                <table id="table_usuarios">
                    <thead>                        
                        <th hidden></th>
                        <th>CUIT</th>
                        <th>Nombre</th>
                        <th>Seleccionar</th>
                    </thead>
                    <tbody id="table_body_usuarios">
                    </tbody>
                </table>
                <button id="btnElegirUsuarios" class="btn btn-outline-primary" disabled onclick="usuariosElegidos()">Elegir</button>
            </div>
        </div>
        <div id="Previsualizar_Grupo" class="card" hidden>
            <div class="card-body">
                <label for="nombreGrupoDone" class="form-label">Nombre del grupo:</label>
                <input type="text" id="nombreGrupoDone" disabled class="form-control">
                <table id="previa_grupo_table">
                    <thead>
                        <th hidden></th>
                        <th>CUIT</th>
                        <th>Nombre</th>
                    </thead>
                    <tbody id="previa_grupo_table_body">
                    </tbody>
                </table>
                <button class="btn btn-block btn-success" style="margin-top: 1%" onclick="confirmarGrupo()">Confirmar</button>
            </div>
           
        </div>
        <div class="card" id="Previsualizar_Mensaje" hidden>
            <div class="card-body row">
                <div class="col-lg-6" id="mensajeCard">
                    <label for="cabecera" class="form-label">Cabecera del mensaje: </label>
                    <input type="text" class="form-control" id="cabecera" onkeyup="checkMsj()">
                    <label for="cuerpo" class="form-label">Cuerpo del mensaje: </label>
                    <input type="text" class="form-control" id="cuerpo" onkeyup="checkMsj()">
                </div>
                <div class="col-lg-6" id="usuariosCard">
                    <table id="table_usuarios_elegidos">
                        <thead>
                            <th hidden></th>
                            <th>CUIT</th>
                            <th>Nombre</th>
                        </thead>
                        <tbody id="table_usuarios_elegidos_body">

                        </tbody>
                    </table>
                </div>
            </div>
            <button class="btn btn-block btn-sm btn-success" style="width: 55%; margin:5px;
            align-self: center;" id="btnEnviarMsj" disabled onclick="enviarMsj()">Enviar Mensaje</button>
        </div>    
        <div class="card" >
            <div class="card-body" id="visualizar" hidden>
            </div>
        </div>    
    </div>
</section>
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