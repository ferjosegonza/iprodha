@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nueva Obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'ofeobra.store', 'method' => 'POST']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('num_obr', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nomobra', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('idloc', $Localidad, 98, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::select('idempresa', $Empresa, 0, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('idloc', $Localidad, 98, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::select('idtipocontrato', $TipoContrato, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::date('publica', \Carbon\Carbon::now(), [
                                            'min' => '2022-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'periodo',
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!} 
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Fecha inicio:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ini', null, [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Fecha fin:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ter', null, [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('plazo', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!} 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                {!! Form::label('Cantidad de Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('0 (CERO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('2 (DOS):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_2', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('3 (TRES):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_3', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('4 (CUATRO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_4', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de Viviendas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_viv', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Etapas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_eta', 1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('monviv', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('moninf', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('monnex', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('montotope', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto p-2"></div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
                                            {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                            {!! Form::number('plazo', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
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
                                </div>                      
                            </div> --}}
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAS')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
