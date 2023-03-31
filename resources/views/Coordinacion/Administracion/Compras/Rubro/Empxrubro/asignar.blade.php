@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            {{-- <h3 class="page__heading">Empresa - Rubro - Asignar</h3> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <h3 class="titulo my-auto">Empresa - Rubro - Asignar</h3>    
            </div>
            <div class="col-lg-5 my-auto">
            </div>
            <div class="col-lg-2 my-auto">
                <a href="{{ route('rubros.empresa') }}" class="btn btn-dark my-1" Style="width: 80%">Volver</a>
            </div> 
            {{-- {{$rubrosAsignadosLista}} --}}
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="pb-2">Empresa:</h4>
                            <div class="form-group">
                                {!! Form::label('CUIT:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                {!! Form::number('nom_emp', $empresa->cuit, array('class' => 'form-control','style' => 'text-transform:uppercase', 'disabled')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Nombre:</label>                                    
                                {!! Form::text('nom_emp', $empresa->nom_emp, array('class' => 'form-control','style' => 'text-transform:uppercase', 'disabled')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Direccion:</label>                                    
                                {!! Form::text('nom_emp', $empresa->direccion, array('class' => 'form-control','style' => 'text-transform:uppercase', 'disabled')) !!}
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="pb-2">Rubros:</h4>
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 my-auto">
                                    {{-- {!! Form::label('Buscar:', null, ['class' => 'control-label me-2']) !!} --}}
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                                    <input id="buscarubro" name="name" type="text" class="form-control" placeholder="Buscar Rubro" aria-label="Recipient's username" aria-describedby="button-addon2">
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 my-auto">
                                    {!! Form::submit('Buscar', ['class' => 'btn btn-primary mr-2']) !!}
                                </div>
                            </div>
                            <div class="row pt-3">
                                <h6>Seleccione los rubros que tiene la empresa:</h6>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-row align-items-start justify-content-around mb-3">
                                    <div class="card-body ms-2 d-flex flex-column" style="height: 250px;width:50%">
                                        <div class="">
                                            <label>Rubros:</label>
                                        </div>
                                        <div id="rubrosParaAsignar" class="d-flex flex-column overflow-auto" style="height: 225px;">
                                            @foreach($rubros as $rubro)
                                                @php
                                                    $bandera = array_search($rubro->id, $listaRubros);
                                                    // if(empty($listaRubros) || $bandera == true){
                                                    //     $bandera = -1;
                                                    // }
                                                    // echo($bandera);
                                                    if(in_array($rubro->id, $listaRubros)){
                                                        $bandera = true;
                                                    }else{
                                                        $bandera = false;
                                                    }

                                                @endphp
                                                
                                                @if ($bandera)
                                                    <label id='{{$rubro->id}}'><input checked onclick="agregarRubro('{{$rubro->id}}','{{$rubro->rubro}}')" class="radiockeck{{$rubro->id}}" name="" type="checkbox" value="{{$rubro->id}}"> {{$rubro->rubro}} </label>
                                                @else
                                                    <label id='{{$rubro->id}}'><input onclick="agregarRubro('{{$rubro->id}}','{{$rubro->rubro}}')" class="radiockeck{{$rubro->id}}" name="" type="checkbox" value="{{$rubro->id}}"> {{$rubro->rubro}} </label>
                                                @endif
                                                
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="card me-3  mt-3 " style="background-color: rgb(255, 255, 255);height: 225px; width:100% ">
                                        <h6 class="card-title ms-4 mt-4 pb-0 mb-2">Rubros Asignados</h6>
                                        {!! Form::open([
                                            'method' => 'GET',
                                            'route' => ['rubros.show', $empresa->id_emp],
                                            'style' => 'display:inline',
                                            'class' => 'validar'
                                        ]) !!}
                                        <div class="overflow-auto">
                                            <div class="card-body d-flex flex-column pt-0" id="rubrosAsignados">
                                                @foreach($rubrosAsignados as $rubroAsignado)
                                                    <label id="rub{{$rubroAsignado->id}}"><input checked onclick="eliminarRubro('{{$rubroAsignado->id}}')" class="ru{{$rubroAsignado->id}}" name="rubros[]" type="checkbox" value="{{$rubroAsignado->id}}"> {{$rubroAsignado->rubro}}</label> 
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success m-auto', 'style' => 'width: 40%']) !!}
                                        {!! Form::close() !!} 
                            </div>
                        </div>
                    </div>  
                </div>     
            </div>
        </div>
    </section>

    <script src="{{ asset('js/Coordinacion/Administracion/Compras/Rubro/asignar_rubro.js') }}"></script>

    
@endsection