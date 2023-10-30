@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Licitacion</h3></div>
        <form method="post" action="{{route('ob_lic.store')}}">
            <div class="card-body">@include('layouts.modal.mensajes')</div>
            @csrf
            @method('POST')
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:30%;float:left;margin-left:1%;">
                    {!!Form::label('Denominación:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('denominacion',old('denominacion'),['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div> 
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('Numero:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('numero','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>               
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('Año:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('año','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div> 
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Apertura:',null,['class'=>'control-label','style'=>'white-space:nowrap;width:10%'])!!}
                    {!!Form::date('apertura',date('Y-m-d'),['id'=>'apertura','class'=>'form-control'])!!}
                </div>  
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Tipo:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}                    
                    <br>
                    {!!Form::select('id_tipolic',$ob_tipo_licitacion)!!}                    
                </div>  
                <div style="width:30%;float:left;margin-left:1%;">
                    {!!Form::label('Path:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('path',old('path'),['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>           
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                @can('CREAR-LICITACION')
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                @endcan
                <a class="btn btn-info" href="{{route('ob_lic.index')}}">Volver</a>
            </div>
        </form>
    </section>
@endsection