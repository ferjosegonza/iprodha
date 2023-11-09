@extends('layouts.app')
@section('content')  
    <section class="section">    
        <div class="section-header"><h3 class="page__heading">Archivos</h3></div>     
        <form method="POST" action="{{route('ob_lic.subir1',['dir'=>$request['dir']])}}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="archivo">            
            <button type="submit" class="btn btn-warning">Subir Archivo</button>                        
        </form>
        <table style="width:50%;" class="table  table-striped mt-2 ">
            <thead style="height:50px;"><th>Archivos subidos:</th><th>Acciones</th></thead>
            @foreach($archivos as $archivo)            
                <?php 
                    $ruta='http://'.$_SERVER['HTTP_HOST']."/iprodha/public/storage/upload/".$request['dir'].'/'.basename($archivo)
                ?>
                <tbody>
                    <tr>
                        <td>
                            <a href="<?php echo$ruta?>" target="_blank">
                                {{basename($archivo)}}
                            </a>
                        </td>
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
        <a class="btn btn-info" href="{{route('ob_lic.index')}}">Volver</a>
    </section>
@endsection