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
                                                {!!Form::label('Superficie:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}
                                            </div>
                                            <div style="width:10%;float:left;margin-left:1%;">    
                                                {!!Form::text('superficie','0',['type'=>'text','class'=>'form-control'])!!}
                                                {!!Form::hidden('barrio',$unBarrio)!!}
                                            </div>                                            
                                            <div style="width:10%;float:left;margin-left:1%;">                                                                    
                                                <button type="submit" class="btn btn-primary mr-2">Guardar</button>                
                                                <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>
                                            </div>    
                                        </form>                                                    
                                    </div>
                                    <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                        <thead style="height:50px;">
                                            <th scope="col" style="color:#fff;">Nro. Barrio</th>
                                            <th scope="col" style="color:#fff;width:60%;">Terreno</th>
                                            <th scope="col" style="color:#fff;">Superficie</th>
                                            <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach($terrenos as$unTerreno)
                                                <tr>
                                                    <td>{{$unTerreno->barrio}}</td>
                                                    <td>{{$unTerreno->idtipoterre}}</td>
                                                    <td>{{$unTerreno->superficie}}</td>                                                    
                                                    <td>                                                      
                                                        @method('DELETE')                                                        
                                                        {!!Form::open([
                                                            'method'=>'DELETE',
                                                            'route'=>['dormXTerr.eliminar',$unTerreno->barrio,$unTerreno->idtipoterre],
                                                            'style'=>'display:inline'
                                                        ])!!}
                                                        {!!Form::submit('Borrar',[
                                                            'class'=>'btn btn-danger',
                                                            'onclick'=>"return confirm('Estas seguro que desea ELIMINAR el barrio \"" .$unTerreno->superficie. "\"')",])
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