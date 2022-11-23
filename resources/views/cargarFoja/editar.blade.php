@extends('layouts.app')
@section('content')    
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>
    <body>
        Carga de Foja           
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-dark"><th colspan=4></th><th colspan=3>Avances del mes</th></tr>
                <tr>
                    <th></th>
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
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
                <br> 
                    {!!Form::model($cargarFoja,['method'=>'PATCH','route'=>['cargarFoja.update',$cargarFoja[0]->id_foja]])!!}                                            
                        @foreach($cargarFoja as $cargarFoja)                            
                            <tr>
                                <td>{!!Form::hidden('id_item'.$cargarFoja->orden,$cargarFoja->id_item,['class'=>'form-control'])!!}</td>
                                <td>{{$cargarFoja->orden}}</td>
                                <td>{{$cargarFoja->nom_item}}</td>
                                <td>{!!Form::text('costo_con'.$cargarFoja->orden,$cargarFoja->costo_con,['class'=>'form-control','id'=>'costo_con'.$cargarFoja->orden,'disabled'])!!}</td>
                                <td>{!!Form::text('por_ant_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr,['class'=>'form-control','id'=>'por_ant_obr'.$cargarFoja->orden,'disabled'])!!}</td>
                                <td>{!!Form::text('por_mes_obr'.$cargarFoja->orden,$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_mes_obr'.$cargarFoja->orden,'onchange'=>'acum('.$cargarFoja->orden.')'])!!}</td>
                                <td>{!!Form::text('por_acu_obr'.$cargarFoja->orden,$cargarFoja->por_ant_obr+$cargarFoja->por_mes_obr,['class'=>'form-control','id'=>'por_acu_obr'.$cargarFoja->orden,'readonly'])!!}</td>
                                <td>{!!Form::text('imp_parcial'.$cargarFoja->orden,0,['class'=>'form-control','id'=>'imp_parcial'.$cargarFoja->orden,'readonly'])!!}</td>
                            </tr>                                                   
                        @endforeach
                        {!!Form::hidden('orden',$cargarFoja->orden)!!}
                        {!!Form::submit('Guardar',['class'=>'btn btn-success mr-2'])!!}
                    {!!Form::close()!!}
            </tbody>
        </table>                  
        <a class="btn btn-dark" href="{{route("cargarFoja.index")}}">Volver al listado</a>    
    </body>
</html>
@endsection
<script type="text/JavaScript"> 
    function acum(ord){        
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
</script>