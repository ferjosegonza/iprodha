@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
        <script src="{{ asset('js/Coordinacion/rrhh/denuncias.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
        <script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
        <style>
            .form-group > div, .min-height-20 {
                min-height: 25px;
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
                    <div class="col-xs-12 col-sm-12 col-md-12" style="margin: 30px 0 0 10px">
                        {!! link_to_route('rrhh.denuncias.listar',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}
                        <br><br>
                        Exportar a PDF: <i onclick="exportPDF()" class="fa fa-file-pdf fa-2x" style="color: #ff0000;"></i>
                    </div>

                    <div class="card-body" id="content">
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
                                    @if ($denunciante['es_victima'])
                                        <div><b><i>La víctima y el denunciante son la misma persona.</i></b></div>
                                    @endif
                                    <div>Apellido y Nombre: <b>{{ $denunciante->apellido ?? 'No hay apellido cargado' }} {{ $denunciante['nombre'] ?? 'No hay nombre cargado' }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $denunciante->tipoDni->des_abr }} ({{ $denunciante->tipoDni->destipdoc }}) {{ number_format($denunciante['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $denunciante->sexo->descsexo ?? $denunciante->id_sexo }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciante['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $denunciante['domicilio'] ?? 'Sin datos' }}</b></div>
                                        <div>Mail: <b>{{ $denunciante['mail'] ?? 'Sin datos' }}</b></div>
                                        <div>Teléfono: <b>{{ $denunciante['telefono'] ?? 'Sin datos' }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $denunciante->vinculo->descripcion ?? 'Sin datos' }}</b></div>
                                    <div>¿El Denunciante es también la Víctima?: <b>{{ $denunciante['es_victima'] ? 'Si':'No' }}</b>
                                        @if ($denunciante['es_victima'])
                                            <i>Los cambios que se realicen en el denunciante impactarán también en los datos de la víctima.</i>
                                        @endif
                                    </div>
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
                                    <div>Apellido y Nombre: <b>{{ $denunciado->apellido ?? 'No hay apellido cargado' }} {{ $denunciado['nombre'] ?? 'No hay nombre cargado' }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $denunciado->tipoDni->des_abr }} ({{ $denunciado->tipoDni->destipdoc }}) {{ number_format($denunciado['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $denunciado->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($denunciado['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $denunciado['domicilio'] ?? 'Sin datos' }}</b></div>
                                    <div>Mail: <b>{{ $denunciado['mail'] ?? 'Sin datos' }}</b></div>
                                    <div>Teléfono: <b>{{ $denunciado['telefono'] ?? 'Sin datos' }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $denunciado->vinculo->descripcion ?? 'Sin datos' }}</b></div>
                                    <div>Vínculo con la Víctima: <b>{{ $denunciado['vinculo_vict'] ?? 'Sin datos' }}</b></div>
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
                                    <div>Apellido y Nombre: <b>{{ $victima->apellido ?? 'No hay apellido cargado' }} {{ $victima['nombre'] ?? 'No hay nombre cargado' }}</b></div>
                                    <div>Tipo de Documento y Número: <b>{{ $victima->tipoDni->des_abr }} ({{ $victima->tipoDni->destipdoc }}) {{ number_format($victima['nro_doc'], 0, ',', '.') }}</b></div>
                                    <div>Sexo: <b>{{ $victima->sexo->descsexo ?? 'Información no encontrada' }}</b></div>
                                    <div>Fecha de Nacimiento: <b>{{ \Carbon\Carbon::parse($victima['fecha_nac'])->format('d-m-Y') }}</b></div>
                                    <div>Domicilio: <b>{{ $victima['domicilio'] ?? 'Sin datos' }}</b></div>
                                    <div>Mail: <b>{{ $victima['mail'] ?? 'Sin datos' }}</b></div>
                                    <div>Teléfono: <b>{{ $victima['telefono'] ?? 'Sin datos' }}</b></div>
                                    <div>Vínculo con la Institución: <b>{{ $victima->vinculo->descripcion ?? 'Sin datos' }}</b></div>
                                @else
                                    <div>No hay datos cargados de la víctima</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection