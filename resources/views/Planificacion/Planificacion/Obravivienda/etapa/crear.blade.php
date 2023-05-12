@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nueva etapa para la obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'obravivienda.guardarnuevaetapa', 'method' => 'POST']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div hidden>
                                    {!! Form::text('id_obr', $obra->id_obr, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('N° Etapa:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!} <span class="obligatorio">*</span>
                                        {!! Form::number('num_eta', $obra->getEtapas->sortBy('nro_eta')->last()->nro_eta + 1, ['class' => 'form-control', 'required']) !!}
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
                                {!! Form::label('Cantidad de dormitorios:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('0 Dormitorios:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('2 Dormitorios:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_2', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('3 Dormitorios:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_3', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('4 Dormitorios:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_4', 0, ['class' => 'form-control']) !!}
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
