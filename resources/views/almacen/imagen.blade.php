@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ver almacén</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open([
                            'method' => 'PUT',
                            'route' => ['almacen.guardarImagen', $p_almacen->id_almacen],
                            'style' => 'display:inline',
                            'files'=>'true']) !!}
                        <div class="form-group">
                            {!! Form::label('Nombre:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                            {!! Form::text('nom_almacen', $p_almacen->nom_almacen, array('class' => 'form-control', 'readonly'=> 'true','style' => 'disabled')) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Abreviatura:</label>                                    
                            {!! Form::text('abr_almacen', $p_almacen->abr_almacen, array('class' => 'form-control','readonly'=> 'true','style' => 'disabled')) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Direccion:</label>                                    
                            {!! Form::text('dom_almacen', $p_almacen->dom_almacen, array('class' => 'form-control','readonly'=> 'true',   'style' => 'disabled')) !!}
                        </div>
                        <div>
                            <img src={{asset($p_almacen->imagen)}} alt="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Subir imagen:</label>                                    
                            {!! Form::file('image', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload', 'accept' => 'image/*')) !!}
                        </div>                       
                        <div>
                            <a href="{{ route('p_almacen.index') }}"class="btn btn-primary fo">Volver</a>
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mr-2', 'style' => 'width: 40%']) !!}
                            {!! Form::close() !!}     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection