@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Tarea</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         

                    {!! Form::open(array('route' => 'tarea.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('categ', [], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Sub-categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {!! Form::select('subcateg', [], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('N° de interno:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::number('interno', null, array('class' => 'form-control', 'type' => 'number')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripcion del requerimiento:</label>
                                    {!! Form::textarea('descrip', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Adjuntar imagen: </label>
                                    {!! Form::file('image', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload')) !!}
                                </div>
                                
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Enviar</button>
                        <a href="{{ route('tarea.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
