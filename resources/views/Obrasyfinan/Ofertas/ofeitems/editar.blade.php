@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Editar Item: {{$unItem->nom_item}}</div>            
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($unItem, ['method' => 'PATCH', 'route' => ['ofeobraitems.actualizar', $unItem]]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::select('cod_tipo', ['1' => 'Vivienda', '2' => 'Infraestructura', '3' => 'Nexo'], $unItem->cod_tipo, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Nom. Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_item', $unItem->nom_item, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()']) !!}
                                    </div>        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Costo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo', $unItem->costo, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Porc. Inc.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('por_inc', $unItem->por_inc, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('orden', $unItem->orden, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group" hidden>
                                        {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('idobra', $unItem->idobra, ['class' => 'form-control readonly']) !!}
                                    </div>
                                    <div class="form-group" hidden>
                                        {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('iditem',  $unItem->iditem, ['class' => 'form-control readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex mb-3">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @if ($laObra->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endif
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',encrypt($laObra->idobra)], 'style' => 'display:inline']) !!}
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

        {{-- {!! Form::model($unItem, ['method' => 'PATCH', 'route' => ['ofeobraitems.actualizar', $unItem]]) !!}
        @include('layouts.modal.mensajes')
        <div style="width:99%;float:left;">
            <div hidden>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::text('idobra', $unItem->idobra, ['disabled' => 'disabled','class' => 'form-control' ]) !!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::text('iditem',  $unItem->iditem, ['disabled' => 'disabled','class' => 'form-control']) !!}
                </div>            
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Tipo Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::select('cod_tipo', ['1' => 'Vivienda', '2' => 'Infraestructura', '3' => 'Nexo'], $unItem->cod_tipo, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}


            </div>
            <div style="width:45%;float:left;margin-left:1%;">
                {!! Form::label('Nom. Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('nom_item', $unItem->nom_item, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'style' => 'text-transform:uppercase',
                    'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                ]) !!}
            </div>
        </div>
        <div style="width:99%;float:left;">
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Costo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('costo', $unItem->costo, ['class' => 'form-control','readonly']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Porc. Inc.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('por_inc', $unItem->por_inc, ['class' => 'form-control','readonly']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('orden', $unItem->orden, ['class' => 'form-control']) !!}
            </div>            
        </div>
        {{-- @can('CREAR-OBRAS') 
            {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
        {{-- @endcan 
        {!! Form::close() !!}
        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',encrypt($laObra->idobra)], 'style' => 'display:inline']) !!}
        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
        {!! Form::close() !!} --}}
    </section>
@endsection
