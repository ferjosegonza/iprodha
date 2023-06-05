@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Dormitorios x Superficies</h3></div>
        @foreach($Barrio as $unBarrio)@endforeach
        <div class="section-header"><h3 class="page__heading">{{$unBarrio->barrio}}: {{$unBarrio->nombarrio}}</h3></div>
        <div class="section-body">
            <div class="">
                <div class="row">
                    @include('layouts.modal.mensajes')
                    <div class="pagination justify-content-end"></div>
                    <div class="col">                        
                        <div class="card  rounded">
                            <div class="card-body  ">
                                <div class="text-nowrap table-responsive">                                    
                                    <div style="width:99%;float:left;margin-top:2%;">
                                        <form method="post" action="{{route('dormXTerr.store')}}">                                            
                                            @csrf
                                            @method('POST')
                                            <div style="width:10%;float:left;margin-left:1%;">
                                                {!!Form::label('Dormitorios:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                                @foreach($Barrio as $unBarrio)@endforeach
                                                @php $cadena='';@endphp
                                                @if($unBarrio->mts1>0)@php $cadena='<option>1</option>';@endphp @endif
                                                @if($unBarrio->mts2>0)@php $cadena.='<option>2</option>';@endphp @endif
                                                @if($unBarrio->mts3>0)@php $cadena.='<option>3</option>';@endphp @endif
                                                @if($unBarrio->mts4>0)@php $cadena.='<option>4</option>';@endphp @endif                                                
                                                <select name="candor">
                                                    @php 
                                                        if(strlen($cadena)>18){echo'<option>Todos</option>';}
                                                        echo$cadena;                                  
                                                    @endphp                                                                  
                                                </select>
                                                {!!Form::label('Superficie Terreno:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                                <select name="idtipoterre">
                                                    @if(count($terrenos)>1)<option>Todos</option>@endif
                                                    @foreach($terrenos as $unTerrenos)                                                        
                                                        <option value="{{$unTerrenos->idtipoterre}}">{{$unTerrenos->superficie}}</option>
                                                    @endforeach                                                                                                    
                                                </select>
                                                {!!Form::label('Conceptos:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                                <select name="id_concosto">                                                    
                                                    <option value="1">VIVIENDA</option>                                                    
                                                    <option value="2">TERRENO</option>
                                                    <option value="3">INFRAESTRUCTURA</option>
                                                    <option value="4">NEXO</option>
                                                    <option value="6">SUBSIDIO</option>
                                                </select> 
                                                {!!Form::label('Importe:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                                <input type="text" name="importe" value="0"/>
                                                {!!Form::hidden('barrio',$unBarrio->barrio)!!}                                            
                                                <button type="submit" class="btn btn-primary mr-2">Guardar</button>                
                                                <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>
                                            </div>    
                                        </form>                                                    
                                    </div>
                                    <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                        <thead style="height:50px;">
                                            <th scope="col" style="color:#fff">Dormitorios</th>
                                            <th scope="col" style="color:#fff">Superficie Terreno (mts)</th>
                                            <th scope="col" style="color:#fff">Concepto</th>
                                            <th scope="col" style="color:#fff">Importe</th>
                                            <th scope="col" style="color:#fff">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $dor=0;
                                                $ter=0;
                                                $imp=0;
                                            @endphp
                                            @foreach($Fc_concosxbarrio as$unFc_concosxbarrio)                                                
                                                @if($dor==0)
                                                    @php
                                                        $dor=$unFc_concosxbarrio->cantdorm;
                                                        $ter=$unFc_concosxbarrio->idtipoterre;
                                                    @endphp
                                                @endif
                                                @if($dor!=$unFc_concosxbarrio->cantdorm or $ter!=$unFc_concosxbarrio->idtipoterre)
                                                    <tr>
                                                        <td></td><td></td>
                                                        <td class="p-3 mb-2 bg-warning text-dark">Total</td>
                                                        <td>$ @php echo number_format($imp,2,',','.');@endphp</td>
                                                    </tr>
                                                    @php
                                                        $dor=$unFc_concosxbarrio->cantdorm;
                                                        $ter=$unFc_concosxbarrio->idtipoterre;
                                                        $imp=0;
                                                    @endphp                                                    
                                                @endif                                                
                                                <tr>
                                                    <td>{{$unFc_concosxbarrio->cantdorm}}</td>
                                                    <td>{{$unFc_concosxbarrio->superficie}}</td>                                                                                                        
                                                    <td>{{$unFc_concosxbarrio->concosto}}</td>
                                                    <td>$ {{number_format($unFc_concosxbarrio->importe*$unFc_concosxbarrio->sumaoresta,2,',','.')}}</td>
                                                    <td>                                                      
                                                        @method('DELETE')                                                        
                                                        {!!Form::open([
                                                            'method'=>'DELETE',
                                                            'route'=>[
                                                                'dormXTerr.eliminar',
                                                                $unFc_concosxbarrio->barrio,
                                                                $unFc_concosxbarrio->cantdorm,
                                                                $unFc_concosxbarrio->idtipoterre,
                                                                $unFc_concosxbarrio->id_concosto
                                                            ],
                                                            'style'=>'display:inline'
                                                        ])!!}
                                                        {!!Form::submit('Borrar',[
                                                            'class'=>'btn btn-danger',
                                                            'onclick'=>"return confirm('Estas seguro que desea ELIMINAR el barrio \"" .$unFc_concosxbarrio->barrio. "\"')",])
                                                        !!}                                                            
                                                        {!!Form::close()!!}                                                        
                                                    </td>
                                                </tr>  
                                                @php $imp+=$unFc_concosxbarrio->importe*$unFc_concosxbarrio->sumaoresta;@endphp                                              
                                            @endforeach
                                            <tr>
                                                <td></td><td></td>
                                                <td class="p-3 mb-2 bg-warning text-dark">Total</td>
                                                <td>$ @php echo number_format($imp,2,',','.');@endphp</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection