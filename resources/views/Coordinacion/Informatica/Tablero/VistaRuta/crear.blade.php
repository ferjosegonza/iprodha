@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Agregar Vista</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-5">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                        
                        {!! Form::open(array('route' => 'tab_vista_v.store','method'=>'POST')) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Alias de la vista:</label>                                    
                                        {!! Form::text('alias', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nombre de la vista:</label>                                    
                                        {!! Form::text('nombre', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>   

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Tablero:</label>                                    
                                        {!! Form::select('idtablero', $tableros, null, ['class' => 'form-select', 'placeholder' => 'Seleccionar..', 'required']) !!}
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
