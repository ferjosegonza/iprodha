@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nueva vivienda para la obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => ['obravivienda.guardarnuevaviv', $obra->id_obr], 'method' => 'POST']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12" id="carga-individual">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center">
                                <h6>Vivienda</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method' => 'POST','route' => 'obravivienda.guardarvivienda']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Etapa:', null, ['class' => 'control-label fs-6', 'style' => '']) !!} <span class="obligatorio">*</span>
                                        {!! Form::select('etapa', $obra->getEtapas->sortBy('nro_eta')->pluck('nro_eta', 'id_etapa'), 0, ['class' => 'form-select', 'id' => 'idetapa', 'placeholder' => 'Seleccionar', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('N° Orden:', null, ['class' => 'control-label fs-6', 'style' => '']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::number('orden', $ultimoOrden ?? 0, ['class' => 'form-control', 'id' => 'idorden', 'required', 'data-type' => 'limitcarac3']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plano:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('plano', null, ['class' => 'form-control', 'id' => 'idplano', 'data-type' => 'limitcarac10']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Partida:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('partida', null, ['class' => 'form-control', 'id' => 'idpartida', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac12']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Partida UCAC:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('partidaucac', null, ['class' => 'form-control', 'id' => 'idpartidaucac', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac12']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Viv. para Discapacitados:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('vivdisc', [ 0 => 'NO', 1 => 'SI'], 0, ['class' => 'form-select', 'id' => 'idvivdisc']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                            </div>
                            <div class="row border border-bottom-0">
                                <div class="row">
                                    {!! Form::label('Datos Catastro:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Sección:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('seccion', null, ['class' => 'form-control', 'id' => 'idseccion', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac3']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Chacra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('chacra', null, ['class' => 'form-control', 'id' => 'idchacra', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('manzana', null, ['class' => 'form-control', 'id' => 'idmanzana', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Parcela:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('parcela', null, ['class' => 'form-control', 'id' => 'idparcela', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Finca:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('finca', null, ['class' => 'form-control', 'id' => 'idfinca', 'data-type' => 'limitcarac6']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Edificio:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('edif', null, ['class' => 'form-control', 'id' => 'idedif', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Piso:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('piso', null, ['class' => 'form-control', 'id' => 'idpiso', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac2']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Departamento:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('depto', null, ['class' => 'form-control', 'id' => 'iddepto', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Escalera:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('esca', null, ['class' => 'form-control', 'id' => 'idesca', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Unidad funcional:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('unfun', null, ['class' => 'form-control', 'id' => 'idunfun', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac6']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 border">
                                    <div class="row">
                                        {!! Form::label('Identificacion S/Empresa:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('letmanza', null, ['class' => 'form-control', 'id' => 'idempmanza', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Lote:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('lote', null, ['class' => 'form-control', 'id' => 'idlote', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac12']) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 border border-start-0">
                                    <div class="row">
                                        {!! Form::label('Identificacion Municipal:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('N° Calle:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('numcalle', null, ['class' => 'form-control', 'id' => 'idnumcalle', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('Nombre Calle:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('nomcalle', null, ['class' => 'form-control', 'id' => 'idnomcalle', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac50']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Entre Calles:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('ent_calles', null, ['class' => 'form-control', 'id' => 'identcalle', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'data-type' => 'limitcarac80']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie cubierta:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('sup_fin', null, ['class' => 'form-control', 'id' => 'idnumfinca', 'step' => '.01']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie Lote:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('sup_lote', null, ['class' => 'form-control', 'id' => 'idsuplote', 'step' => '.01']) !!}
                                            </div>
                                        </div>
                                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie Cubierta:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('num_obr', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row pt-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        {!! Form::label('Deslinde:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::textarea('deslinde', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'id' => 'iddeslinde']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAVIVIENDA')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success', 'id' => 'guardarVivienda']) !!}
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
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/format_obravivienda.js') }}"></script>
@endsection
