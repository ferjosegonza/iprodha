@extends('layouts.app')

@section('content')  
<head>
    <link rel="stylesheet" href="{{asset('css/digesto/historial.css')}}">
    <script src="{{ asset('js/Coordinacion/Digesto/historial.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Historial de digestos cargados</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body card">           
        @include('layouts.modal.mensajes')        
        <div class="card-body">
        <table id="digestos">
            <thead>
                <th>Archivo Original</th>
                <th>Archivo Modificador</th>
                <th>Observación</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($historial as $h)
                    <tr>
                        <td>{{$h->nro0}}</td>
                        <td>{{$h->nron}}</td>
                        <td>{{$h->observacion}}</td>
                        <td><a href="/digesto/modificaciones?id={{$h->id_archivo0}}">Ir a cadena</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</section>
@include('layouts.modal.confirmation') 
@endsection