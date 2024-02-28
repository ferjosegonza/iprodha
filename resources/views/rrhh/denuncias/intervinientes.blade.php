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
                        {{-- <div class="section-header d-flex justify-content-between"> --}}
                        <div class="section-header d-flex">
                            <h5>Gestionar Denunciado, Denunciante y Víctima relacionadas a la Denuncia:</h5>
                            <div class="gropo-botones d-flex">
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        DENUNCIANTE
                                    </button>
                                    <div class="dropdown-menu">
                                        @php
                                            $denuncianteVacio = empty($denuncia->denunciante) ? true : false;
                                        @endphp
                                        @if ($denuncianteVacio)
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.crear', $denuncia->id_denuncia],
                                                /*'style' => 'display:inline',
                                                'class' => 'd-flex justify-content-evenly'*/
                                                ]) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {{-- {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!} --}}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciante.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.denunciante.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        DENUNCIADO
                                    </button>
                                    <div class="dropdown-menu">
                                        @php
                                            $denunciadoVacio = empty($denuncia->denunciado) ? true : false;
                                        @endphp
                                        @if ($denunciadoVacio)
                                            {!! Form::open(['method' => 'GET', 'route' => ['rrhh.denuncias.denunciado.crear'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciado.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.denunciado.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.denunciado.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="btn-group m-1">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        VÍCTIMA
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- @php
                                            $denunciadoVacio =  ? true : false;
                                        @endphp --}}
                                        @if (empty($denuncia->victima))
                                            {!! Form::open(['method' => 'GET', 'route' => ['rrhh.denuncias.victima.crear'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Agregar Nuevo', ['class' => 'formulario dropdown-item btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.victima.ver', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Ver', ['class' => 'formulario dropdown-item btn btn-info']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'route' => ['rrhh.denuncias.victima.modificar', $denuncia->id_denuncia],
                                                'style' => 'display:inline']) !!}
                                                {!! Form::submit('Modificar', ['class' => 'formulario dropdown-item btn btn-warning']) !!}
                                            {!! Form::close() !!}
                                
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'class' => 'formulario',
                                                'route' => ['rrhh.denuncias.victima.borrar', $denuncia->id_denuncia],
                                                'style' => 'display:inline'])!!}
                                                {!! Form::submit('Borrar', ['class' => 'formulario dropdown-item btn-borrar-denuncia btn btn-danger borrar-denuncia']) !!}
                                            {!! Form::close() !!}
                                        @endif
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