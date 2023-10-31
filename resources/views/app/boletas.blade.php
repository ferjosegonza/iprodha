@extends('layouts.app')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/app/boleta.css')}}">
    <script src="{{ asset('js/app/boleta.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Notificación de Boletas</div>
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
                            <option value="{{$tipo->id_tipo}}">{{$tipo->descripcion}}</option>
                        @endforeach
                    </select></div>
                <div class="col-lg-2">
                    <button class="btn btn-primary" disabled id="prev" onclick="previsualizar()">Previsualizar</button>
                </div>
            </div>
         </div>
         <div class="card" >
            <div class="card-body" id="pendientes" hidden>
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