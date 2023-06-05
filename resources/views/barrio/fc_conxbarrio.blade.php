@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Detalle Cuota</h3></div>
        @foreach($Barrio as$unBarrio)@endforeach
        <div class="section-header"><h3 class="page__heading">{{$unBarrio->barrio}}: {{$unBarrio->nombarrio}}</h3></div>        
        <div class="section-body">
            <div class="">
                <div class="row">
                    @include('layouts.modal.mensajes')
                    <div class="pagination justify-content-end"></div>
                    <div class="col">                        
                        <div class="card  rounded">
                            <div class="card-body  ">
                            <a class="btn btn-info" href="{{route('barrio.index')}}">Volver</a>
                                <div class="text-nowrap table-responsive">                                                                        
                                    <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                        <thead style="height:50px;">
                                            <th scope="col" style="color:#fff">Concepto</th>
                                            <th scope="col" style="color:#fff">Porcentaje</th>                                            
                                        </thead>
                                        <tbody>
                                            @foreach($fc_conxbarrio as$unFc_conxbarrio)
                                                <tr>
                                                    <td>{{$unFc_conxbarrio->nomconcepto}}</td>
                                                    <td>{{$unFc_conxbarrio->valor}}</td>                                                                                                        
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