@extends('layouts.app')
@section('content')  
    <section class="section">    
        <div class="section-header"><h3 class="page__heading">Archivos</h3></div>     
        <form method="POST" action="{{route('ob_lic.subir1',['dir'=>$request['dir']])}}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="archivo"> 
            <br><br>
            <b>Subir en: {{$request['dir']}}</b><input type="text" name="SUB" />            
            <button type="submit" class="btn btn-warning">Subir Archivo</button>                        
        </form>
        <table style="width:50%;" class="table  table-striped mt-2 ">
            <thead style="height:50px;"><th>Archivos subidos a: {{$request['dir']}}</th><th>Acciones</th></thead>
            @foreach($archivos as $archivo)            
                <?php $ruta='http://'.$_SERVER['HTTP_HOST']."/storage/upload/".$request['dir'].'/'.basename($archivo)?>
                <tbody>
                    <tr>
                        <td><a href="<?php echo$ruta?>" target="_blank">{{basename($archivo)}}</a></td>
                        <td>
                            @method('DELETE')                                                        
                            {!!Form::open([
                                'method'=>'DELETE',
                                'route'=>['ob_lic.destroy',['dir'=>$request['dir'].'/'.basename($archivo)]],
                                'style'=>'display:inline'
                            ])!!}
                            {!!Form::submit('Borrar',[
                                'class'=>'btn btn-danger',
                                'onclick'=>"return confirm('Estas seguro que desea ELIMINAR')",])
                            !!}                                                            
                            {!!Form::close()!!}                            
                        </td>
                    </tr>
                </tbody>
            @endforeach        
        </table> 
        <?php for($i=0;$i<count($subCarpetas);$i++){?>
            <table style="width:50%;" class="table  table-striped mt-2 ">
                <thead style="height:50px;"><th>Archivos subidos a: <?php echo str_replace('\\','/',$request['dir'].$subCarpetas[$i])?></th><th>Acciones</th></thead>
                <?php for($j=0;$j<count($subArchivos[$i]);$j++){?>                                
                    <?php $ruta='http://'.$_SERVER['HTTP_HOST']."/storage/upload/".$request['dir'].$subCarpetas[$i].'/'.basename($subArchivos[$i][$j])?>
                    <tbody>
                        <tr>
                            <td><a href="<?php echo$ruta?>" target="_blank">{{basename($subArchivos[$i][$j])}}</a></td>
                            <td>
                                @method('DELETE')                                                        
                                {!!Form::open([
                                    'method'=>'DELETE',
                                    'route'=>['ob_lic.destroy',['dir'=>$request['dir'].$subCarpetas[$i].'/'.basename($subArchivos[$i][$j])]],
                                    'style'=>'display:inline'
                                ])!!}
                                {!!Form::submit('Borrar',[
                                    'class'=>'btn btn-danger',
                                    'onclick'=>"return confirm('Estas seguro que desea ELIMINAR')",])
                                !!}                                                            
                                {!!Form::close()!!}                            
                            </td>
                        </tr>
                    </tbody>
                <?php }?>
            </table>     
        <?php }?>
        <a class="btn btn-info" href="{{route('ob_lic.index')}}">Volver</a>
    </section>
@endsection