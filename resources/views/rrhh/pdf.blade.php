<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <h4>Información del Agente</h4>
    <div class="row">
        <div class=" col-lg-2"> 
            <label for="dni2" class="control-label">DNI</label>
            <input type="text" id="dni2" class="form-control" disabled value="{{$dni}}">                              
        </div>
        <div class=" col-lg-2"> 
            <label for="nombre" class="control-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" disabled value="{{$nombre}}">                              
        </div>
        <div class=" col-lg-2"> 
            <label for="apellido" class="control-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" disabled value="{{$apellido}}">       
        </div>
        <div class="col-lg-2">
            <label for="agrupamiento" class="control-label">Agrupamiento</label>
            <input type="text" id="agrupamiento" class="form-control" disabled value="{{$agrupamiento}}">
        </div>
        <div class="col-lg-2">
            <label for="categoria" class="control-label">Categoria</label>
            <input type="text" id="categoria" class="form-control" disabled value="{{$categoria}}">
        </div>
    </div>    
    <hr>
    <h5>Historial del Agente</h5>                                
    <table id="historial" style="width: 100%"> 
        <thead>
            <th>Fecha</th>
            <th>Novedad</th>
            <th>Archivo</th>
            <th>Observacion</th>
        </thead>
        <tbody>
            @for ($i=0; $i<sizeof($historial); $i=$i+4)
                <tr>
                    <td>{{$historial[$i]}}</td>
                    <td>{{$historial[$i+1]}}</td>
                    <td>{{$historial[$i+2]}}</td>
                    <td>{{$historial[$i+3]}}</td>
                </tr>
            @endfor
            
        </tbody>
    </table>             
</body>
</html>