@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Oferta de Obras</h3>
        </div>
        <div class="section-body">
            {!! Form::model($unaOferta, ['method' => 'PUT', 'route' => ['ofeobra.update', $unaOferta->idobra]]) !!}
            @include('layouts.modal.mensajes')
            <div style="background-color: rgb(204, 119, 7)">
                <div style="width:99%;float:left;">
                    <div hidden>
                        {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                        {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
                    </div>
                    <div style="width:65%;float:left;margin-left:1%;">
                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                        {!! Form::text('nomobra', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                    <div style="width:25%;float:left;margin-left:1%;">
                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                        {!! Form::select('idloc', $Localidad, $unaOferta->idloc, [
                            'placeholder' => 'Seleccionar',
                            'class' => 'form-select',
                        ]) !!}
                    </div>
                </div>
                <div style="width:99%;float:left;">

                    <div style="width:30%;float:left;margin-left:1%;">
                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                        {!! Form::select('idempresa', $Empresa, $unaOferta->id_emp, [
                            'placeholder' => 'Seleccionar',
                            'class' => 'form-select',
                        ]) !!}
                    </div>
                    <div style="width:30%;float:left;margin-left:1%;">
                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                        {!! Form::select('idtipocontrato', $TipoContrato, $unaOferta->idtipocontratofer, [
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
                        {!! Form::label('Expediente:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                        {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div style="width:99%;float:left;background-color: rgb(224, 212, 194); padding:1%;margin-top:1%;">
                <div style="width:24%;float:left;margin-left:1%;">
                    {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::number('monviv', null, ['class' => 'form-control']) !!}
                </div>
                <div style="width:24%;float:left;margin-left:1%;">
                    {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::number('moninf', null, ['class' => 'form-control']) !!}
                </div>
                <div style="width:24%;float:left;margin-left:1%;">
                    {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::number('monnex', null, ['class' => 'form-control']) !!}
                </div>
                <div style="width:19%;float:left;margin-left:1%;">
                    {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::number('montotope', null, ['class' => 'form-control']) !!}
                </div>

                <div style="width:19%;float:left;margin-left:1%;">
                    {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::text('plazo', null, ['class' => 'form-control']) !!}
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
            {!! Form::submit('Grabar', ['class' => 'btn btn-warning mt-2']) !!}
            {!! Form::close() !!}
        </div>
        <div class="mt-2" style="width:10%;float:left;margin-left:0%;">
            {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => 'display:inline']) !!}
            {!! Form::submit('Volver', ['class' => 'btn btn-primary ']) !!}
            {!! Form::close() !!}
        </div>
    </section>
@endsection

