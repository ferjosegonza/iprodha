@extends('layouts.app')

@section('content')  
    <section class="section">
        <div class="section-header">
            <div class="titulo page__heading">Búsqueda de Archivos Digitalizados</div>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
            </div>
            <div class="row">
                <div class="card buscador columnaGrande">                    
                    {!!Form::open([
                        'method' => 'GET',
                        'route' => ['archivo.buscar', encrypt($data->idobra)],
                        'class' => 'formulario',
                        'style' => 'display:inline',
                        'files'=>'true']) !!}
                    
                </div>
                <div class="card pdf columnaChica"> 

                </div>
            

            </div>
        </div>  
    </section>
@endsection