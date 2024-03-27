@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ver Denuncia</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {!! link_to_route('rrhh.denuncias.listar',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection