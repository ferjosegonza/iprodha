@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Rol</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-6">
                    @include('layouts.modal.mensajes')
                    <div class="card ml-0 pl-3">
                        <div class="card-body ml-0 pl-0">
                            {!! Form::label('name', 'Buscar Permisos :'); !!}

                            <div class="d-flex align-items-center">
                                
                                {!! Form::model($role,['method' => 'GET','class' => 'd-flex col-sm-12', 'route' => ['roles.edit',$role->id],'style'=>'display:inline']) !!}
                                    <input type="text" class="form-control mr-3" name='name' placeholder="">
                                {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                <div class="form-check d-flex align-items-center ml-3">
                                    <input class="form-check-input" name='check' type="checkbox" value="1" id="check">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Admite
                                    </label>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group d-flex align-items-end ">
                                        <div style="width: 50%">
                                            <label for="">Nombre del Rol:</label>      
                                            {!! Form::text('name', null, array('class' => 'col-xs-12 col-sm-12 form-control')) !!}    
                                        </div>
                                        <button type="submit" style="height:47px" class="btn btn-warning mx-3">Guardar</button>
                                        
                                        <a style="height:47px;text-align: center;" href="{{ route('roles.index') }}" class="btn  btn-secondary fo align-middle align-items-center text-center"> <span style="vertical-align: middle;">Volver</span></a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Permisos para este Rol:</label>
                                        <br>
                                        @foreach($permission as $value)
                                            @if($check=='1')
                                                @if(in_array($value->id, $rolePermissions))
                                                    <label>{{ Form::checkbox('permission[]', $value->id, true, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br>
                                                
                                                @endif
                                            @else
                                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                                <br>
                                            @endif

                                            
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
