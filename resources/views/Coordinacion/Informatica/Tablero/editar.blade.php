@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Tablero</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-5">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                        
                        {!! Form::model($tablero,['method' => 'PUT', 'route' => ['tab_vista.update', $tablero->id_tc_tablero], 'class' => '']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nombre del tablero:</label>                                    
                                        {!! Form::text('nombre_tablero', $tablero->nombre_tablero, array('class' => 'form-control', 'style'=>'text-transform:uppercase;')) !!}
                                    </div>
                                </div>       
                            </div>
                            <button type="submit" class="btn btn-success mr-2">Guardar</button>
                            <a href="{{ route('tab_vista.index') }}"class="btn btn-danger">Volver</a>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
