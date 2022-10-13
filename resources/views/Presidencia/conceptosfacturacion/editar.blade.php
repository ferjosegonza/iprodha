@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Usuario</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @include('layouts.modal.mensajes')

                    <div class="card">
                        <div class="card-body">
                    
                            {!! Form::model($concepto, ['method' => 'PATCH','route' => ['conceptofacturacion.update', $concepto->idconcepto]]) !!}
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group d-flex align-items-end ">
                                        <div style="width: 50%">
                                            {!! Form::label('Nombre del Concepto Facturacion:', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('concepto', null, ['class' => 'col-xs-12 col-sm-12 form-control']) !!}
                                        </div>
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary mx-3']) !!}
                                        <a href="{{ route('conceptofacturacion.index') }}"
                                            class="btn  btn-secondary fo align-middle"> <span
                                                class="align-middle">Volver</span></a>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Monto:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('monto', ['1' => '$ Plata', '2' => '% Porcentaje'], $concepto->monpor, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center flex-nowrap">
                                        {!! Form::label('Suma o Resta:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100% ']) !!}
                                        {!! Form::select('suma_o_resta', ['-1' => '- Resta', '0' => 'No Suma/No Resta', '1' => '+ Suma'], $concepto->sumaoresta, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Nº Fila:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::number('numero_fila', $concepto->nrofila, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Nº Columna:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::number('numero_columna', $concepto->nrocolumna, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Fecha Baja:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::date('fecha_baja', null, ['class' => 'form-control']) !!}
                                        {{-- Form::date('fecha_baja', \Carbon\Carbon::createFromDate($concepto->fechabaja)->format('Y-m-d'), ['class' => 'form-control']) --}}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Enx Adju:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('enx_Adju', ['0' => 'No', '1' => 'Si'], $concepto->va_enxadju, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('CR:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('cr', ['0' => 'No', '1' => 'Si'], $concepto->ve_cr, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('BN:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('bn', ['0' => 'No', '1' => 'Si'], $concepto->ve_bn, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('MV:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('mv', ['0' => 'No', '1' => 'Si'], $concepto->ve_mv, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('CH:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('ch', ['0' => 'No', '1' => 'Si'], $concepto->ve_ch, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Cap.:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_cap', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('PI:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('pi', ['0' => 'No', '1' => 'Si'], $concepto->ve_pi, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Nota Credito:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('nota_credito', ['0' => 'No', '1' => 'Si'], $concepto->ve_notacre, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Adel. Cancela:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('adel_cancela', ['0' => 'No', '1' => 'Si'], $concepto->ve_adel_canc, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('AH:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('ah', ['0' => 'No', '1' => 'Si'], $concepto->ve_ah, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Neta:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_neta', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Enmascara:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('enmascara', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Re Adju:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('re_adju', ['0' => 'No', '1' => 'Si'],  $concepto->ve_readju_comun, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Entre Per.:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('entre_per', ['0' => 'No', '1' => 'Si'], $concepto->ve_readju_entreper, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Mod NoUvi:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('modifica_nouvi', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Mod Uvi:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('modifica_uvi', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Capital:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('capital', ['0' => 'No', '1' => 'Si'], $concepto->es_capital, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Deuda Cap:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('deuda_cap', ['0' => 'No', '1' => 'Si'], $concepto->es_deuda_cap, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Pura:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_pura', ['0' => 'No', '1' => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('AQ:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('aq', ['0' => 'No', '1' => 'Si'], $concepto->forma_aq, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Recargo:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('recargo', ['0' => 'No', '1' => 'Si'], $concepto->forma_recargo, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="card">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
