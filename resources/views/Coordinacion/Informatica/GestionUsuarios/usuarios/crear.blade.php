@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Usuarios</h3>
        </div>
        <div class="section-body">
            {!! Form::open(['route' => 'usuarios.store', 'class' => 'formulario', 'method' => 'POST']) !!}

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">

                    @include('layouts.modal.mensajes')

                    <div class="card">
                        <div class="card-body">

                            <div class="row ">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">

                                        {!! Form::label('name', 'Nombre :') !!}
                                        {!! Form::text('name', old('name'), ['type' => 'text', 'class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('email', 'E-mail :') !!}
                                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('password', 'Password :') !!}
                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('confirm-password', 'Confirmar Password :') !!}
                                        {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="card border border-3 border-danger border-opacity-75 rounded" >
                                        <div class="d-flex flex-row align-items-center justify-content-around ">
                                            <div>
                                                <h5 class="card-header m-0 p-0 ms-4">Roles</h5>
                                            </div>
                                            <div
                                                class="d-flex flex-row col-xs-10 col-sm-8 col-md-10 align-items-center justify-content-end">

                                                {!! Form::text('name2', old('name'), [
                                                    'placeholder' => 'Buscar',
                                                    'class' => 'form-control col-sm-8 mr-2',
                                                    'style' => 'text-transform:uppercase;',
                                                    'onkeypress' => 'buscarroles()',
                                                    'id' => 'name2',
                                                ]) !!}
                                                {!! Form::button('Buscar', ['onclick' => 'buscarroles()', 'class' => 'btn btn-secondary']) !!}
                                            </div>
                                        </div>

                                        <br>
                                        <h6 class="ms-3 card-title mb-0">Seleccione los roles que va a tener la persona:
                                        </h6>
                                        <div class="d-flex flex-row align-items-start justify-content-around">
                                            <div class="card-body ms-2" id="lista_roles">

                                                <div id="rolles" class="d-flex flex-column overflow-auto">
                                                    @foreach ($roles as $value)
                                                        <label
                                                            id="3{{ $value->id }}">{{ Form::checkbox('roles[]', $value->id, false, ['onclick' => 'buscarpermisos(' . $value->id . ')', 'class' => 'name']) }}
                                                            {{ $value->name }}</label>
                                                    @endforeach

                                                </div>
                                            </div>

                                            <div class="card me-3  mt-3 " style="height: 225px; width:50% ">
                                                <h6 class="card-title ms-4 mt-4">Permisos</h6>
                                                <div class="overflow-auto ">
                                                    <div class="card-body" id="lista_permisos">
                                                        <div id="permisos">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    {!! Form::button('Guardar', ['onclick' => 'clickSubmit()', 'class' => 'btn btn-warning mr-2']) !!}
                                    {!! Form::submit('Guardar', ['id' => 'submit', 'class' => 'd-none']) !!}
                                    {!! link_to_route(
                                        'usuarios.index',
                                        $title = 'Volver',
                                        $parameters = [],
                                        $attributes = ['class' => 'btn btn-secondary fo'],
                                    ) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">


                    <div class="card">
                        <div class="card-body">

                            <div class="row ">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="card  border border-3 border-primary border-opacity-75 rounded">
                                        <div>
                                            <div>
                                                <h5 class="card-header m-0 p-0 ms-4 ">Agregar Permisos </h5>
                                            </div>
                                            <div
                                                class="d-flex flex-row col-xs-12 col-sm-12 col-md-12 align-items-center justify-content-end">

                                                {!! Form::text('name3', old('name'), [
                                                    'placeholder' => 'Buscar',
                                                    'class' => 'form-control col-sm-8 mr-2',
                                                    'style' => 'text-transform:uppercase;',
                                                    'onkeypress' => 'buscarpermisosname()',
                                                    'id' => 'name3',
                                                ]) !!}
                                                {!! Form::button('Buscar', ['onclick' => 'buscarpermisosname()', 'class' => 'btn btn-secondary']) !!}
                                            </div>
                                        </div>

                                        <br>
                                        <h6 class="ms-3 card-title mb-0">Seleccione los permisos que va a tener la persona:
                                        </h6>
                                        <div class="d-flex flex-row align-items-start justify-content-around ">
                                            <div class="card-body ms-2 " id="lista_roles"style="height: 225px;width:50%">

                                                <div id="permisos2" class="d-flex flex-column overflow-auto"
                                                    style="height: 225px;">
                                                    @foreach ($permisos as $value)
                                                        <label
                                                            id="2{{ $value->name }}">{{ Form::checkbox('permisos[]', $value->id, false, ['onclick' => 'agregarpermiso(' . $value->id . ',"' . $value->name . '")', 'class' => 'name']) }}
                                                            {{ $value->name }}</label>
                                                    @endforeach

                                                </div>
                                            </div>

                                            <div class="card me-3  mt-3 " style="height: 225px; width:100% ">
                                                <h6 class="card-title ms-4 mt-4 pb-0 mb-2">Permisos</h6>
                                                <div class="overflow-auto">
                                                    <div class="card-body d-flex flex-column pt-0" id="lista_permisos2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="card  border border-3 border-success border-opacity-75 rounded">
                                        <div>
                                            <div>
                                                <h5 class="card-header m-0 p-0 ms-4 ">Agregar Grupos </h5>
                                            </div>
                                            <div
                                                class="d-flex flex-row col-xs-12 col-sm-12 col-md-12 align-items-center justify-content-end">

                                                {!! Form::text('name4', old('name'), [
                                                    'placeholder' => 'Buscar',
                                                    'class' => 'form-control col-sm-8 mr-2',
                                                    'style' => 'text-transform:uppercase;',
                                                    'onkeypress' => 'buscargrupos()',
                                                    'id' => 'name4',
                                                ]) !!}
                                                {!! Form::button('Buscar', ['onclick' => 'buscargrupos()', 'class' => 'btn btn-secondary']) !!}
                                            </div>
                                        </div>

                                        <br>
                                        <h6 class="ms-3 card-title mb-0">Seleccione los Grupos en los que va a estar la persona:
                                        </h6>
                                        <div class="d-flex flex-row align-items-start justify-content-around ">
                                            <div class="card-body ms-2 " id="lista_roles"style="height: 225px;width:50%">

                                                <div id="grupos4" class="d-flex flex-column overflow-auto"
                                                    style="height: 225px;">
                                                    @foreach ($roles_sinpermisos as $value)
                                                        <label
                                                            id="4{{ $value->id }}">{{ Form::checkbox('grupos[]', $value->id, false, ['class' => 'name']) }}
                                                            {{ $value->name }}</label>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </section>
    <script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/usuarios/crear_usuarios.js') }}"></script>
@endsection
