@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Alta Item: {{$laObra->nomobra}}</div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div hidden>
                                @if(Auth::user()->hasRole('EMPRESA'))
                                {{ $editaTodo='disabled'}}
                                @else
                                {{ $editaTodo='enabled' }} 
                                @endif
                            </div>
                            {!! Form::open(['route' => 'ofeobraitems.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('cod_tipo', $tipoItem,
                                        null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Nom. Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nom_item', null, [
                                            'class' => 'form-control',
                                            'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()']) !!}
                                    </div>        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Costo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('costo', 0, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Porc. Inc.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('por_inc', 0, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('orden', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group" hidden>
                                        {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('idobra', $laObra->idobra, ['class' => 'form-control','readonly' ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto my-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @if ($laObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta', base64url_encode($laObra->idobra)], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary']) !!}
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
