@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Registro Trigger</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                <div class="card">
                    <div class="card-body">         

                    {!! Form::open(array('route' => 'regtrigger.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">ESQUEMA ORIGEN:</label>                                    
                                    {!! Form::text('esquema', null, array('class' => 'form-control','style' => 'text-transform:uppercase', 'required')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">TABLA ORIGEN:</label>                                    
                                    {!! Form::text('tabla', null, array('class' => 'form-control','style' => 'text-transform:uppercase', 'required')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">ESQUEMA DE LOGS:</label>                                    
                                    {!! Form::text('logesquema', null, array('class' => 'form-control','style' => 'text-transform:uppercase', 'required')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">TABLA DE LOGS:</label>                                    
                                    {!! Form::text('logtabla', null, array('class' => 'form-control','style' => 'text-transform:uppercase', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">OBSERVACION:</label>
                                    {!! Form::textarea('observ', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh; text-transform:uppercase;', 'required']) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('TAREA:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('tarea', $Tareas, null, ['class' => 'form-select', 'required']) !!}
                                </div>
                            </div>     
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="{{ route('regtrigger.index') }}"class="btn btn-dark fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
