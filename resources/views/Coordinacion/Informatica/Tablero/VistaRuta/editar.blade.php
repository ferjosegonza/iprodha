@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Vista</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-5">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                        
                        {!! Form::model($vista,['method' => 'PUT', 'route' => ['tab_vista_v.update', $vista->id_tc_vista], 'class' => '']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Alias de la vista:</label>                                    
                                        {!! Form::text('alias', $vista->alias_vista, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nombre de la vista:</label>                                    
                                        {!! Form::text('nombre', $vista->nombre_vista, array('class' => 'form-control')) !!}
                                    </div>
                                </div>   

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Tablero:</label>                                    
                                        {!! Form::select('idtablero', $tableros, $vista->id_tc_tablero, ['class' => 'form-select', 'required']) !!}
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
