@extends('layouts.app')
@section('content')    
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Licitacion</h3></div> 
        @can('CREAR-OB_LIC')     
            <a class="btn btn-success float-right" href="{{route('ob_lic.crear')}}">Nuevo</a>
        @endcan
        <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
            <thead style="height:50px;">
                <th scope="col" style="color:#fff;">Nro.</th>
                <th scope="col" style="color:#fff;width:60%;">Denominacion</th>
                <th scope="col" style="color:#fff;">Apertura</th>
                <th scope="col" style="color:#fff;">Año</th>
                <th scope="col" style="color:#fff;">Tipo</th>
                <th scope="col" style="color:#fff;width:30%;">Acciones</th>
            </thead>
            <tbody>
                @foreach($ob_licitacion as$unob_licitacion)
                    <tr>
                        <td>{{$unob_licitacion->numero}}</td>
                        <td>{{$unob_licitacion->denominacion}}</td>
                        <td>{{date("d/m/Y",strtotime($unob_licitacion->apertura))}}</td>                                                    
                        <td>{{$unob_licitacion->aÑo}}</td>
                        <td>{{$unob_licitacion->descripcion}}</td> 
                        @can('EDITAR-OB_LIC')                                                   
                            <td><a class="btn btn-dark" href="{{route('ob_lic.subir',['dir'=>$unob_licitacion->path])}}">Archivos</a></td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>                                
    </section>
@endsection