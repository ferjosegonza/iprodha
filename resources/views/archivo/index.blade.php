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
                <div class="barraBusqueda">
                    {!! Form::open(['method' => 'GET', 'route' => ['archivo.buscar']]) !!}
                    
                    @php
                    $j=0;
                    for($i=date("Y");$i>=1990;$i--){
                        $años[$j]=$i;
                        $j++;          
                    }              
                    @endphp
                    {!! Form::label('Año:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('año', $años, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                   
                    <p id="demo"></p>
                    
                    {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    <select class="form-select" id="tipo" onchange="subtipos()">
                        <option value="" selected>Seleccionar</option>
                        @foreach ($TipoDocumento as $tipo)
                            <option value="{{$tipo->id_tipoarchivo}}">{{$tipo->nombre_corto}}</option>
                        @endforeach                        
                    </select>   
                    
                    <div id="subtipo">
                        
                    </div>
                    


                    {{-- {!! Form::label('Tipo documento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                    {!! Form::select('idtipodocumento', $TipoDocumento, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'id'=>'tipo']) !!} 
                    {!! Form::label('Sub tipo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;', 'hidden'=>'true']) !!}
                        {!! Form::select('idsubtipodocumento', $SubTipoDocumento, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'id'=> 'subtipo', 'OnClientClick'=>"javascript: return subtipos();", 'hidden'=>'true']) !!} 
                    --}}
                    
                    

                    {!! Form::submit('Buscar', ['class' => 'btn btn-success']) !!}
                    
                    {!! Form::close() !!}

                </div>  
                <div class="archivos">
                    
                </div>
            </div>
        </div>
    </section>
    @include('layouts.modal.confirmation') 
@endsection
    
@section('js')
<script src="{{ asset('js/archivos/index.js') }}"></script>
@endsection