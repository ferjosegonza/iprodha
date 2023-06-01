@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Dormitorios x Superficies</h3></div>
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
                                                <select name="candor">
                                                    @foreach($Barrio as $unBarrio)@endforeach
                                                    @if($unBarrio->mts1>0)<option>1</option>@endif
                                                    @if($unBarrio->mts2>0)<option>2</option>@endif
                                                    @if($unBarrio->mts3>0)<option>3</option>@endif
                                                    @if($unBarrio->mts4>0)<option>4</option>@endif                                                
                                                </select>
                                            </div>                                            
                                            <div style="width:10%;float:left;margin-left:1%;">    
                                                {!!Form::label('Terrenos:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                                <select name="idtipoterre">
                                                    @foreach($terrenos as $unTerrenos)                                                        
                                                        <option value="{{$unTerrenos->idtipoterre}}">{{$unTerrenos->superficie}}</option>
                                                    @endforeach                                                                                                    
                                                </select>
                                            </div>                                            
                                            {!!Form::hidden('barrio',$unBarrio->barrio)!!}
                                            <div style="width:10%;float:left;margin-left:1%;">                                                                    
                                                <button type="submit" class="btn btn-primary mr-2">Guardar</button>                
                                                <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>
                                            </div>    
                                        </form>                                                    
                                    </div>
                                    <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                        <thead style="height:50px;">
                                            <th scope="col" style="color:#fff;">Nro. Barrio</th>
                                            <th scope="col" style="color:#fff;width:60%;">Dormitorios</th>
                                            <th scope="col" style="color:#fff;">Superficie Terreno</th>
                                            <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach($BarrioXOrg as$unBarrioXOrg)
                                                <tr>
                                                    <td>{{$unBarrioXOrg->barrio}}</td>
                                                    <td>{{$unBarrioXOrg->candor}}</td>
                                                    <td>{{$unBarrioXOrg->idtipoterre}}</td>                                                                                                        
                                                    <td>                                                      
                                                        @method('DELETE')                                                        
                                                        {!!Form::open([
                                                            'method'=>'DELETE',
                                                            'route'=>['dormXTerr.eliminar',$unBarrioXOrg->barrio,$unBarrioXOrg->candor,$unBarrioXOrg->idtipoterre],
                                                            'style'=>'display:inline'
                                                        ])!!}
                                                        {!!Form::submit('Borrar',[
                                                            'class'=>'btn btn-danger',
                                                            'onclick'=>"return confirm('Estas seguro que desea ELIMINAR el barrio \"" .$unBarrioXOrg->barrio. "\"')",])
                                                        !!}                                                            
                                                        {!!Form::close()!!}                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
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