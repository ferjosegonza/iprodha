@extends('layouts.app')
@section('css')
@endsection

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
                                {!! Form::text('name3', old('name'), [
                                                'placeholder' => 'Buscar',
                                                'class' => 'form-control col-sm-10 mr-3',
                                                'style' => 'text-transform:uppercase;',
                                                'onkeypress' => 'buscarpermisosname()',
                                                'id' => 'name3',
                                            ]) !!}
                                {!! Form::button('Buscar', ['onclick' => 'buscarpermisosname()', 'class' => 'btn btn-secondary']) !!}
                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['onkeypress'=>'if(event.keyCode == 13) event.returnValue = false;' ,'route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">

                                <div class="col-xs-12">
                                    <label class="col-xs-12">Nombre del Rol:</label>
                                </div>
                                <div class="col-xs-12 row ">
                                    <div class="col-xs-12 col-sm-12 col-md-6 ">
                                        {!! Form::text('name', null, [
                                            'style'=>'text-transform:uppercase;','class' => ' form-control']) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        @can('CREAR-ROL')
                                        {!! Form::submit('Nuevo', ['class' => 'btn btn-warning mx-2']) !!}
                                        @endcan

                                        {!! link_to_route('roles.index', $title = 'Volver', $parameters = [], $attributes = ['class'=>'btn btn-secondary fo ']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Permisos para este Rol:</label>
                                      
                                        <div class="col-xs-12 col-sm-12 d-flex align-items-center ">
                                            {{ Form::checkbox('checkpermisosrol', null, false, ['id' => 'checkpermisosrol','onclick' => 'seleccionarpermisos()', 'class' => 'ms-auto selectall name']) }}
                                            <div class="ms-3">Selec All</div>
                                        </div>
                                        <div id="permisos2" class="d-flex flex-column mt-3">
                                            @foreach ($permission as $value)
                                                <label
                                                    id="2{{ $value->name }}">{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name permisos10 permisoscheck'.$value->id]) }}
                                                    {{ $value->name }}</label>
                                            @endforeach
                                        </div>
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

@section('js')
<script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/roles/crear_roles.js') }}"></script>

@endsection

