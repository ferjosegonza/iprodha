@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear sector</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(array('route'=>'sector.store', 'method'=>'POST'))!!}
                        <div class="row">
                            <div class="form-group">
                                <label for="">Nombre del Sector</label>
                                {!! Form::text('nom_sector', null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Descripción del sector</label>
                                {!! Form::text('desc_sector', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('sector.index') }}"class="btn btn-secondary fo">Volver</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection