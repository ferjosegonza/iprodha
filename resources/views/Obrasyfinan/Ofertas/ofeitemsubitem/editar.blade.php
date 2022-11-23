@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <a><strong>Edición Subitem - Item: {{$unItem->nom_item}}</strong></a>
        </div>
        @include('layouts.modal.mensajes')
        {!! Form::model($unItem, ['method' => 'PATCH', 'route' => ['ofeobraitemdet.actualizar',$unSubItem->iditem, $unSubItem->idsubitem]]) !!}
        <div style="width:99%;float:left;">


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
                {!! Form::text('idsubitem', $unSubItem->idsubitem, ['readonly','class' => 'form-control']) !!}
            </div>
            <div style="width:45%;float:left;margin-left:1%;">
                {!! Form::label('Denominacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('denominacion', $unSubItem->denominacion, [
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
                {!! Form::select('idunidad', $lasUnidades, $unSubItem->idunidad, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Cantidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('cantidad',$unSubItem->cantidad, ['class' => 'form-control']) !!}
            </div>
            <div style="width:15%;float:left;margin-left:1%;">
                {!! Form::label('Costo Unitario:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('costounitario', $unSubItem->costounitario, ['class' => 'form-control']) !!}
            </div>            
        </div>
            
        @can('CREAR-OBRAS')
        {!! Form::submit('Guardar', ['class' => 'btn btn-warning mt-3 ']) !!}
        @endcan
        {!! Form::close() !!}
        {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitemdet.detalleitem',$unItem], 'style' => 'display:inline']) !!}
        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
        {!! Form::close() !!}
    </section>
@endsection
