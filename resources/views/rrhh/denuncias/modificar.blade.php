@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Modificar Denuncia</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div><h4>Datos actuales:</h4></div>
                        {!! Form::model($denuncia,['method'=>'PATCH',
                                                'class' => 'formulario',
                                                'route'=>['rrhh.denuncias.update', $denuncia->id_denuncia]
                                                ])!!}
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                                {{-- {!! $fechaParaMostrar = $denuncia->fecha ? substr($denuncia->fecha, 0, 10) : '' !!} --}}
                                {!! Form::date('fecha',$denuncia->fecha ? substr($denuncia->fecha, 0, 10) : '',['class'=>'form-control date-field mb-3', 'style' => 'width: auto;', 'max' => now()->format('Y-m-d')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('denuncia_extracto', 'Extracto:', ['class' => 'form-label','style' => 'color:black;']) !!}
                                {!! Form::text('denuncia_extracto', $denuncia->extracto, [
                                    'class' => 'form-control',
                                    'style' => 'resize:none;text-transform:uppercase;color: var(--bs-modal-color);',
                                    'id'    =>  'denuncia_extracto',
                                    'maxlenght'=>'100',
                                    'placeholder' => 'Detalle \'DENUNCIANTE\' CONTRA \'DENUNCIADO\'',
                                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("extracto_caracteres", "denuncia_extracto", 100)',
                                    ]) !!}
                                <label for="denuncia_extracto" id="extracto_caracteres">Quedan 100 caracteres.</label>
                            </div>
                            <div class="form-group">
                                {!! Form::label('denuncia_descripcion', 'Descripción:', ['class' => 'form-label','style' => 'color:black;']) !!}
                                {!! Form::textarea('denuncia_descripcion', $denuncia->descripcion, [
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
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            @can('CREAR-DENUNCIA')
                            {!! Form::submit('Editar', ['onclick' => '', 'class' => 'btn btn-success mr-2']) !!}
                            @endcan
                            {!! link_to_route('rrhh.denuncias.listar',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}
                        </div>
                        {{-- <button type="submit" class="btn btn-primary mr-2">Editar</button>
                        <a href="{{ route('rrhh.denuncias.listar') }}"class="btn btn-secondary fo">Volver</a> --}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection