@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Editar Barrio</h3></div>
        <div class="section-body">        
            {!!Form::model($unbarrio,['method'=>'POST','route'=>['barrio.update',$unbarrio->barrio]])!!}
            <div class="card-body">@include('layouts.modal.mensajes')</div>
            <div style="width:99%;float:left;">
                <div style="width:80%;float:left;margin-left:1%;">
                    {!!Form::label('Nombre:',null,['class'=>'control-label','style'=>'white-space:nowrap;'])!!}
                    {!!Form::text('nombarrio',null,['class'=>'form-control'])!!}
                </div>
                <div style="width:60%;float:left;margin-left:1%;">
                    {!!Form::label('Obra:',null,['class'=>'control-label','style'=>'white-space:nowrap;width:20%;'])!!}
                    {!!Form::select('id_obrBarrio',$Obra,($unbarrio->id_obr==null)?0:$unbarrio->id_obr,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div> 
                <div style="width:30%;float:left;margin-left:1%;">
                    {!!Form::label('Localidad:',null,['class'=>'control-label','style'=>'white-space:nowrap;'])!!}
                    {!!Form::select('id_locBarrio',$Localidad,$unbarrio->id_loc,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>
            </div>
                <div style="width:99%;float:left;">
                    <div style="width:15%;float:left;margin-top:2%;">
                        {!!Form::label('Es uvi:',null,['class'=>'control-label','style'=>'white-space:nowrap;margin-top:2%'])!!}
                        {{Form::radio('uvi','Si',($unbarrio->tipofinan==1)?"checked":"",['style'=>'white-space:nowrap'])}}<span>Si</span>
                        {{Form::radio('uvi','No',($unbarrio->tipofinan==0)?"checked":"",['style'=>'white-space:nowrap'])}}<span>No</span>
                    </div>                    
                    <div style="width:15%;float:left;margin-top:2%;">
                        {!!Form::label('Factura:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {{Form::radio('factura1','Si',($unbarrio->factura==1)?"checked":"",['style'=>'white-space:nowrap'])}}<span>Si</span>
                        {{Form::radio('factura1','No',($unbarrio->factura==0)?"checked":"",['style'=>'white-space:nowrap'])}}<span>No</span>
                    </div>    
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Fec.Entrega:',null,['class'=>'control-label','style'=>'white-space:nowrap;width:10%'])!!}
                        {!!Form::date('fec_entrega',date('Y-m-d',strtotime($unbarrio->fec_entrega)),['id'=>'fec_entrega','class'=>'form-control'])!!}
                    </div>
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Zona:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::select('idzona',['0'=>'0','1'=>'1','2'=>'2','3'=>'3'],$unbarrio->idzona,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                    </div>
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Programa:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::select('Programa',$Programa,$unbarrio->id_programa,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                    </div>
                </div>                
                <div style="width:99%;float:left;margin-top:2%;">
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Tipo Barrio:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::select('tipoBarrio',$Tipo,$unbarrio->idtipbarrio,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                    </div>
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Tipología:',null,['class'=>'control-label','style'=>'white-space: nowrap'])!!}
                        {!!Form::select('idtipologia',$Tipo,$unbarrio->idtipologia,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                    </div>
                    <div style="width:10%;float:left;margin-left:1%;">
                        {!!Form::label('Tipo de Precio:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::select('tipoPrecioBarrio',[0=>'Sin Asignar',1=>'Normal',2=>'Reducido'],$unbarrio->tipoprecio,['placeholder'=>'Seleccionar','class'=>'form-select'])!!}
                </div>            
                <div style="width:99%;float:left;margin-top:2%;">
                    <div style="width:9%;float:left;margin-left:1%;">
                        {!!Form::label('Cta.Banco:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::text('cuentabco',old('cuentabco'),['type'=>'text','class'=>'form-control','placeholder'=>'10384'])!!}
                    </div>                
                    <div style="width:10%;float:left;margin-left:1%;">
                        {!!Form::label('Porc.Finan:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::text('porfin',old('porfin'),['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                    </div>
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Cant. Viv.:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::text('canviv',old('canviv'),['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                    </div>
                    <div style="width:20%;float:left;margin-left:1%;">
                        {!!Form::label('Nro. Resol:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                        {!!Form::text('nro_res',old('nro_res'),['class'=>'form-control'])!!}
                    </div>    
                </div>
            </div>
            <div style="width:99%;float:left;margin-top:2%;">
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('1 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts1',$unbarrio->mts1,['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('2 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts2',$unbarrio->mts2,['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">                    
                    {!!Form::label('3 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts3',$unbarrio->mts3,['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
                <div style="width:10%;float:left;margin-left:1%;">
                    {!!Form::label('4 Dorm:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                    {!!Form::text('mts4',$unbarrio->mts4,['type'=>'text','class'=>'form-control','placeholder'=>''])!!}
                </div>
            </div> 
            <div style="width:99%;float:left;margin-top:2%;">
                @can('CREAR-BARRIO')
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                @endcan                
                <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>
            </div>
            {!!Form::close()!!}                    
        </div>
    </section>
@endsection