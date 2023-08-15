@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/Notarial/movimientos.css')}}">
    <script src="{{ asset('js/Coordinacion/Notarial/movimientos.js') }}"></script>
</head>
<div hidden id="id">{{$tramite->id_tramite}}</div>
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
                        <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">+ Agregar movimiento</button>
                    </div>
                </div>
                <div class="card">
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