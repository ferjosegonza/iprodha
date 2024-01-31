@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header d-flex justify-content-between">
            <h4 class="page__heading">Denuncia</h4>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div><h5 class="page__heading">Datos de la Denuncia:</h5></div>
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                                {!! Form::date('fecha',$denuncia->fecha ? substr($denuncia->fecha, 0, 10) : '',[
                                    'class'=>'form-control date-field mb-3',
                                    'style' => 'width: auto;',
                                    'max' => now()->format('Y-m-d'),
                                    'readonly' => true]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('denuncia_extracto', 'Extracto:', ['class' => 'form-label','style' => 'color:black;']) !!}
                                {!! Form::text('denuncia_extracto', $denuncia->extracto, [
                                    'class' => 'form-control',
                                    'style' => 'resize:none;text-transform:uppercase;color: var(--bs-modal-color);',
                                    'id'    =>  'denuncia_extracto',
                                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                    'readonly' => true
                                    ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('denuncia_descripcion', 'Descripción:', ['class' => 'form-label','style' => 'color:black;']) !!}
                                {!! Form::textarea('denuncia_descripcion', $denuncia->descripcion, [
                                    'class' => 'form-control',
                                    'rows' => 34,
                                    'cols' => 54,
                                    'style' => 'resize:none;height:20vh;text-transform:uppercase;color: var(--bs-modal-color);',
                                    'id'    =>  'denuncia_descripcion',
                                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                    'readonly' => true
                                    ]) !!}
                            </div>
                        </div>
                        <div class="section-header d-flex justify-content-between">
                            <h5>Gestionar Denunciado, Denunciante y Víctima relacionadas a la Denuncia:</h5>
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
                            
                                        {{-- <div class="btn-group m-1">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="botonDenunciante();">
                                                DENUNCIANTE
                                            </button>
                                            <div class="dropdown-menu" style="display: none" id="submenu-denunciante">
                                                @php
                                                    $denunciante = empty($denuncia->denunciante) ? false : true;
                                                @endphp
                                                {!! Form::open([
                                                    'method' => 'GET',
                                                    'route' => ['rrhh.denuncias.denunciante.ver', $denuncia->id_denuncia],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                    {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info',
                                                    'disabled' => empty($denuncia->denunciante) ? true : false ]) !!}
                                                {!! Form::close() !!}
                            
                                                {!! Form::open([
                                                    'method' => 'GET',
                                                    'route' => ['rrhh.denuncias.denunciante.crear', $denuncia->id_denuncia],
                                                    'class' => 'd-flex justify-content-evenly'
                                                ]) !!}
                                                    {!! Form::submit('Agregar', ['class' => 'formulario dropdown-item btn btn-success',
                                                    'disabled' => empty($denuncia->denunciante) ? false : true]) !!}
                                                {!! Form::close() !!}
                            
                                                {!! Form::open([
                                                    'method' => 'GET',
                                                    'route' => ['rrhh.denuncias.denunciante.modificar', $denuncia->id_denuncia],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                    {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning',
                                                    'disabled' => empty($denuncia->denunciante) ? true : false]) !!}
                                                {!! Form::close() !!}
                            
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'class' => 'formulario',
                                                    'route' => ['rrhh.denuncias.denunciante.borrar', $denuncia->id_denuncia],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn btn-danger',
                                                    'disabled' => empty($denuncia->denunciante) ? true : false]) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                            
                                        <div class="btn-group m-1">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                VÍCTIMA
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Agrega los botones para Víctima aquí -->
                                            </div>
                                        </div>
                            
                                        <div class="btn-group m-1">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                DENUNCIADO
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Agrega los botones para Denunciado aquí -->
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {!! link_to_route('rrhh.denuncias.listar',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection