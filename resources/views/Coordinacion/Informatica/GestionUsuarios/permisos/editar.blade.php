@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Permiso</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                        
                        {!! Form::model($permiso, ['method' => 'PATCH',
                        'style'=>'text-transform:uppercase;','route' => ['permisos.update', $permiso->id]]) !!} 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Nombre del Permiso:</label>                                    
                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>       
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                            <a href="{{ route('permisos.index') }}"class="btn btn-secondary fo">Volver</a>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
