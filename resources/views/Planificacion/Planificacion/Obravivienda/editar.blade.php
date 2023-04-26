@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Editar Obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {!! Form::model($obra,['method' => 'PUT', 'route' => ['obravivienda.update', $obra->id_obr], 'class' => 'd-flex justify-content-start']) !!}
                {{-- {!! Form::open(['route' => 'obravivienda.update', 'method' => 'PUT']) !!} --}}
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div hidden>
                                    {!! Form::text('id_obr', $obra->id_obr, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label" style="white-space: nowrap;width:20%;">Numero: <span class="obligatorio">*</span></label>   
                                        {!! Form::number('num_obr', $obra->num_obr, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        <label for="Obra:" class="control-label" style="white-space: nowrap;width:20%;">Obra: <span class="obligatorio">*</span></label>
                                        {!! Form::text('nom_obra', $obra->nom_obr, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="Empresa:" class="control-label" style="white-space: nowrap;width:20%;">Empresa: <span class="obligatorio">*</span></label>
                                        {!! Form::select('idempresa', $Empresa, $obra->id_emp, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="Localidad:" class="control-label" style="white-space: nowrap;width:20%;">Localidad: <span class="obligatorio">*</span></label>
                                        {!! Form::select('idloc', $Localidad, $obra->id_loc, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Expediente:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('expediente', $obra->expedte, ['class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Cantidad de viviendas:" class="control-label" style="white-space: nowrap;width:20%;">Cantidad de viviendas: <span class="obligatorio">*</span></label>
                                        {!! Form::number('can_viv', $obra->can_viv, ['class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha inicio:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ini', \Carbon\Carbon::parse($obra->fec_ini)->format('Y-m-d'), [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha fin:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ter', \Carbon\Carbon::parse($obra->fec_ent)->format('Y-m-d'), [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('plazo', $obra->plazo, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                
                            </div>
                            
                    
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
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
