@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <h3 class="titulo my-auto">Asignar sector a almacén</h3>    
            </div>
            <div class="col-lg-5 my-auto">
            </div>
            <div class="col-lg-2 my-auto">
                <a href="{{ route('almacen.index') }}" class="btn btn-dark my-1" Style="width: 80%">Volver</a>
            </div>
        </div>
       @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            {!! Form::open([
                'method' => 'PUT',
                'route' => ['almacen.asignarSector', $almacen->id_almacen],
                'style' => 'display:inline']) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="pb-2">Almacén: {{$almacen->id_almacen}}</h4>
                            <div class="form-group">
                                {!! Form::label('Nombre:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                {!! Form::text('nom_almacen', $almacen->nom_almacen, array('class' => 'form-control', 'readonly'=> 'true','style' => 'disabled')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Abreviatura:</label>                                    
                                {!! Form::text('abr_almacen', $almacen->abr_almacen, array('class' => 'form-control','readonly'=> 'true','style' => 'disabled')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Direccion:</label>                                    
                                {!! Form::text('dom_almacen', $almacen->dom_almacen, array('class' => 'form-control','readonly'=> 'true',   'style' => 'disabled')) !!}
                            </div>
                        </div>
                    </div>  
                </div>     
            </div>
            <div>                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="card ">
                            <div class="card-body">
                                <h4 class="pb-2">Sector:</h4>                                
                                <div class="form-group">
                                    {{ Form::label('Sector', 'Sector:') }}                                    
                                    {{ Form::select('nom_sector', $sectores, 'nom_sector')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('p_almacen.index') }}"class="btn btn-primary fo">Volver</a>
                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mr-2', 'style' => 'width: 40%']) !!}
                    
                    {!! Form::close() !!} 
                </div>
            </div>    
        </div>
    </section>

    
@endsection