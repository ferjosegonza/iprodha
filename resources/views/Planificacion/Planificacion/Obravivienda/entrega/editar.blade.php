@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Editar entrega para la etapa de la obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {!! Form::open(['route' => ['obravivienda.guaradreditarentrega', $entrega->id_ent], 'method' => 'POST']) !!}               
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div hidden>
                                        {!! Form::text('id_obr', $obra->id_obr, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('N° Entrega:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('num_ent', $entrega->num_ent, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('descrip', $entrega->descripcion, [
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
                                        {!! Form::label('N° Etapa', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::select('idetapa', $etapas, $entrega->id_eta, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Fecha de entrega:', null, [
                                                'class' => 'control-label',
                                                'style' => '',
                                            ]) !!}
                                            {!! Form::date('fec_ent', Carbon\Carbon::parse($entrega->fec_ent)->format('Y-m-d'), [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de viviendas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('cant_viv', $entrega->cant_viv, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            
                    
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                        @can('EDITAR-OBRAVIVIENDA')
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
