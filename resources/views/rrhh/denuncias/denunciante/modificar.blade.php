@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Modificar Denunciante</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div><h4>Datos actuales:</h4></div>
                        {!! Form::model($denunciante,['method'=>'PATCH',
                                                'class' => 'formulario',
                                                'route'=>['rrhh.denuncias.denunciante.update', $denunciante->id_denuncia]
                                                ])!!}
                            <div class="row">
                                <div class="form-group form-check-inline" style="align-items:baseline; display:flex;">
                                    {!! Form::checkbox('denunciante_victima', 1, $denunciante->es_victima, ['class' => 'form-check-input', 'id' => 'isVictima']) !!}
                                    {!! Form::label('denunciante_victima', '¿El Denunciante y la Víctima son la misma persona?', ['class' => 'form-label m-1', 'style' => 'color:black;']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('apellido_denunciante', 'Apellido y Nombres:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    <div class="form-group" style="display: flex; align-items:baseline; justify-content: flex-start;margin-bottom:0px;">
                                    {!! Form::text('apellido_denunciante', $denunciante->apellido, [
                                        'id' => 'apellido_denunciante',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 300px;',
                                        'placeholder' => 'Ingrese apellido']) !!}
                                    {!! Form::text('nombres_denunciante', $denunciante->nombre, [
                                        'id' => 'nombres_denunciante',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 300px;margin-left: 10px',
                                        'placeholder' => 'Ingrese nombres']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('identificacion', 'Identificación:', ['class' => 'form-label']) !!}
                                    <div class="form-group" style="display: flex; align-items:center; justify-content: flex-start;margin-bottom:0%">
                                        <select name="tipo-doc" id="tipo-doc" class="form-select" style="max-width: 300px;" required>
                                            @foreach ($todosLosTipdoc as $tipdoc)
                                                <option value="{{ $tipdoc->id_tipdoc }}" {{ $tipdoc->id_tipdoc == $denunciante->tipo_doc ? 'selected' : '' }}>{{ $tipdoc->des_abr }} - {{ $tipdoc->destipdoc }}</option>
                                            @endforeach
                                        </select>
                                        {!! Form::number('num-doc', $denunciante->nro_doc, ['type' => 'number','class' => 'form-control', 'style'=> 'max-width: 300px;margin-left: 10px', 'min' => 1, 'max' => 999999999, 'placeholder' => 'INGRESE NÚMERO', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex; justify-content: flex-start; align-items: flex-end;margin-bottom:0px">
                                        {!! Form::label('tipo-sex', 'Sexo:', ['class' => 'form-label', 'style' => 'width: 30%;margin-bottom:0px']) !!}
                                        {!! Form::label('fecha-nac', 'Fecha Nacimiento:', ['class' => 'form-label','style' => 'color:black;margin-left: 20px;margin-bottom:0px']) !!}
                                </div>
                                <div class="form-group" style="display: flex; justify-content:flex-start; align-items:flex-start;margin:10px 0 0 0">
                                    <select name="tipo-sex" id="tipo-sex" class="form-select" style="width: 30%;margin-bottom:15px;margin-top:0px" required>
                                        @foreach ($todosLosSexo as $tipoSexo)
                                            <option value="{{ $tipoSexo->codsexo }}" {{ $tipoSexo->codsexo == $denunciante->id_sexo ? 'selected' : '' }}>{{ $tipoSexo->descsexo }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::date('fecha-nac',\Carbon\Carbon::parse($denunciante->fecha_nac),['class'=>'form-control date-field mb-3', 'style' => 'width: auto;justify-content:left;margin:0 0 0 20px', 'max' => now()->format('Y-m-d')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('direccion', 'Dirección:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::text('direccion', $denunciante->domicilio, [
                                        'id' => 'direccion',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 700px; width: 100%;',
                                        'placeholder' => 'Ingrese dirección']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::email('email', $denunciante->mail, ['class' => 'form-control', 'style' => 'max-width: 300px;', 'maxlength' => '50',]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tel', 'Teléfono:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::tel('tel', $denunciante->telefono, ['class' => 'form-control', 'style'=> 'max-width: 300px;', 'maxlength' => '20',]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tipo-vinculo', 'Vínculo con el Instituto:', ['class' => 'form-label']) !!}
                                    <select name="tipo-vinculo" id="tipo-vinculo" class="form-select" style="max-width: 300px;">
                                        @foreach ($todosLosVinculos as $vinculo)
                                            <option value="{{ $vinculo->id_vinculo }}" {{ $vinculo->id_vinculo == $denunciante->vinculo_inst ? 'selected' : ''}}>{{ $vinculo->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                @can('CREAR-DENUNCIA')
                                {!! Form::submit('Editar', ['onclick' => '', 'class' => 'btn btn-success mr-2']) !!}
                                @endcan
                                <a href="{{ route('rrhh.denuncias.intervinientes', ['id' => $denunciante->id_denuncia]) }}" class="btn btn-secondary mr-2">Volver</a>
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