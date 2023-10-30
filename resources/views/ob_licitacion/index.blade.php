@extends('layouts.app')
@section('content')    
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Licitacion</h3></div>      
        <a class="btn btn-success float-right" href="{{route('ob_lic.crear')}}">Nuevo</a>
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
                        <td><a class="btn btn-dark" href="{{route('ob_lic.subir',['dir'=>$unob_licitacion->path])}}">Archivo</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>                                
    </section>
@endsection