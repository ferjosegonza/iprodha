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
            /* .gropo-botones{} */
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
                                                    <div class="gropo-botones d-flex">
                                                        <div class="btn-group m-1">
                                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                DENUNCIA
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {!! Form::open([
                                                                    'method' => 'GET',
                                                                    'route' => ['rrhh.denuncias.ver', $denuncia->id_denuncia],
                                                                    'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Ver Denuncia', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                                                {!! Form::close() !!}

                                                                {!! Form::open([
                                                                    'method' => 'GET',
                                                                    'route' => ['rrhh.denuncias.modificar', $denuncia->id_denuncia],
                                                                    //'onclick' => 'abrirModalModificarDenuncia();',
                                                                    'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Modificar Denuncia', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                                                {!! Form::close() !!}

                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['rrhh.denuncias.borrar', $denuncia->id_denuncia],
                                                                    'style' => 'display:inline'])!!}
                                                                    {!! Form::submit('Borrar Denuncia', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                                                {!! Form::close() !!}

                                                                {!! Form::open([
                                                                    'method' => 'GET',
                                                                    'route' => ['rrhh.denuncias.intervinientes', $denuncia->id_denuncia],
                                                                    'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Denunciado / Víctima / Denunciante', ['class' => 'formulario dropdown-item btn btn-primary']) !!}
                                                                {!! Form::close() !!}
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
