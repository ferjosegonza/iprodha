@extends('layouts.app')

@section('content')

    <head>
        <script src="{{ asset('js/rrhh/denuncias.js') }}"></script>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>

        <style>
            .fila-denuncia:hover {
                background-color: #f5f5f5; /* Cambia el color de fondo al pasar el mouse */
                /*cursor: pointer; Cambia el cursor a manito */
            }
        </style>
    </head>

    <section id="denunciasSection" class="section">
        <div class="section-header d-flex justify-content-between">
            <!--<div>
                <div class="titulo page__heading">Denuncias</div>
            </div> -->
            <h3 class="page__heading">Denuncias</h3>
            @can('CARGAR-DENUNCIA')
                <button id="botonModal" type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalNuevaDenuncia" onclick="limpiarFormDenuncia(); abrirModalDenunciaNueva()">
                    Nueva Denuncia
                </button>
            @endcan
        </div>

        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            {{--@if (session('mensaje'))
                                <div class="alert alert-success">
                                    {{ session('mensaje') }}
                                </div>
                            @endif--}}
                            {{-- @if ($denuncias != 'error')
                                <div class="pagination justify-content-end">
                                    {!! $denuncias->links() !!}
                                </div>
                            @endif --}}
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
                                                <td>{{date("d/m/Y",strtotime($denuncia->fecha))}}</td>
                                                <td>{{$denuncia->extracto}}</td>
                                                <td>{{$denuncia->descripcion}}</td>
                                                <td>
                                                    {{-- <div class="d-flex align-items-center"> --}}
                                                        {{--@can('EDITAR-ALUMNOS')--}}
                                                        {{--<button id="ver_denuncia" class="btn btn-primary btn-ver-denuncia" data-bs-toggle="modal"
                                                            data-bs-target="#modalDenuncia"
                                                            data-id = "{{$denuncia->id_denuncia}}"
                                                            data-fecha="{{$denuncia->fecha}}"
                                                            data-extracto="{{$denuncia->extracto}}"
                                                            data-descripcion="{{$denuncia->descripcion}}">
                                                            DENUNCIA
                                                        </button>--}}
                                                        {{--{!! Form::open(['method' => 'GET','route' => ['alumnos.edit', $alumno->dni],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                                        {!! Form::close() !!}
                                                        @endcan
                                                        --}}
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                DENUNCIA
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {!! Form::button('Ver', [
                                                                    'class' => 'formulario dropdown-item btn-ver-denuncia btn btn-info ver-denuncia',
                                                                    'onclick' => 'verDenuncia(' . $denuncia->id_denuncia . ',
                                                                                                "' . $denuncia->fecha . '",
                                                                                                "' . $denuncia->extracto . '",
                                                                                                "' . $denuncia->descripcion . '")',
                                                                ]) !!}

                                                                {{-- {!! Form::button('Modificar', [
                                                                    'id' => 'botonModificar',
                                                                    'class' => 'formulario dropdown-item btn btn-warning',
                                                                    'onclick' => 'abrirModalModificarDenuncia(); modificarDenuncia(' . $denuncia->id_denuncia . ',
                                                                                                "' . $denuncia->fecha . '",
                                                                                                "' . $denuncia->extracto . '",
                                                                                                "' . $denuncia->descripcion . '")',
                                                                ]) !!} --}}

                                                                {!! Form::open([
                                                                    'method' => 'GET',
                                                                    'route' => ['denuncia.modificar', $denuncia->id_denuncia],
                                                                    'onclick' => 'abrirModalModificarDenuncia();',
                                                                    'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                                                {!! Form::close() !!}

                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['denuncia.borrar', $denuncia->id_denuncia],
                                                                    'style' => 'display:inline'])!!}
                                                                    {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        {{-- </div> --}}
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                DENUNCIANTE
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {!! Form::button('Ver', [
                                                                    'class' => 'formulario dropdown-item btn-ver-denuncia btn btn-info ver-denuncia',
                                                                    'onclick' => 'verDenuncia(' . $denuncia->id_denuncia . ',
                                                                                                "' . $denuncia->fecha . '",
                                                                                                "' . $denuncia->extracto . '",
                                                                                                "' . $denuncia->descripcion . '")',
                                                                ]) !!}
                                                                {!! Form::button('Agregar', [
                                                                    'class' => 'formulario dropdown-item btn-ver-denuncia btn btn-success ver-denuncia',
                                                                    'onclick' => 'verDenuncia(' . $denuncia->id_denuncia . ',
                                                                                                "' . $denuncia->fecha . '",
                                                                                                "' . $denuncia->extracto . '",
                                                                                                "' . $denuncia->descripcion . '")',
                                                                ]) !!}


                                                                <button class="formulario dropdown-item btn-ver-denuncia btn btn-warning ver-denuncia"
                                                                onclick="modificarDenuncia({{$denuncia->id_denuncia}},'{{$denuncia->fecha}}',
                                                                '{{$denuncia->extracto}}',
                                                                '{{$denuncia->descripcion}}')" >Modificar</button>

                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'class' => 'formulario',
                                                                    'route' => ['denuncia.borrar', $denuncia->id_denuncia],
                                                                    'style' => 'display:inline'])!!}
                                                                    {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                                                {!! Form::close() !!}
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

    <!--  MODAL PARA CARGAR DENUNCIA NUEVA -->
    <div class="modal fade" id="modalNuevaDenuncia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="modal-nueva-denuncia">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CARGAR NUEVA DENUNCIA</h5>
                    <div id="modifDatos" style="display: none"></div>
                    <button id="botonCerrar" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modifDenuncia"></div>
                    {!! Form::open([
                        'route' => 'denuncia.guardar',
                        'method' => 'POST',
                        'id' => 'form_nva_denuncia',
                        //'onsubmit' => 'return beforeSubmit();',
                    ]) !!}
                        @csrf
                    <div class="mb-3">
                        {!! Form::label('fecha', 'FECHA:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                        {!! Form::date('fecha',\Carbon\Carbon::now(),['class'=>'form-control date-field mb-3', 'style' => 'width: auto;', 'max' => now()->format('Y-m-d')]) !!}
                        {!! Form::label('denuncia_extracto', 'EXTRACTO:', ['class' => 'form-label','style' => 'color:black;']) !!}
                        {!! Form::text('denuncia_extracto', null, [
                            'class' => 'form-control',
                            'style' => 'resize:none;text-transform:uppercase;color: var(--bs-modal-color);',
                            'id'    =>  'denuncia_extracto',
                            'maxlenght'=>'100',
                            'placeholder' => 'Detalle \'DENUNCIANTE\' CONTRA \'DENUNCIADO\'',
                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("extracto_caracteres", "denuncia_extracto", 100)',
                            ]) !!}
                        <label for="denuncia_extracto" id="extracto_caracteres">Quedan 100 caracteres.</label>
                        <br>

                        {!! Form::label('denuncia_descripcion', 'DESCRIPCIÓN:', ['class' => 'form-label','style' => 'color:black;']) !!}
                        {!! Form::textarea('denuncia_descripcion', null, [
                            'class' => 'form-control',
                            'rows' => 34,
                            'cols' => 54,
                            'style' => 'resize:none;height:20vh;text-transform:uppercase;color: var(--bs-modal-color);',
                            'id'    =>  'denuncia_descripcion',
                            'maxlenght'=>'1500',
                            'placeholder' => 'Describa lugar y lo que considere relevante de lo acontecido. Detalle los elementos o medios probatorios que se puedan agregar para el esclarecimiento.',
                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("descripcion_caracteres", "denuncia_descripcion", 1500)',
                            ]) !!}
                        <label for="denuncia_descripcion" id="descripcion_caracteres" style="mb-2">Quedan 1500 caracteres.</label>
                    </div>
                    <button id="guardar_denuncia" type="submit" class="btn btn-primary">GUARDAR</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!--  FIN MODAL PARA CARGAR DENUNCIA NUEVA -->

    <!-- MODAL PARA MODIFICAR DENUNCIA EXISTENTE -->
    <div class="modal fade" id="modalModificarDenuncia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">axaxa
            <div class="modal-content" id="modal-modif-denuncia">
                <h5 class="modal-title" id="exampleModalLabel">MODIFICAR DENUNCIA</h5>
                <div id="modifDatos" style="display: none"></div>
                <button id="botonCerrar" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modifDenuncia"></div>
                {{-- {!! Form::open($denuncia, [
                    'route' => ['denuncia.update', $denuncia->id_denuncia],
                    'method' => 'PATCH',
                    'id' => 'form_modif_denuncia',
                    'class' => 'formulario',
                    //'onsubmit' => 'return beforeSubmit();',
                ]) !!} --}}
                {{-- {!! Form::model($denuncia, ['method' => 'PATCH', 'id' => 'form_modif_denuncia', 'class' => 'formulario','route' => ['denuncia.update', $denuncia->id_denuncia]]) !!} --}}
                    @csrf
                    @method('PUT')
                    {!! Form::token() !!}
                    <div class="mb-3">
                        @include('layouts.modal.mensajes')
                        {!! Form::label('fecha', 'FECHA:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                        {!! Form::date('fecha',old('fecha'),['class'=>'form-control date-field mb-3', 'style' => 'width: auto;', 'max' => now()->format('Y-m-d')]) !!}
                        {!! Form::label('denuncia_extracto', 'EXTRACTO:', ['class' => 'form-label','style' => 'color:black;']) !!}
                        {!! Form::text('denuncia_extracto', old('denuncia_extracto'), [
                            'class' => 'form-control',
                            'style' => 'resize:none;text-transform:uppercase;color: var(--bs-modal-color);',
                            'id'    =>  'denuncia_extracto',
                            'maxlenght'=>'100',
                            'placeholder' => 'Detalle \'DENUNCIANTE\' CONTRA \'DENUNCIADO\'',
                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("extracto_caracteres", "denuncia_extracto", 100)',
                            ]) !!}
                        <label for="denuncia_extracto" id="extracto_caracteres">Quedan 100 caracteres.</label>
                        <br>

                        {!! Form::label('denuncia_descripcion', 'DESCRIPCIÓN:', ['class' => 'form-label','style' => 'color:black;']) !!}
                        {!! Form::textarea('denuncia_descripcion', old('denuncia_descripcion'), [
                            'class' => 'form-control',
                            'rows' => 34,
                            'cols' => 54,
                            'style' => 'resize:none;height:20vh;text-transform:uppercase;color: var(--bs-modal-color);',
                            'id'    =>  'denuncia_descripcion',
                            'maxlenght'=>'1500',
                            'placeholder' => 'Describa lugar y lo que considere relevante de lo acontecido. Detalle los elementos o medios probatorios que se puedan agregar para el esclarecimiento.',
                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("descripcion_caracteres", "denuncia_descripcion", 1500)',
                            ]) !!}
                        <label for="denuncia_descripcion" id="descripcion_caracteres" style="mb-2">Quedan 1500 caracteres.</label>
                    </div>
                    {!! Form::submit('EDITAR', ['onclick' => '', 'class' => 'btn btn-success mr-2']) !!}
                    {{-- <button id="guardar_denuncia" type="submit" class="btn btn-primary">GUARDAR</button> --}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--  FIN MODAL PARA MODIFICAR DENUNCIA EXISTENTE -->

@endsection