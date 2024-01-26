@extends('layouts.app')

@section('content')

    <head>
        <script src="{{ asset('js/rrhh/denuncias.js') }}"></script>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>

        <style>
            .fila-denuncia:hover {
                background-color: #f5f5f5; /* Cambia el color de fondo al pasar el mouse */
            }
            .btn-group{
                display:'inline-block';
                margin: 'm-2';
            }
            .gropo-botones{}
        </style>
    </head>

    <section id="denunciasSection" class="section">
        <div class="section-header d-flex justify-content-between">
            <h3 class="page__heading">Denuncias</h3>
            @can('CARGAR-DENUNCIA')
                {!! Form::open(['method' => 'GET', 'route' => ['rrhh.denuncias.crear'], 'class' => 'd-flex justify-content-evenly']) !!}
                    {!! Form::submit('Nueva Denuncia', ['class' => 'btn btn-success my-1']) !!}
                {!! Form::close() !!}
            @endcan
        </div>

        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div id="accordion">

                            </div>
                            {{--@if (session('mensaje'))
                                <div class="alert alert-success">
                                    {{ session('mensaje') }}
                                </div>
                            @endif--}}
                            <div class="table-responsive">
                                <table id="tabla-lista-denuncias" class="table table-hover mt-2">
                                <!--<table class="table table-striped mt-2" id="example">
                                <table class="table table-striped mt-2 dataTables-example display" id="example">-->
                                    <thead style="height:50px;">
                                        <th class='ml-3' style="color:#fff;">FECHA</th>
                                        <th style="color:#fff;">EXTRACTO</th>
                                        <th style="color:#fff;">DESCRIPCIÓN</th>
                                        <th style="color: #fff;">ACCIONES</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias as $denuncia)
                                            <tr class="fila-denuncia">
                                                <td>
                                                    @if ($denuncia->fecha)
                                                    {{ date("d/m/Y", strtotime($denuncia->fecha)) }}
                                                    @else
                                                        Sin fecha
                                                    @endif
                                                </td>
                                                <td>{{$denuncia->extracto}}</td>
                                                <td>{{$denuncia->descripcion}}</td>
                                                <td>
                                                    <div id="accordion">
                                                        <div class="card">
                                                            <div class="card-header" id="headingDenuncia">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-secondary collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        DENUNCIA
                                                                        <span>
                                                                            <i class="fas fa-chevron-down"></i>
                                                                        </span>
                                                                    </button>
                                                                </h5>
                                                            </div>

                                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingDenuncia" data-parent="#accordion">
                                                                <div class="card-body">
                                                                    {!! Form::open([
                                                                        'method' => 'GET',
                                                                        'route' => ['rrhh.denuncias.ver', $denuncia->id_denuncia],
                                                                        'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                                                    {!! Form::close() !!}
                                                        
                                                                    {!! Form::open([
                                                                        'method' => 'GET',
                                                                        'route' => ['rrhh.denuncias.modificar', $denuncia->id_denuncia],
                                                                        //'onclick' => 'abrirModalModificarDenuncia();',
                                                                        'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                                                    {!! Form::close() !!}
                                                        
                                                                    {!! Form::open([
                                                                        'method' => 'DELETE',
                                                                        'class' => 'formulario',
                                                                        'route' => ['rrhh.denuncias.borrar', $denuncia->id_denuncia],
                                                                        'style' => 'display:inline'])!!}
                                                                        {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                                                    {!! Form::close() !!}
                                                                    <div class="card-header" id="headingDenunciado">
                                                                        <h5 class="mb-0">
                                                                            <button class="btn btn-secondary collapsed" data-toggle="collapse" data-target="#collapseDenunciado
Denunciado" aria-expanded="false" aria-controls="collapseDenunciado
Denunciado">
                                                                                DENUNCIADO
                                                                                <span>
                                                                                    <i class="fas fa-chevron-down"></i>
                                                                                </span>
                                                                            </button>
                                                                        </h5>
                                                                    </div>
        
                                                                    <div id="collapseDenunciado
Denunciado" class="collapse" aria-labelledby="headingDenunciado" data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            {!! Form::open([
                                                                                'method' => 'GET',
                                                                                'route' => ['rrhh.denuncias.ver', $denuncia->id_denuncia],
                                                                                'style' => 'display:inline']) !!}
                                                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                                                            {!! Form::close() !!}
                                                                
                                                                            {!! Form::open([
                                                                                'method' => 'GET',
                                                                                'route' => ['rrhh.denuncias.modificar', $denuncia->id_denuncia],
                                                                                //'onclick' => 'abrirModalModificarDenuncia();',
                                                                                'style' => 'display:inline']) !!}
                                                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                                                            {!! Form::close() !!}
                                                                
                                                                            {!! Form::open([
                                                                                'method' => 'DELETE',
                                                                                'class' => 'formulario',
                                                                                'route' => ['rrhh.denuncias.borrar', $denuncia->id_denuncia],
                                                                                'style' => 'display:inline'])!!}
                                                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                                                            {!! Form::close() !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
