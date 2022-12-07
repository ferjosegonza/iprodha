@extends('layouts.app')
@section('content')   
    <section class="section">
        <div class="section-header">
            {{-- Titulo --}}
            <h3 class="page__heading">Carga de Foja</h3> 
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    @include('layouts.modal.mensajes')
                    <div class="card  col-md-12 ">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-dark">
                                            <th colspan=3></th>
                                            <th colspan=4>Avances del mes</th>                                            
                                        </tr>
                                        <tr>
                                            <th style="visibility:collapse;display:none;"></th>
                                            <th>Nro</th>
                                            <th>Descripcion</th>
                                            <th>Monto</th>
                                            <th>Anterior</th>
                                            <th>Del Mes</th>
                                            <th>Acumula</th>
                                            <th>Imp. Parcial</th>                                            
                                        </tr>
                                    </thead>            
                                    <tbody>
                                        <br> 
                                            {!!Form::model($cargarFoja,['method'=>'PATCH','route'=>['cargarfoja.update',$cargarFoja[0]->id_foja]])!!}                                            
                                                @foreach($cargarFoja as $cargarFoja)                            
                                                    <tr>
                                                        <td style="visibility:collapse;display:none;">{!!Form::hidden('id_item'.$cargarFoja->orden,$cargarFoja->id_item,['class'=>'form-control'])!!}</td>
                                                        <td>{{$cargarFoja->orden}}</td>
                                                        <td>{{$cargarFoja->nom_item}}</td>
                                                        <td>{!!Form::text('costo_con'.$cargarFoja->orden,$cargarFoja->costo_con,['class'=>'form-control','id'=>'costo_con'.$cargarFoja->orden,'disabled','align="right"'])!!}</td>
                                                        <td>{!!Form::text('por_ant_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr,['class'=>'form-control','id'=>'por_ant_obr'.$cargarFoja->orden,'disabled','style="width:60px"'])!!}</td>
                                                        <td>{!!Form::text('por_mes_obr'.$cargarFoja->orden,$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_mes_obr'.$cargarFoja->orden,'onchange'=>'acum('.$cargarFoja->orden.')','style="width:60px"'])!!}</td>
                                                        <td>{!!Form::text('por_acu_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr+$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_acu_obr'.$cargarFoja->orden,'readonly','style="width:60px"'])!!}</td>
                                                        <td>{!!Form::text('imp_parcial'.$cargarFoja->orden,0,['class'=>'form-control','id'=>'imp_parcial'.$cargarFoja->orden,'readonly'])!!}</td>                                                        
                                                    </tr>                                                   
                                                @endforeach
                                                {!!Form::hidden('orden',$cargarFoja->orden)!!}                                                
                                                @can('EDITAR-CARGARFOJA')
                                                    {!!Form::submit('Guardar',['class'=>'btn btn-success mr-2'])!!}
                                                @endcan                                                
                                            {!!Form::close()!!}
                                    </tbody>
                                </table>                  
                                <a class="btn btn-dark" href="{{route("cargarfoja.index")}}">Volver al listado</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display:none">
                    <div class="card"><div id='contenido' class="card-body"></div></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="text/JavaScript"> 
        function acum(ord){  
            if(isNaN(document.getElementById('por_mes_obr'+ord).value)){
                alert('Debe ingresar un número');
                document.getElementById('por_mes_obr'+ord).value=0;
                document.getElementById('por_acu_obr'+ord).value=document.getElementById('por_ant_obr'+ord).value;
                document.getElementById('imp_parcial'+ord).value=0;
            }else{
                valor=parseFloat(document.getElementById('por_ant_obr'+ord).value)+parseFloat(document.getElementById('por_mes_obr'+ord).value);
                if(valor<=100){
                    document.getElementById('por_acu_obr'+ord).value=valor;
                    document.getElementById('imp_parcial'+ord).value=parseFloat(document.getElementById('por_mes_obr'+ord).value)/100*parseFloat(document.getElementById('costo_con'+ord).value);
                }else{
                    alert('No puede superar el 100%');
                    document.getElementById('por_mes_obr'+ord).value=0;
                    document.getElementById('por_acu_obr'+ord).value=document.getElementById('por_ant_obr'+ord).value;
                    document.getElementById('imp_parcial'+ord).value=0;
                }
            }
        }        
    </script>
@endsection