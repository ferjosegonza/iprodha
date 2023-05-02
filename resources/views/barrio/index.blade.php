@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Barrios</h3></div>
        <div class="section-body">
            <div class="">
                <div class="row">
                    @include('layouts.modal.mensajes')
                    <div class="pagination justify-content-end">{!!$Barrios->links()!!}</div>
                    <div class="col">                        
                        <div class="card  rounded">
                            <div class="card-body  ">
                                <div class="text-nowrap table-responsive">
                                    <a class="btn btn-success" href="{{route('barrio.crear')}}">
                                        Nuevo
                                    </a>
                                    <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                        <thead style="height:50px;">
                                            <th scope="col" style="color:#fff;">Nro. Barrio</th>
                                            <th scope="col" style="color:#fff;width:60%;">Nombre Barrio</th>
                                            <th scope="col" style="color:#fff;">fecha alta</th>
                                            <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach($Barrios as$unbarrio)
                                                <tr>
                                                    <td>{{$unbarrio->barrio}}</td>
                                                    <td>{{$unbarrio->nombarrio}}</td>
                                                    <td>{{date("d/m/Y",strtotime($unbarrio->fecha_alta))}}</td>                                                    
                                                    <td>
                                                        @csrf                                                        
                                                        @can('EDITAR-BARRIO')
                                                            <a class="btn btn-info" href="{{route('barrio.editar',$unbarrio)}}">
                                                                Editar
                                                            </a>
                                                        @endcan
                                                        @can('VER-BARRIO')
                                                            <a class="btn btn-info" href="{{route('barrio.verCostos',$unbarrio)}}">
                                                                Costos
                                                            </a>
                                                        @endcan                                                        
                                                        @method('DELETE')
                                                        @can('BORRAR-BARRIO')
                                                            {!!Form::open([
                                                                'method'=>'DELETE',
                                                                'route'=>['barrio.eliminar',$unbarrio->barrio],
                                                                'style'=>'display:inline',])
                                                            !!}
                                                            {!!Form::submit('Borrar',[
                                                                'class'=>'btn btn-danger',
                                                                'onclick'=>"return confirm('Estas seguro que desea ELIMINAR el barrio \"" . $unbarrio->nombarrio . "\"')",])
                                                            !!}                                                            
                                                            {!!Form::close()!!}
                                                        @endcan
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