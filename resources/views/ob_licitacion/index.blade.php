@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Licitaciones</h3></div>
        <div class="section-body">
            <div class="">
                <div class="row">
                    @include('layouts.modal.mensajes')
                    <div class="pagination justify-content-end"></div>
                    <div class="col">                        
                        <div class="card  rounded">
                            <div class="card-body  ">
                                <div class="text-nowrap table-responsive">
                                    <a class="btn btn-success" href="">Nuevo</a>
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
                                                    <td>{{$unob_licitacion->año}}</td>
                                                    <td>{{$unob_licitacion->tipo}}</td>                                                    
                                                    <td>
                                                        
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