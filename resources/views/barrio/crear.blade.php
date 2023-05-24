
@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Barrios</h3></div>
        <form method="post" action="{{route('barrio.store')}}">
            <div class="card-body">@include('layouts.modal.mensajes')</div>
            @csrf
            @method('POST')
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:30%;float:left;margin-left:1%;">
                    {!!Form::label('Nombre:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('nombarrio',old('nombarrio'),['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>                
                <div style="width:30%;float:left;margin-left:1%;">
                    {!!Form::label('Localidad:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    <br>
                    {!!Form::select('id_loc',$Localidad,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>            
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Es uvi:',null,['class'=>'control-label','style'=>'white-space:nowrap;margin-left:1%'])!!}
                    {{Form::radio('tipofinan','Si',true,['style'=>'white-space:nowrap'])}}<span>Si</span>
                    {{Form::radio('tipofinan','No',false,['style'=>'white-space:nowrap'])}}<span>No</span>
                    &nbsp;&nbsp;&nbsp;                
                    {!!Form::label('Factura:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {{Form::radio('factura','Si',true,['style'=>'white-space:nowrap'])}}<span>Si</span>
                    {{Form::radio('factura','No',false,['style'=>'white-space:nowrap'])}}<span>No</span>
                </div>
                
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Obra:',null,['class'=>'control-label','style'=>'white-space:nowrap;width:20%']) !!}
                    {!!Form::select('id_obr',$Obra,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>                
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Fec.Entrega:',null,['class'=>'control-label','style'=>'white-space:nowrap;width:10%'])!!}
                    {!!Form::date('fec_entrega',date('Y-m-d'),['id'=>'fec_entrega','class'=>'form-control'])!!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Zona:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    <br>
                    {!!Form::select('idzona',['0'=>'0','1'=>'1','2'=>'2','3'=>'3'],['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Programa:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    <br>
                    {!!Form::select('id_programa',$Programa,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Tipo Barrio:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::select('idtipBarrio',$Tipo,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Tipología:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::select('idtipologia',$Tipologia,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('Tipo de Precio:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::select('tipoPrecio',[0=>'Sin Asignar',1=>'Normal',2=>'Reducido'],['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>                
            </div>            
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('Cta. Banco:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('cuentabco','',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>                
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('Porc. Finan:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('porfin','',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Cant. Viv.:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('canviv','',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:20%;float:left;margin-left:1%;">
                    {!!Form::label('Nro. Resol:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('nro_res','',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div> 
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('1 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts1','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('2 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts2','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">                    
                    {!!Form::label('3 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts3','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('4 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts4','0',['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
            </div>                
            <div style="width:99%;float:left;margin-top:2%;">
                @can('CREAR-BARRIO')
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                @endcan
                <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>            
            </div>
        </form>            
    </section>
@endsection