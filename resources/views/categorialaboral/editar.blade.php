@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Categoria Laboral</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    {!! Form::model($CategoriaLaboral, ['method' => 'PATCH','route' => ['categorialaboral.update', $CategoriaLaboral->id_catlaboral]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Nombre de la Categoria Laboral:</label>                                    
                                    {!! Form::text('nombre', null, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('WEB:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('web', ['1' => 'SI', '0' => 'NO'], null, ['class' => 'form-select']) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Suma Ingreso:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('sumaingreso', ['1' => 'SI', '0' => 'NO'], null, ['class' => 'form-select']) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Datos Laborales:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('datoslaborales', ['1' => 'SI', '0' => 'NO', '3' => 'SIN OPCION'], $CategoriaLaboral->datolab, ['class' => 'form-select']) !!}
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('categorialaboral.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection