@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Usuario</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">

                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                            {!! Form::label('name', 'Buscar Rol :'); !!}
                            <div class="d-flex">
                                {!! Form::open([
                                    'method' => 'GET',
                                    'class' => 'd-flex p-0 col-sm-12',
                                    'route' => ['usuarios.create'],
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
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['usuarios.update', Crypt::encrypt($user->id)]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('name', 'Nombre :'); !!}
                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail :'); !!}
                                    {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password :'); !!}
                                    {!! Form::password('password', array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('confirm-password', 'Confirmar Password :'); !!}
                                    {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('Roles', 'Agregar Roles :'); !!}
                                    <br/>
                                    @foreach($roles as $value)
                                        <label>{{ Form::checkbox('roles1[]', $value->id, in_array($value->id, $userRole) ? true : false, array('class' => 'name listadoAgregar','onclick'=>'seleccionarEliminar('.$value->id.')')) }}
                                            {{ $value->name }}</label>
                                        <br/>
                                    @endforeach 
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('Roles', 'Eliminar Roles :'); !!}
                                    <br/>
                                    @foreach($roles as $value)
                                        <label>{{ Form::checkbox('roles2[]', $value->id, false, array('class' => 'name listaEliminar')) }}
                                            {{ $value->name }}</label>
                                        <br/>
                                    @endforeach
                                        <div class="pagination justify-content-end">
                                            {!! $roles->links() !!}
                                        </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-warning mr-2']) !!}
                                {!! link_to_route('usuarios.index', $title = 'Volver', $parameters = [], $attributes = ['class'=>'btn btn-secondary fo']) !!} 
                            </div>
                        </div>
                        {!! Form::close() !!}
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/usuarios/editar_usuarios.js') }}"></script>
@endsection
