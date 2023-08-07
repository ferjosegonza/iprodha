@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/Notarial/bandeja.css')}}">
    <script src="{{ asset('js/Coordinacion/Notarial/bandeja.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Bandeja de Trámites</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                @include('layouts.modal.mensajes')
                <div class="card col-sm-12">
                    <div class="card-body"> 
                        <button class="btn btn-outline-success">Crear un nuevo trámite</button>
                        <hr>
                        <h6>Trámites Pendientes</h6>
                        <table id="pendientes">
                            <thead>
                                <th>Tipo de Trámite</th>
                                <th>Fecha</th>
                                <th>Nombre del Comitente</th>
                                <th>Dni del Comitente</th>
                                <th></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
