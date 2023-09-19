@extends('layouts.app')
@section('content')    
<html>
    <head>        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>
    <body>
        Licitacion
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
                        <td>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>                                
    </body>
@endsection