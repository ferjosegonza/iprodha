@extends('layouts.app')
@section('content')    
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>
    <body>
        ABM operatoria        
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-dark">
                    <th>Nombre</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
                <br>
                {{--@can('CREAR-ALUMNOS')--}}
                    {!!Form::open(['method'=>'GET','route'=>['ob_operatoria.create'],'class'=>'d-flex justify-content-evenly'])!!}
                        {!!Form::submit('Nueva',['class'=>'btn btn-warning my-1'])!!}
                    {!!Form::close()!!}
                {{--@endcan--}}
                @foreach($ob_operatorias as $ob_operatoria)
                    <tr>
                        <td>{{$ob_operatoria->operatoria}}</td>                        
                        <td>
                            {{--@can('BORRAR-')--}}
                                {!!Form::open(['method'=>'DELETE','class'=>'formulario','route'=>['ob_operatoria.destroy',$ob_operatoria->id_ope],'style'=>'display:inline'])!!}
                                    {!!Form::submit('Borrar',['class'=>'btn btn-danger'])!!}
                                {!!Form::close()!!}
                            {{--@endcan--}}                            
                                {!!Form::open(['method'=>'GET','route'=>['ob_operatoria.edit',$ob_operatoria->id_ope],'style'=>'display:inline'])!!}
                                    {!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
                                {!!Form::close()!!}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-dark" href="{{route("ob_operatoria.index")}}">Volver al listado</a>    
    </body>
</html>
@endsection