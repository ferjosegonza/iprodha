@extends('layouts.app')

@section('content')  
<head>
    <link rel="stylesheet" href="{{asset('css/digesto/modificaciones.css')}}">
    <script src="{{ asset('js/Coordinacion/Digesto/modificaciones.js') }}"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
</head>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading">Modificaciones</div>
        @include('layouts.favorito.fav', ['modo' => 'Agregar'])
    </div>
    <div class="section-body">    
        @include('layouts.modal.mensajes')    
        <div class="row">
            {{-- <nav id="nav-btn">
                <button class="btn" id="search-btn" onclick="openBusqueda()"><i class="fas fa-search"></i>   Buscar</button>
                <input type="text" name="busqueda" id="busqueda" class="form-control" hidden>
            </nav> --}}
            <div class="col-lg-12 card" id='lista-relacionados'>
                <div class="card-head">
                    <h5>Archivos </h5>
                </div>
                <div class="card-body">
                    <i onclick="exportPDF()" class="fa fa-file-pdf fa-2x" style="color: #ff0000;"></i>
                    <table id="tabla-relacionados">
                        <thead>
                            <th>Nro de Archivo</th>
                            <th>Modifica</th>
                            <th>Observación</th>
                        </thead>             
                        <tbody>
                            @if($base != null)
                                <tr class="hoveriano" onclick="openPDF({{$base}})">
                                    <td>{{$base->nro_archivo}}</td>
                                    <td> - </td>
                                    <td> Archivo original </td>
                                </tr>
                                @if($archivos != null)
                                    @foreach ($archivos as $archivo)
                                        <tr onclick="openPDF({{$archivo}})" class="hoveriano">
                                            <td>{{$archivo->nro_archivo}}</td>
                                            <td>{{$base->nro_archivo}}</td>
                                            <td>{{$archivo->observacion}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-8 card" id="pdf-preview" hidden>
                <div class="card-head">
                    <div id='cancelar' class="btn btn-danger btn-sm" onclick="cancelar()">X</div>
                    <h5 id="titulo">Ver pdf</h5>
                </div>
                <div class="card-body">
                    <div id='info'></div>
                    <embed src="#" type="" id='pdf'>
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.modal.confirmation') 
@endsection