@extends('layouts.app')
@section('content')  
    <section class="section">    
        <div class="section-header"><h3 class="page__heading">Subir</h3></div>     
        <form method="POST" action="{{route('ob_lic.subir1',['dir'=>$request['dir']])}}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="archivo">            
            <button type="submit" class="btn btn-warning">Subir Archivo</button>
        </form>
        <a class="btn btn-info" href="{{route('ob_lic.index')}}">Volver</a>
    </section>
@endsection