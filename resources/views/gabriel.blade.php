<html>
    <head></head>
    <body>
        ABM operatoria        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ob_operatorias as $ob_operatoria)
                    <tr>
                        <td>{{$ob_operatoria->operatoria}}</td>
                        {{--<td>
                            <a class="btn btn-warning" href="{{route("ob_operatoria.edit",[$ob_operatoria])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{route("ob_operatoria.destroy",[$ob_operatoria])}}" method="post">
                                @method("delete")
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{route("gabriel.index")}}">Volver al listado</a>    
    </body>
</html>