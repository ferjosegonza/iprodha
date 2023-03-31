@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear almacén</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(array('route'=>'p_almacen.store', 'method'=>'POST'))!!}
                        <div class="row">
                            <div class="form-group">
                                <label for="">Nombre del Almacén</label>
                                {!! Form::text('nom_almacen', null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Abreviatura del Almacén</label>
                                {!! Form::text('abr_almacen', null, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Domicilio del Almacén</label>
                                {!! Form::text('dom_almacen', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('p_almacen.index') }}"class="btn btn-secondary fo">Volver</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection