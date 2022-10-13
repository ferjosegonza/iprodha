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

                            <div class="d-flex align-items-center justify-content-around">
                                {!! Form::text('name3', old('name'), [
                                                'placeholder' => 'Buscar',
                                                'class' => 'form-control col-sm-8 ',
                                                'style' => 'text-transform:uppercase;',
                                                'onkeypress' => 'buscarpermisosname()',
                                                'id' => 'name3',
                                            ]) !!}
                                <div class="form-check d-flex align-items-center  justify-content-around" onclick="buscarpermisosname()">
                                    <i class="fas fa-eye mr-3"></i>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Admite
                                    </label>
                                </div>
                                {!! Form::button('Buscar', ['onclick' => 'buscarpermisosname()', 'class' => 'btn btn-secondary']) !!}
                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            {!! Form::model($role, ['onkeypress'=>'if(event.keyCode == 13) event.returnValue = false;' ,'method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group d-flex align-items-end ">
                                        <div style="width: 50%">
                                            <label for="">Nombre del Rol:</label>      
                                            {!! Form::text('name', null, array('class' => 'col-xs-12 col-sm-12 form-control',
                                            'style'=>'text-transform:uppercase;')) !!}    
                                        </div>
                                        
                                        @can('CREAR-ROL')
                                            <button type="submit" style="height:47px" class="btn btn-warning mx-3">Guardar</button>
                                        @endcan
                                        
                                        <a style="height:47px;text-align: center;" href="{{ route('roles.index') }}" class="btn  btn-secondary fo align-middle align-items-center text-center"> <span style="vertical-align: middle;">Volver</span></a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Permisos para este Rol:
                                            
                                        </label>                                        
                                        <div class="col-xs-12 col-sm-12 d-flex align-items-center ">
                                            {{ Form::checkbox('checkpermisosrol', null, false, ['id' => 'checkpermisosrol','onclick' => 'seleccionarpermisos()', 'class' => 'ms-auto selectall name']) }}
                                            <div class="ms-3">Selec All</div>
                                        </div>
                                        <div id="permisos2" class="d-flex flex-column mt-3">
                                            @foreach($permission as $value)
                                                    <label id="2{{ $value->name }}">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name permisos10 permisoscheck'.$value->id)) }}
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