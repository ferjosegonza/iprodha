@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">    

                        {!! Form::open(array('route' => 'usuarios.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name"></label>
                                    
                                    {!! Form::label('name', 'Nombre :'); !!}
                                    {!! Form::text('name', old('name'), ['type'=>'text','class' => 'form-control','placeholder'=>'']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail :'); !!}
                                    {!! Form::text('email', old('email'), array('class' => 'form-control')) !!}
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
                                        {!! Form::label('Roles', 'Roles para este Usuario :'); !!}
                                        <br/>
                                        @foreach($roles as $value)
                                            <label>{{ Form::checkbox('roles[]', $value->id, false, array('class' => 'name')) }}
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
@endsection
