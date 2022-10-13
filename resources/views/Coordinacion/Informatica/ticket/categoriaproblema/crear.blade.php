@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Categoria Problema</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         
                    
                    {!! Form::open(array('route' => 'categoriaprob.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Categoria Problema:</label>                                    
                                    {!! Form::text('nombre', null, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Baja:</label>
                                    {!! Form::date('baja', null, [
                                        'min' => \Carbon\Carbon::today()->toDateString(),
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'periodo',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('categoriaprob.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
