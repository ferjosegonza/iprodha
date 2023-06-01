@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Alta Sub-Item - Item: <strong>{{$unItem->nom_item}}</strong></div>
        </div>        
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($unItem, ['method' => 'POST', 'route' => ['ofeobraitemdet.store']]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('Denominacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('denominacion', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::label('Unidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('unidad', $lasUnidades, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::number('cantidad', 0, ['class' => 'form-control', 'step' => '.01']) !!}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::label('Costo Unitario:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" type="text" name="costounitario" value = '0.00' data-type="currency">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                    <div class="form-group" style="display: none">
                                        {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('iditem', $unItem->iditem, ['readonly','class' => 'form-control' ]) !!}
                                    </div>
                                    <div class="form-group" style="display: none">
                                        {!! Form::label('Sub Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idsubitem', DB::table('iprodha.ofe_subitem')->max('idsubitem')+1, ['readonly','class' => 'form-control']) !!}
                                    </div>   
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto my-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @if ($unItem->getObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitemdet.detalleitem', base64url_encode($unItem->iditem)], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="d-flex mb-3">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @if ($unItem->getObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitemdet.detalleitem', $unItem->idobra], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/input-format-dinero.js') }}"></script>
@endsection
