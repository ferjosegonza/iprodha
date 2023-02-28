@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo">Nueva Oferta</div>
        </div>
        {!! Form::open(['route' => 'ofeobra.store', 'method' => 'POST']) !!}
        @include('layouts.modal.mensajes')
        <div style="width:99%;float:left;">
            <div hidden>
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
            </div>
            <div style="width:65%;float:left;margin-left:1%;">
                {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('nomobra', null, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'style' => 'text-transform:uppercase',
                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                ]) !!}
            </div>
            <div style="width:25%;float:left;margin-left:1%;">
                {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                {!! Form::select('idloc', $Localidad, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
            </div>
        </div>
        <div style="width:99%;float:left;">
            <div style="width:30%;float:left;margin-left:1%;">
                {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::select('idempresa', $Empresa, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
            </div>
            <div style="width:30%;float:left;margin-left:1%;">
                {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::select('idtipocontrato', $TipoContrato, null, [
                    'placeholder' => 'Seleccionar',
                    'class' => 'form-select',
                ]) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::date('periodo', \Carbon\Carbon::now(), [
                    'min' => '2022-01-01',
                    'max' => \Carbon\Carbon::now()->year . '-12',
                    'id' => 'periodo',
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!}                
            </div>
        </div>


            <div style="width:24%;float:left;margin-left:1%;">
                {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::number('monviv', null, ['readonly','class' => 'form-control']) !!}
            </div>
            <div style="width:24%;float:left;margin-left:1%;">
                {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::number('moninf', null, ['readonly','class' => 'form-control']) !!}
            </div>
            <div style="width:24%;float:left;margin-left:1%;">
                {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::number('monnex', null, ['readonly','class' => 'form-control']) !!}
            </div>
            <div style="width:19%;float:left;margin-left:1%;">
                {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::number('montotope', null, ['class' => 'form-control']) !!}
            </div>

        <div style="width:99%;float:left;background-color: rgb(223, 188, 144); padding:1%;margin-top:1%;">
            <div style="width:19%;float:left;margin-left:1%;">
                {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::number('plazo', null, ['class' => 'form-control']) !!}
            </div>
            <div style="width:19%;float:left;margin-left:1%;">
                {!! Form::label('Año y Mes de Cotización:', null, [
                    'class' => 'control-label',
                    'style' => 'white-space: nowrap;',
                ]) !!}
                {!! Form::month('anioymes', \Carbon\Carbon::now(), [
                    'min' => '2022-01-01',
                    'max' => \Carbon\Carbon::now()->year . '-12',
                    'id' => 'periodo',
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        @can('CREAR-OBRAS')
            {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
        @endcan
        {!! Form::close() !!}
        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => 'display:inline']) !!}
        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
        {!! Form::close() !!}
    </section>
@endsection
