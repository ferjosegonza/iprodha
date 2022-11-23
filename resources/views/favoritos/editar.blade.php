@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Favorito</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body">
                    {!! Form::model($Favorito, ['method' => 'PATCH', 'route' => ['favorito.update', $Favorito->ruta]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Titulo:</label>                                    
                                    {!! Form::text('titulo', null, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripcion:</label>                                    
                                    {!! Form::textarea('descripcion', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'required']) !!}
                                </div>
                            </div>       
                        </div>
                        {{-- <button type="submit" class="btn btn-primary mr-2">Guardar</button> --}}
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary mr-2']) !!}
                        <a href="{{ route('inicio') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection