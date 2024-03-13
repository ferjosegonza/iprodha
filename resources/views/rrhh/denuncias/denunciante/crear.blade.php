@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registrar Denunciante</h3>
            {{-- {{$denuncia}} --}}
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body" style="display:flex; flex-wrap: wrap;">
                        {!! Form::open(array('route'=>'rrhh.denuncias.denunciante.guardar', 'method'=>'POST'))!!}
                            {!! Form::hidden('id_denuncia', $denuncia->id_denuncia) !!}
                        <div class="row">
                            {{-- 
                                - todos los campos de la BD:
                                ID_DENUNCIA
                                    NRO_DOC
                                    APELLIDO
                                    NOMBRE
                                    TIPO_DOC
                                    ID_SEXO
                                    FECHA_NAC
                                    DOMICILIO
                                    MAIL
                                    TELEFONO
                                VINCULO_INST
                                    ES_VICTIMA

                                    - todos los campos del form guardar:
                                    id_denuncia
                                    denunciante_victima
                                    apellido_denunciante
                                    nombres_denunciante
                                    tipo-doc
                                    num-doc
                                    tipo-sex
                                    fecha-nac
                                    direccion
                                    email
                                    tel
                                    tipo-vinculo

                                DATOS A CARGAR:
                                    - poner un checkbox con una preg tipo "¿El Denunciante y la Víctima son la misma persona?" y si es, cargar tb en la tabla victima o ver con sergio cómo hacemos
                                    - ape y nom
                                    - tipo y nº doc
                                    - sexo
                                    - fecha nac (en el pdf hay un campo "edad" pero lo puedo deducir de la fecha nac así q no es necesario)
                                    - domicilio
                                    - telefono
                                    - e-mail (no está pero como este dato se le pide a la víctima y puede q sean la misma persona más vale tenerlo tb)
                                - vínculo con el Instituto (marcar lo q corresponda)
                                    -- Autoridad
                                    -- Personal Administrativo
                                    -- Público externo
                                    -- Personal de servicios tercerizados
                                    -- Otro: (campo para describir)
                                --}}
                            <div class="form-group form-check-inline" style="align-items:baseline; display:flex;">
                                {!! Form::checkbox('denunciante_victima', 1, false, ['class' => 'form-check-input', 'id' => 'isVictima']) !!}
                                {!! Form::label('denunciante_victima', '¿El Denunciante y la Víctima son la misma persona?', ['class' => 'form-label m-1', 'style' => 'color:black;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('apellido_denunciante', 'Apellido y Nombres:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                <div class="form-group" style="display: flex; align-items:baseline; justify-content: flex-start;margin-bottom:0px;">
                                {!! Form::text('apellido_denunciante', null, [
                                    'id' => 'apellido_denunciante',
                                    'class' => 'form-control',
                                    'style' => 'text-transform:uppercase;max-width: 300px;',
                                    'placeholder' => 'Ingrese apellido']) !!}
                                {!! Form::text('nombres_denunciante', null, [
                                    'id' => 'nombres_denunciante',
                                    'class' => 'form-control',
                                    'style' => 'text-transform:uppercase;max-width: 300px;margin-left: 10px',
                                    'placeholder' => 'Ingrese nombres']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('identificacion', 'Identificación:', ['class' => 'form-label']) !!}
                                <div class="form-group" style="display: flex; align-items:center; justify-content: flex-start;margin-bottom:0%">
                                    {{-- tabla "TIP_DOC" de BD iprodha --}}
                                    {{-- {!! Form::select('tipo-doc', [
                                        '4'	=>	'DNI - Documento Nacional de Identidad',
                                        '1'	=>	'LE - Libreta Enrolamiento',
                                        '2'	=>  'LC - Libreta Cívica	',
                                        '3'	=>	'CI - Cédula Identidad',
                                        '5'	=>	'DE - Documento Extranjero',
                                        '6'	=>	'Pas. - Pasaporte',
                                        '7' =>		'N/E - No Especifica'
                                    ], null, ['class' => 'form-select', 'style'=> 'max-width: 300px;', 'placeholder' => 'SELECCIONE TIPO...', 'required' => true]) !!} --}}
                                    <select name="tipo-doc" id="tipo-doc" class="form-select" style="max-width: 300px;" required>
                                        @foreach ($todosLosTipdoc as $tipdoc)
                                            <option value="{{ $tipdoc->id_tipdoc }}">{{ $tipdoc->des_abr }} - {{ $tipdoc->destipdoc }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::number('num-doc', null, ['type' => 'number','class' => 'form-control', 'style'=> 'max-width: 300px;margin-left: 10px', 'min' => 1, 'max' => 999999999, 'placeholder' => 'INGRESE NÚMERO', 'required' => true]) !!}
                                </div>
                            </div>
                            <div class="form-group" style="display: flex; justify-content: flex-start; align-items: flex-end;margin-bottom:0px">
                                    {!! Form::label('tipo-sex', 'Sexo:', ['class' => 'form-label', 'style' => 'width: 30%;margin-bottom:0px']) !!}
                                    {!! Form::label('fecha-nac', 'Fecha Nacimiento:', ['class' => 'form-label','style' => 'color:black;margin-left: 20px;margin-bottom:0px']) !!}
                            </div>
                            <div class="form-group" style="display: flex; justify-content:flex-start; align-items:flex-start;margin:10px 0 0 0">
                                {{-- tabla "sexo" de BD iprodha --}}
                                {{-- {!! Form::select('tipo-sex', [
                                        '1'	=>	'Masculino',
                                        '2'	=>	'Femenino',
                                        '3' => 'No binario',
                                        '0' => 'No informa'
                                    ], '0', ['class' => 'form-select', 'style'=> 'width: 30%;margin-bottom:15px;margin-top:0px', 'placeholder' => 'SELECCIONE TIPO...']) !!} --}}
                                <select name="tipo-sex" id="tipo-sex" class="form-select" style="width: 30%;margin-bottom:15px;margin-top:0px" required>
                                    @foreach ($todosLosSexo as $tipoSexo)
                                        <option value="{{ $tipoSexo->codsexo }}">{{ $tipoSexo->descsexo }}</option>
                                    @endforeach
                                </select>
                                {!! Form::date('fecha-nac',\Carbon\Carbon::now(),['class'=>'form-control date-field mb-3', 'style' => 'width: auto;justify-content:left;margin:0 0 0 20px', 'max' => now()->format('Y-m-d')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('direccion', 'Dirección:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                {!! Form::text('direccion', null, [
                                    'id' => 'direccion',
                                    'class' => 'form-control',
                                    'style' => 'text-transform:uppercase;',
                                    'placeholder' => 'Ingrese dirección']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', 'E-mail:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                {!! Form::email('email', null, ['class' => 'form-control', 'style' => 'max-width: 300px']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tel', 'Teléfono:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                {!! Form::tel('tel', null, ['class' => 'form-control', 'style'=> 'max-width: 300px;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tipo-vinculo', 'Vínculo con el Instituto:', ['class' => 'form-label']) !!}
                                {{-- {!! Form::select('tipo-vinculo', [
                                        '1' => 'Autoridad',
                                        '2' => 'Personal Administrativo',
                                        '3' => 'Público externo',
                                        '4' => 'Personal de servicios tercerizados',
                                    ], '1', ['class' => 'form-select', 'style'=> 'max-width: 300px;', 'placeholder' => 'SELECCIONE TIPO...']) !!} --}}
                                <select name="tipo-vinculo" id="tipo-vinculo" class="form-select" style="max-width: 300px;">
                                    @foreach ($todosLosVinculos as $vinculo)
                                        <option value="{{ $vinculo->id_vinculo }}">{{ $vinculo->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('rrhh.denuncias.intervinientes', ['id' => $denuncia->id_denuncia]) }}" class="btn btn-secondary mr-2">Volver</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection