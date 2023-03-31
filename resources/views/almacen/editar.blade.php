
@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Almacen</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">         
                        {{--$almacen=p_Almacen::find($id_almacen)--}}        
                        <h1>Almacén: {{$almacen->id_almacen}}</h1> 
                        {!! Form::model($almacen, ['method' => 'PATCH','route' => ['almacen.update', $almacen->id_almacen]]) !!}                     
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Nombre del almacén:</label>               
                                    {!! Form::text('nom_almacen', $almacen->nom_almacen, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Abreviatura del almacén:</label>                                    
                                    {!! Form::text('abr_almacen', $almacen->abr_almacen, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Domicilio del almacén:</label>                                    
                                    {!! Form::text('dom_almacen', $almacen->dom_almacen, array('class' => 'form-control')) !!}
                                </div>                                
                            </div>       
                        </div>
                        <a href="{{ route('almacen.index') }}"class="btn btn-primary fo">Volver</a>
                        <button type="submit" class="btn btn-success mr-2">Guardar</button>                        
                        {!! Form::close() !!} 
                    </div> 
                </div>
            </div>
        </div>
    </section>
@endsection