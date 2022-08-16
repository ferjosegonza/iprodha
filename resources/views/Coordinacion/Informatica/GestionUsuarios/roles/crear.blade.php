@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Rol</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-6">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                            {!! Form::label('name', 'Buscar Permisos :'); !!}

                            <div class="d-flex">
                                {!! Form::open([
                                    'method' => 'GET',
                                    'class' => 'd-flex p-0 col-sm-12',
                                    'route' => ['roles.create'],
                                    'style' => 'display:inline',
                                ]) !!}
                                <input type="text" class="form-control mr-2" name='name' placeholder="Buscar">
                                {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">

                                <div class="col-xs-12">
                                    <label class="col-xs-12">Nombre del Rol:</label>
                                </div>
                                <div class="col-xs-12 row ">
                                    <div class="col-xs-12 col-sm-12 col-md-6 ">
                                        {!! Form::text('name', null, ['class' => ' form-control']) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-warning mx-2']) !!}
                                        {!! link_to_route('roles.index', $title = 'Volver', $parameters = [], $attributes = ['class'=>'btn btn-secondary fo ']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Permisos para este Rol:</label>

                                        <br />
                                        @foreach ($permission as $value)
                                            <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                                {{ $value->name }}</label>
                                            <br />
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
