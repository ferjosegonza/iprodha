@extends('layouts.app')
@section('content')
<style>
    /* #table-input input{
        background-color : #e4e4e4;
        border : none;
        outline : none;
    } */
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1 fs-5">Ver Obra y Items</div>
            </div>
            <div class="ms-auto">
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Información de la Obra</h5></div>
                        </div>
                        <div class="card-body">
                            <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text($obra->id_obr, null, ['style' => 'disabled;' ]) !!}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->num_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->nom_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_loc', $obra->getLocalidad->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $obra->getEmpresa->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $obra->getTipoObra->tipo_obra ?? '--', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Operatoria:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $obra->getOperatoria->operatoria ?? '--', ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Items de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Items</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {!! Form::model($obra,['method' => 'PUT', 'route' => ['itemizado_obra.update', $obra->id_obr], 'class' => 'd-flex justify-content-start']) !!}
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success w-100', 'id' => 'btn-guardar']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="items" class="table table-hover mt-2" class="display">
                                    <thead>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:55%;">Nombre</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Costo</th>
                                    </thead>
                                    <tbody id="table-input">
                                        {{-- <tr>
                                            <td class = 'text-center' style="vertical-align: middle;">1</td>
                                            <td class = 'text-center align-middle'>item uno</td>
                                            <td class = 'text-center'>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input class="form-control" type="text" name="montotope" value="0.00" data-type="currency">
                                                </div>
                                                {{-- {!! Form::number('nombobra', 100.45, ['style' => 'disabled;', 'class' => 'form-control']) !!}
                                            </td>
                                        </tr> --}}
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($ItemsObra as $item)
                                            <tr>
                                                <td class = 'text-center' style="vertical-align: middle;">{{$item->orden}}</td>
                                                <td class = 'text-center align-middle'>{{$item->nom_item}}</td>
                                                <td class = 'text-center'>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input class="form-control item-costo" type="text" name="item-{{$item->id_item}}" value="{{$item->costo}}" data-type="currency">
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $subtotal += $item->costo;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td class = 'text-end'>Sub-Total:</td>
                                            <td style="color: green" id='nuevo-subtotal'>$ {{number_format($subtotal,2, ',', '.')}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class = 'text-end'>Sub-Total Actual:</td>
                                            <td style="color: green" id='actual-subtotal'>$ {{number_format($subtotal,2, ',', '.')}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                {{-- ------------- --}}

                

                

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                            {{-- {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!} --}}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'itemizado_obra.index', 'style' => '']) !!}
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
    {{-- <script src="{{ asset('js/input-format-dinero.js') }}"></script> --}}
    <script src="{{ asset('js/Planificacion/Planificacion/Itemizado/edit_itemizado_obra.js') }}"></script>
@include('layouts.modal.confirmation')
@endsection

@section('js')

@endsection
