@extends('layouts.app')
@section('content')    
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>
    <body>
        Seleccionar Obra
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-dark">
                    <th>Numero</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
                <br>                
                @foreach($cargarFoja as $cargarFoja)
                    <tr>
                        <td>{{$cargarFoja->num_obr}}</td>                        
                        <td>{{$cargarFoja->nom_obr}}</td>
                        <td>{{$cargarFoja->nom_emp}}</td>
                        <td>
                            {!!Form::open(['method'=>'GET','route'=>['cargarFoja.edit',$cargarFoja->id_obr],'style'=>'display:inline'])!!}
                                {!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
                            {!!Form::close()!!}                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-dark" href="{{route("cargarFoja.index")}}">Volver al listado</a>    
    </body>
</html>
@endsection