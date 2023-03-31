@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Alta Sub-Item - Item: {{$unItem->nom_item}}</div>
        </div>        
        {{-- {!! Form::model($unItem, ['method' => 'POST', 'route' => ['ofeobraitemdet.store']]) !!} --}}
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
                                        {!! Form::select('unidad', $lasUnidades, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('cantidad',null, ['class' => 'form-control', 'step' => '.01']) !!}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::label('Costo Unitario:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {{-- {!! Form::text('costounitario', null, ['class' => 'form-control']) !!} --}}
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="costounitario" step='.01'>
                                          </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                    {{-- <div class="form-group">
                                        {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('idobra', $unItem->idobra, ['readonly','class' => 'form-control' ]) !!}
                                    </div> --}}
                                    <div class="form-group" style="display: none">
                                        {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('iditem', $unItem->iditem, ['readonly','class' => 'form-control' ]) !!}
                                    </div>
                                    <div class="form-group" style="display: none">
                                        {!! Form::label('Sub Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idsubitem', DB::table('iprodha.ofe_subitem')->max('idsubitem')+1, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                    {{-- <div class="form-group">
                                        {!! Form::label('Denominacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('denominacion', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div> --}}
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex mb-3">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @if ($unItem->getObra->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitemdet.detalleitem',encrypt($unItem->idobra)], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                {{-- {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
                                {!! Form::close() !!} --}}

                                {{-- {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',encrypt($unItem->idobra)], 'style' => '']) !!}
                                {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
                                {!! Form::close() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div style="width:99%;float:left;">
            <div style="width:10%;float:left;margin-left:1%;display:none;">
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra', $unItem->idobra, ['readonly','class' => 'form-control' ]) !!}
            </div>
            <div style="width:10%;float:left;margin-left:1%;display:none;">
                {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::text('iditem', $unItem->iditem, ['readonly','class' => 'form-control' ]) !!}
            </div>
            <div style="width:10%;float:left;margin-left:1%;display:none;">
                {!! Form::label('Sub Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::text('idsubitem', DB::table('iprodha.ofe_subitem')->max('idsubitem')+1, ['readonly','class' => 'form-control']) !!}
            </div>
            <div style="width:45%;float:left;margin-left:1%;">
                {!! Form::label('Denominacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('denominacion', null, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'style' => 'text-transform:uppercase',
                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                ]) !!}
            </div>
        </div>
        <div style="width:99%;float:left;">
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Unidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::select('unidad', $lasUnidades, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Cantidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('cantidad',null, ['class' => 'form-control']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Costo Unitario:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('costounitario', null, ['class' => 'form-control']) !!}
            </div>            
        </div>
            
        
            {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
        
        {!! Form::close() !!}
        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',encrypt($unItem->idobra)], 'style' => 'display:inline']) !!}
        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
        {!! Form::close() !!} --}}
    </section>
@endsection
