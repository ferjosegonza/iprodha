@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta Concepto Facturacion</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @include('layouts.modal.mensajes')

                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['route' => 'conceptofacturacion.store', 'method' => 'POST']) !!}
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group d-flex align-items-end ">
                                        <div style="width: 50%">
                                            {!! Form::label('Nombre del Concepto Facturacion:', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('concepto', null, ['class' => 'col-xs-12 col-sm-12 form-control']) !!}
                                        </div>
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary mx-3']) !!}
                                        {!! link_to_route('conceptofacturacion.index', $title = 'Volver', $parameters = [], $attributes = ['class'=>'btn  btn-secondary fo align-middle']) !!}
        
                                        {{-- Form::button('$AJAX Guardar', ['id' => 'AjaxGuardar', 'class' => 'btn btn-danger mx-3']) --}}
                                        {{-- Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-warning btn-sm'] )  --}}


                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Monto:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('monto', ['1' => '$ Plata', '2' => '% Porcentaje'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center flex-nowrap">
                                        {!! Form::label('Suma o Resta:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100% ']) !!}
                                        {!! Form::select('suma_o_resta', ['-1' => '- Resta', '0' => 'No Suma/No Resta', '1' => '+ Suma'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Nº Fila:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::number('numero_fila', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Nº Columna:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::number('numero_columna', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Fecha Baja:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::date('fecha_baja', null, ['class' => 'form-control','placeholder' => '']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('Enx Adju:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('enx_Adju', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('CR:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('cr', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        {!! Form::label('BN:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('bn', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('MV:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('mv', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('CH:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('ch', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Cap.:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_cap', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('PI:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('pi', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Nota Credito:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('nota_credito', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Adel. Cancela:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('adel_cancela', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('AH:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('ah', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Neta:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_neta', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Enmascara:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('enmascara', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Re Adju:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('re_adju', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Entre Per.:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('entre_per', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Mod NoUvi:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('modifica_nouvi', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Mod Uvi:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('modifica_uvi', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Capital:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('capital', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Deuda Cap:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('deuda_cap', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Forma Pura:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('forma_pura', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('AQ:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('aq', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                    <div class="form-group d-flex align-items-center ">
                                        {!! Form::label('Recargo:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                        {!! Form::select('recargo', ['0' => 'No', '1' => 'Si'],  '0', ['placeholder' => '', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
