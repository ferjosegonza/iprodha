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
            <div class="card-body">
                <button class="btn btn-primary">Enviar boletas del último ciclo</button>
            </div>
         </div>
    </div>
</section>

@include('layouts.modal.confirmation')
@endsection