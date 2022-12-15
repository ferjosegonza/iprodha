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
                                                <?php
                                                    $costo_cont=0;
                                                    $por_ant_obrt=0;
                                                    $por_mes_obrt=0;
                                                    $por_acu_obrt=0;
                                                    $imp_parcialt=0;
                                                    $i=0;
                                                ?>
                                                @foreach($cargarFoja as $cargarFoja)                            
                                                    <tr>
                                                        <td style="visibility:collapse;display:none;">{!!Form::hidden('id_item'.$cargarFoja->orden,$cargarFoja->id_item,['class'=>'form-control'])!!}</td>
                                                        <td>{{$cargarFoja->orden}}</td>
                                                        <td>{{$cargarFoja->nom_item}}</td>
                                                        <td>{!!Form::text('costo_con'.$cargarFoja->orden,$cargarFoja->costo_con,['class'=>'form-control','id'=>'costo_con'.$cargarFoja->orden,'disabled','align="right"'])!!}</td>
                                                        <td>{!!Form::text('por_ant_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr,['class'=>'form-control','id'=>'por_ant_obr'.$cargarFoja->orden,'disabled','style="width:60px"'])!!}</td>
                                                        <td>{!!Form::text('por_mes_obr'.$cargarFoja->orden,$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_mes_obr'.$cargarFoja->orden,'onchange'=>'acum('.$cargarFoja->orden.')','style="width:60px"'])!!}</td>                                                        
                                                        <td>{!!Form::text('por_acu_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr+$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_acu_obr'.$cargarFoja->orden,'readonly','style="width:60px"'])!!}</td>
                                                        <td>{!!Form::text('imp_parcial'.$cargarFoja->orden,round($cargarFoja->costo_con*$cargarFoja->por_mes_obr/100,2),['class'=>'form-control','id'=>'imp_parcial'.$cargarFoja->orden,'readonly'])!!}</td>                                                        
                                                    </tr>    
                                                    <?php                 
                                                        $costo_cont+=$cargarFoja->costo_con;
                                                        $por_ant_obrt+=$cargarFoja->por_ant_obr;
                                                        $por_mes_obrt+=$cargarFoja->por_mes_obr;
                                                        $por_acu_obrt+=$cargarFoja->por_ant_obr+$cargarFoja->por_mes_obr;
                                                        $imp_parcialt+=round($cargarFoja->costo_con*$cargarFoja->por_mes_obr/100,2);
                                                        $i++;
                                                    ?>
                                                @endforeach
                                                <tr>
                                                    <td style="visibility:collapse;display:none;"></td>
                                                    <th></th>
                                                    <th>Totales</th>
                                                    <th>{{$costo_cont}}</th>
                                                    <th>{{$por_ant_obrt}}</th>
                                                    <th>{!!Form::text('por_mes_obrT',$por_mes_obrt,['class'=>'form-control','id'=>'por_mes_obrT','disabled','align="right"'])!!}</th>
                                                    <th>{!!Form::text('por_acu_obrT',$por_acu_obrt,['class'=>'form-control','id'=>'por_acu_obrT','disabled','align="right"'])!!}</th>
                                                    <th>{!!Form::text('imp_parcialT',$imp_parcialt,['class'=>'form-control','id'=>'imp_parcialT','disabled','align="right"'])!!}</th>                                            
                                                </tr>
                                                {!!Form::hidden('orden',$cargarFoja->orden)!!}                                                
                                                @can('EDITAR-CARGARFOJA')
                                                    {!!Form::submit('Guardar',['class'=>'btn btn-success mr-2'])!!}
                                                @endcan            
                                                {!!Form::label('Periodo: '.$cargarFoja->periodo_o)!!}                                                    
                                                {!!Form::hidden('i',$i,['class'=>'form-control','id'=>'i'])!!}                               
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
                    valor1=parseFloat(document.getElementById('por_mes_obr'+ord).value)/100*parseFloat(document.getElementById('costo_con'+ord).value);
                    document.getElementById('imp_parcial'+ord).value=valor1.toFixed(2);                                        
                }else{
                    alert('No puede superar el 100%');
                    document.getElementById('por_mes_obr'+ord).value=0;
                    document.getElementById('por_acu_obr'+ord).value=document.getElementById('por_ant_obr'+ord).value;
                    document.getElementById('imp_parcial'+ord).value=0;
                }
            }
            var mesT=0;
            var acuT=0;
            var impT=0;
            for(var i=1;i<=parseInt(document.getElementById('i').value);i++){
                mesT+=parseInt(document.getElementById('por_mes_obr'+i).value);
                acuT+=parseFloat(document.getElementById('por_acu_obr'+i).value);
                impT+=parseFloat(document.getElementById('imp_parcial'+i).value);
            }                    
            document.getElementById('por_mes_obrT').value=mesT;
            document.getElementById('por_acu_obrT').value=acuT;
            document.getElementById('imp_parcialT').value=impT.toFixed(2);
        }        
    </script>
@endsection