



@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Alumno</h3>
        </div>
        {!! Form::open(['route' => 'alumnos.store', 'class' => 'formulario', 'method' => 'POST']) !!}

        <div class="section-body row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                @include('layouts.modal.mensajes')
                <div class="card">
                    <div class="card-body">

                        <div class="row ">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">

                                    {!! Form::label('dni', 'DNI :') !!}
                                    {!! Form::number('dni', old('dni'), ['type' => 'text', 'class' => 'form-control','max'=>'99999999','min'=>'10000000', 'placeholder' => '']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('nombre', 'Nombre :') !!}
                                    {!! Form::text('nombre', old('nombre'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('cuil', 'Cuil :') !!}
                                    {!! Form::text('cuil', old('cuil'),['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('fechanac', 'Fecha Nac :') !!}
                                    {!! Form::date('fechanac',\Carbon\Carbon::now(),['class'=>'form-control']) !!}                                   
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                @can('CREAR-USUARIO')
                                {!! Form::submit('Crear', ['onclick' => '', 'class' => 'btn btn-warning mr-2']) !!}
                                @endcan
                                {!! link_to_route('alumnos.index',$title = 'Volver',$parameters = [],$attributes = ['class' => 'btn btn-secondary fo']) !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
