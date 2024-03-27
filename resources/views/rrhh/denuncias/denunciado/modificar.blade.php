@extends('layouts.app')

@section('content')
    <head>
        <script src="{{ asset('js/archivo/digitalizacion.js') }}"></script>
    </head>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Modificar Denunciado</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div><h4>Datos actuales:</h4></div>
                        {!! Form::model($denunciado,['method'=>'PATCH',
                                                'class' => 'formulario',
                                                'route'=>['rrhh.denuncias.denunciado.update', $denunciado->id_denuncia]
                                                ])!!}
                            <div class="row">
                                <div class="form-group">
                                    {!! Form::label('apellido_denunciado', 'Apellido y Nombres:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    <div class="form-group" style="display: flex; align-items:baseline; justify-content: flex-start;margin-bottom:0px;">
                                    {!! Form::text('apellido_denunciado', $denunciado->apellido, [
                                        'id' => 'apellido_denunciado',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 300px;',
                                        'placeholder' => 'Ingrese apellido',
                                        'required' => true]) !!}
                                    {!! Form::text('nombres_denunciado', $denunciado->nombre, [
                                        'id' => 'nombres_denunciado',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 300px;margin-left: 10px',
                                        'placeholder' => 'Ingrese nombres',
                                        'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('identificacion', 'Identificación:', ['class' => 'form-label']) !!}
                                    <div class="form-group" style="display: flex; align-items:center; justify-content: flex-start;margin-bottom:0%">
                                        <select name="tipo-doc" id="tipo-doc" class="form-select" style="max-width: 300px;" required>
                                            @foreach ($todosLosTipdoc as $tipdoc)
                                                <option value="{{ $tipdoc->id_tipdoc }}" {{ $tipdoc->id_tipdoc == $denunciado->tipo_doc ? 'selected' : '' }}>{{ $tipdoc->des_abr }} - {{ $tipdoc->destipdoc }}</option>
                                            @endforeach
                                        </select>
                                        {!! Form::number('num-doc', $denunciado->nro_doc, ['type' => 'number','class' => 'form-control', 'style'=> 'max-width: 300px;margin-left: 10px', 'min' => 1, 'max' => 999999999, 'placeholder' => 'INGRESE NÚMERO', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex; justify-content: flex-start; align-items: flex-end;margin-bottom:0px">
                                        {!! Form::label('tipo-sex', 'Sexo:', ['class' => 'form-label', 'style' => 'width: 30%;margin-bottom:0px']) !!}
                                        {!! Form::label('fecha-nac', 'Fecha Nacimiento:', ['class' => 'form-label','style' => 'color:black;margin-left: 20px;margin-bottom:0px']) !!}
                                </div>
                                <div class="form-group" style="display: flex; justify-content:flex-start; align-items:flex-start;margin:10px 0 0 0">
                                    <select name="tipo-sex" id="tipo-sex" class="form-select" style="width: 30%;margin-bottom:15px;margin-top:0px" required>
                                        @foreach ($todosLosSexo as $tipoSexo)
                                            <option value="{{ $tipoSexo->codsexo }}" {{ $tipoSexo->codsexo == $denunciado->id_sexo ? 'selected' : '' }}>{{ $tipoSexo->descsexo }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::date('fecha-nac',\Carbon\Carbon::parse($denunciado->fecha_nac),['class'=>'form-control date-field mb-3', 'style' => 'width: auto;justify-content:left;margin:0 0 0 20px', 'max' => now()->format('Y-m-d')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('direccion', 'Dirección:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::text('direccion', $denunciado->domicilio, [
                                        'id' => 'direccion',
                                        'class' => 'form-control',
                                        'maxlength' => '50',
                                        'style' => 'text-transform:uppercase;max-width: 700px; width: 100%;',
                                        'placeholder' => 'Ingrese dirección']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::email('email', $denunciado->mail, ['class' => 'form-control', 'style' => 'max-width: 300px;', 'maxlength' => '50',]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tel', 'Teléfono:', ['class' => 'form-label', 'style' => 'margin-bottom:0px;']) !!}
                                    {!! Form::tel('tel', $denunciado->telefono, ['class' => 'form-control', 'style'=> 'max-width: 300px;', 'maxlength' => '20',]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('tipo-vinculo', 'Vínculo con el Instituto:', ['class' => 'form-label']) !!}
                                    <select name="tipo-vinculo" id="tipo-vinculo" class="form-select" style="max-width: 300px;">
                                        @foreach ($todosLosVinculos as $vinculo)
                                            <option value="{{ $vinculo->id_vinculo }}" {{ $vinculo->id_vinculo == $denunciado->vinculo_inst ? 'selected' : ''}}>{{ $vinculo->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('vinculo-victima', 'Vínculo del denunciado con la víctima (máximo 100 caracteres):', ['class' => 'form-label']) !!}
                                    {!! Form::textarea('vinculo-victima', $denunciado->vinculo_vict, [
                                        'class' => 'form-control',
                                        'style'=> 'max-width: 700px; width: 100%; height: 80px; resize: none',
                                        'maxlength' => '100',
                                        'onkeyup' => 'javascript:this.value=this.value.toUpperCase(), contadorchar("vinculo_caracteres", "vinculo-victima", 100)']) !!}
                                    <label for="vinculo-victima" id="vinculo_caracteres">Quedan 100 caracteres.</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                @can('CREAR-DENUNCIA')
                                {!! Form::submit('Editar', ['onclick' => '', 'class' => 'btn btn-success mr-2']) !!}
                                @endcan
                                <a href="{{ route('rrhh.denuncias.intervinientes', ['id' => $denunciado->id_denuncia]) }}" class="btn btn-secondary mr-2">Volver</a>
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