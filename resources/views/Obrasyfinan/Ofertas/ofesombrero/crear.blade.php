@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <a><strong>Asociar Concepto Sombrero - Obra: {{ $unaObra->nomobra}} </strong></a>
        </div>
        {!! Form::open(['route' => 'ofesombreroxobra.store', 'method' => 'POST']) !!}
        @include('layouts.modal.mensajes')
        <div style="width:99%;float:left;">
            <div hidden>
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div>
            <div hidden>
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra',  $unaObra->idobra, ['class' => 'form-control']) !!}
            </div>
                {!! Form::label('Concepto :', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::open(array('method'=>'post')) !!}
                @foreach ( $losConceptos as $sombrero => $i ) 
                    <div style="width:70%;'float:left;">
                        {!! Form::checkbox('conceptos[]', $i->idconceptosombrero) !!}
                        {!! Form::label($i->conceptosombrero, $i->conceptosombrero,['class' => 'control-label']) !!}
                        
                        {!! Form::number('valores[]', null, [ 'class' => 'form-control','style' => 'white-space: nowrap;width:20%;']) !!}
                    </div>                    
                @endforeach
                
                {!! Form::close() !!}
                    @can('CREAR-OBRAS')
                @endcan
        {!! Form::submit('Guardar', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
                {!! Form::open(['method' => 'GET', 'route' => ['ofesombreroxobra.indexx',$unaObra->idobra], 'style' => 'display:inline']) !!}
                {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
                {!! Form::close() !!}
                
        </div>
    </section>
@endsection
