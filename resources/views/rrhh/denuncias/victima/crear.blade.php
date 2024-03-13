@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registrar Víctima</h3>
            {{-- {{$denuncia}} --}}
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body" style="display:flex; flex-wrap: wrap;">
                        {!! Form::open(array('route'=>'rrhh.denuncias.victima.guardar', 'method'=>'POST'))!!}
                            {!! Form::hidden('id_denuncia', $denuncia->id_denuncia) !!}
                        <div class="row">
                            {{--
                                - todos los campos de la BD:
                                        'ID_DENUNCIA',
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

                                - todos los campos del form guardar:
                                        id_denuncia
                                        apellido_victima
                                        nombres_victima
                                        tipo-doc
                                        num-doc
                                        tipo-sex
                                        fecha-nac
                                        direccion
                                        email
                                        tel
                                        tipo-vinculo
                                --}}
                            <div class="form-group">
                                {!! Form::label('apellido_victima', 'Apellido y Nombres:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                <div class="form-group" style="display: flex; align-items:baseline; justify-content: flex-start;margin-bottom:0px;">
                                {!! Form::text('apellido_victima', null, [
                                    'id' => 'apellido_victima',
                                    'class' => 'form-control',
                                    'maxlength' => '50',
                                    'style' => 'text-transform:uppercase;max-width: 300px;',
                                    'placeholder' => 'Ingrese apellido']) !!}
                                {!! Form::text('nombres_victima', null, [
                                    'id' => 'nombres_victima',
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
                                    'maxlength' => '50',
                                    'style' => 'text-transform:uppercase;max-width: 700px; width: 100%;',
                                    'placeholder' => 'Ingrese dirección']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', 'E-mail:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                {!! Form::email('email', null, ['class' => 'form-control', 'style' => 'max-width: 300px;', 'maxlength' => '50',]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tel', 'Teléfono:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                {!! Form::tel('tel', null, ['class' => 'form-control', 'style'=> 'max-width: 300px;', 'maxlength' => '20',]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tipo-vinculo', 'Vínculo con el Instituto:', ['class' => 'form-label']) !!}
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