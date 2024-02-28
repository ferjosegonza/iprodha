@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h2 class="page__heading">Denuncia</h2>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4>Datos de la Denuncia</h4>
                            <div class="form-group">
                                {!! Form::label('fecha', 'Fecha:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                                {!! Form::date('fecha',$denuncia->fecha ? substr($denuncia->fecha, 0, 10) : '',[
                                    'class'=>'form-control date-field mb-3',
                                    'style' => 'width: auto;',
                                    'max' => now()->format('Y-m-d'),
                                    'readonly' => true]) !!}
                            </div>
                            <div class="form-group">
                                <div>{!! Form::label('denuncia_extracto', 'Extracto:', ['class' => 'form-label','style' => 'color:black;']) !!}</div>
                                <div>{{$denuncia->extracto}}</div>
                            </div>
                            <div class="form-group">
                                <div>{!! Form::label('denuncia_descripcion', 'Descripción:', ['class' => 'form-label','style' => 'color:black;']) !!}</div>
                                <div>{{$denuncia->descripcion}}</div>
                            </div>
                        </div>
                        {{-- $denuncia = Denuncias::find($id);
                        $denunciante = Denunciante::find($id);
                        $denunciado = Denunciado::find($id);
                        $victima --}}
                        <div class="row">
                            <h4>Datos del Denunciante</h4>
                            {{--
                                CAMPOS A MOSTRAR:
                                'NRO_DOC',
                                'APELLIDO',
                                'NOMBRE',
                                'TIPO_DOC',
                                'ID_SEXO',
                                'FECHA_NAC',
                                'DOMICILIO',
                                'MAIL',
                                'TELEFONO',
                                'VINCULO_INST',
                                'ES_VICTIMA'
                            --}}
                            <div class="form-group">
                                {{ $denunciante }}
                                {{-- {!! Form::label('nro-doc', 'Fecha:', ['class' => 'form-label m-1','style' => 'color:black;']) !!}
                                {!! Form::date('fecha',$denuncia->fecha ? substr($denuncia->fecha, 0, 10) : '',[
                                    'class'=>'form-control date-field mb-3',
                                    'style' => 'width: auto;',
                                    'max' => now()->format('Y-m-d'),
                                    'readonly' => true]) !!} --}}
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