@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Rubro</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    {!! Form::model($rubro, ['method' => 'PATCH','route' => ['rubros.update', $rubro->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Nombre del Rubro:</label>                                    
                                    {!! Form::text('rubro', null, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('rubros.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection