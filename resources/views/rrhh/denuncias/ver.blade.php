@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
        <style>
            .form-group > div, .min-height-20 {
                min-height: 30px;
            }
            .form-group {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <section class="section">
        <div class="section-header">
            <h2 class="page__heading">Denuncia</h2>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row min-height-20">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group min-height-20" style="margin-bottom: 35px">
                            <h4>Datos de la Denuncia</h4>
                            <div>Fecha: <b>{{$denuncia->fecha ? \Carbon\Carbon::parse($denuncia->fecha)->format('d-m-Y') : 'No hay fecha cargada.' }}</b></div>
                            <div>Extracto: <b>{{$denuncia->extracto ?? 'No hay extracto cargado.'}}</b></div>
                            <div>Descripción: <b>{{$denuncia->descripcion ?? 'No hay descripción cargada.'}}</b></div>
                            {{-- <div class="form-group" style="margin-bottom: 0;padding-bottom: 0px">
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
                            </div> --}}
                        </div>

                        <div class="row">
                            <h4>En relación a la Denuncia. Denunciante, Denunciado y Víctima:</h4>
                            <div class="form-group" style="margin-top: 12px;">
                                <h5>Datos del Denunciante</h5>
                                @if ($denunciante)
                                    <div>Apellido y Nombre: <b>{{ $denunciante->apellido }} {{ $denunciante['nombre'] }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $denunciante->tipoDni->des_abr }} ({{ $denunciante->tipoDni->destipdoc }}) {{ number_format($denunciante['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $denunciante->sexo->descsexo ?? $denunciante->id_sexo }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciante['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $denunciante['domicilio'] }}</b></div>
                                    <div>Mail: <b>{{ $denunciante['mail'] }}</b></div>
                                    <div>Teléfono: <b>{{ $denunciante['telefono'] }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $denunciante->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                    <div>¿El Denunciante es también la Víctima?: <b>{{ $denunciante['es_victima'] ? 'Si':'No' }}</b></div>
                                @else
                                    <div>No hay datos cargados del denunciante</div>
                                @endif
                            </div>
                            {{-- <div class="form-group">
                                {!! Form::label('id_sexo', 'Sexo:', ['class' => 'form-label','style' => 'color:black;']) !!}
                                {!! Form::text('id_sexo', $denunciante->sexo->DESCSEXO, [
                                    'class' => 'form-control',
                                    'style' => 'resize:none;text-transform:uppercase;color: var(--bs-modal-color);',
                                    'id'    =>  'id_sexo',
                                    'readonly' => true
                                ]) !!}
                            </div> --}}

                            <div class="form-group">
                                <h5>Datos del Denunciado</h5>
                                @if ($denunciado)
                                    <div>Apellido y Nombre: <b>{{ $denunciado['apellido'] }} {{ $denunciado['nombre'] }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $denunciado->tipoDni->des_abr }} ({{ $denunciado->tipoDni->destipdoc }}) {{ number_format($denunciado['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $denunciado->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciado['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $denunciado['domicilio'] }}</b></div>
                                    <div>Mail: <b>{{ $denunciado['mail'] }}</b></div>
                                    <div>Teléfono: <b>{{ $denunciado['telefono'] }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $denunciado->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                    <div>Vínculo con la Víctima: <b>{{ $denunciado['vinculo_vict'] }}</b></div>
                                @else
                                    <div>No hay datos cargados del denunciado</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <h5>Datos de la Víctima</h5>
                                @if ($victima)
                                    @if ($denunciante['es_victima'])
                                        <div><b><i>La víctima y el denunciante son la misma persona.</i></b></div>
                                    @endif
                                    <div>Apellido y Nombre: <b>{{ $victima['apellido'] }} {{ $victima['nombre'] }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $victima->tipoDni->des_abr }} ({{ $victima->tipoDni->destipdoc }}) {{ number_format($victima['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $victima->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($victima['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $victima['domicilio'] }}</b></div>
                                    <div>Mail: <b>{{ $victima['mail'] }}</b></div>
                                    <div>Teléfono: <b>{{ $victima['telefono'] }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $victima->vinculo->descripcion ?? 'Información no encontrada' }}</b></div>
                                @else
                                    <div>No hay datos cargados de la víctima</div>
                                @endif
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