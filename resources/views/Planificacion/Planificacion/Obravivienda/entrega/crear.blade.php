@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1 fs-5">
                <strong>
                    Nueva entrega para la etapa de la obra
                </strong> 
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {!! Form::open(['route' => 'obravivienda.guardarnuevaentrega', 'method' => 'POST']) !!}               
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div hidden>
                                    {!! Form::text('id_obr', $obra->id_obr, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('N° Entrega:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!} <span class="obligatorio">*</span>
                                        {!! Form::number('num_ent', max($todasLasEntregas) + 1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!} <span class="obligatorio">*</span>
                                        {!! Form::text('descrip', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('N° Etapa', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idetapa', $etapas, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Fecha de entrega:', null, [
                                                'class' => 'control-label fs-6',
                                                'style' => '',
                                            ]) !!}
                                            {!! Form::date('fec_ent', null, [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de viviendas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::number('cant_viv', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div> --}}
                            </div>
                            
                    
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAVIVIENDA')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.etapas', $obra->id_obr], 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
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
