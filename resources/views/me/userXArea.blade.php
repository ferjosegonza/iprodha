@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Usuarios por Areas</h3></div>
        <form method="post" action="{{route('userXArea.store')}}">
            <div class="card-body">@include('layouts.modal.mensajes')</div>
            @csrf
            @method('POST')
            <table>            
                <tr>
                    <td>                        
                        {!!Form::label('Usuario:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}                                            
                        {!!Form::select('id',$users,null,['class'=>'clase-del-select'])!!}                        
                    </td>
                    <td>                                            
                        {!!Form::label('Area:',null,['class'=>'control-label','style'=>'white-space:nowrap'])!!}                                            
                        {!!Form::select('codare',$areas,null,['class'=>'clase-del-select'])!!}                        
                    </td>
                    <td>                        
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a class="btn btn-info" href="{{route('userXArea.index')}}">Volver</a>                        
                    </td>
                </tr>
            </table>           
        </form>
        <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
            <thead style="height:50px;">
                <th scope="col" style="color:#fff;">Usuario</th>
                <th scope="col" style="color:#fff;width:60%;">Area</th>            
                <th scope="col" style="color:#fff;width:30%;">Acciones</th>
            </thead>
            <tbody>
                @foreach($users_x_areas as$unusers_x_areas)
                    <tr>
                        <td>{{$unusers_x_areas->users->email}}</td>
                        <td>{{$unusers_x_areas->areas->desare}}</td>                    
                        <td>
                            @csrf                                                                                
                            @method('DELETE')                        
                            {!!Form::open([
                                'method'=>'DELETE',
                                'route'=>['userXArea.eliminar',$unusers_x_areas->users->id,$unusers_x_areas->areas->codare],                                
                                'style'=>'display:inline',])
                            !!}
                            {!!Form::submit('Borrar',[
                                'class'=>'btn btn-danger',
                                'onclick'=>"return confirm('Estas seguro que desea ELIMINAR \"" . $unusers_x_areas->email . "\"')",])
                            !!}                                                            
                            {!!Form::close()!!}                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </section>
@endsection