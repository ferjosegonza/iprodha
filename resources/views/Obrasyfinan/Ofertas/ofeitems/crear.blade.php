@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta Item: {{$laObra->nomobra}}</h3>
        </div>
        {!! Form::open(['route' => 'ofeobraitems.store', 'method' => 'POST']) !!}
        @include('layouts.modal.mensajes')
        <div style="width:99%;float:left;">
            <div style="width:10%;float:left;margin-left:1%;">
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra', $laObra->idobra, ['class' => 'form-control' ]) !!}
            </div>
            <div style="width:10%;float:left;margin-left:1%;">
                {!! Form::label('Id Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::text('iditem', DB::table('iprodha.ofe_item')->max('iditem')+1, ['class' => 'form-control']) !!}
            </div>            
            <div style="width:45%;float:left;margin-left:1%;">
                {!! Form::label('Nom. Item:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('nom_item', null, [
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
                {!! Form::text('costo', null, ['class' => 'form-control']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Porc. Inc.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('por_inc', null, ['class' => 'form-control']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('orden', null, ['class' => 'form-control']) !!}
            </div>            
        </div>
            
        @can('CREAR-OBRAS')
            {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
        @endcan
        {!! Form::close() !!}
        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',$laObra->idobra], 'style' => 'display:inline']) !!}
        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
        {!! Form::close() !!}
    </section>
@endsection
