@extends('layouts.app')
@section('css')
    <style>
        #menu * {
            list-style: none;
        }

        #menu li {
            line-height: 180%;
        }

        #menu li a {
            color: #222;
            text-decoration: none;
        }

        #menu li a:before {
            content: "\025b8";
            color: #ddd;
            margin-right: 4px;
        }

        #menu input[name="list"] {
            position: absolute;
            left: -1000em;
        }

        #menu label:before {
            content: "\025b8";
            margin-right: 4px;
        }

        #menu input:checked~label:before {
            content: "\025be";
        }

        #menu .interior {
            display: none;
        }

        #menu .interior1 {
            display: block;
        }

        #menu input:checked~ul {
            display: block;
        }
    </style>
@endsection
@section('content')
@include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Menu/Vista</h3>
        </div>
        <div class="section-body">
            {!! Form::open(['route' => 'roles.storegrupo','class'=>'row d-flex', 'method' => 'POST','onKeyPress'=>"if(event.keyCode == 13) event.returnValue = false;"]) !!}
                @include('layouts.modal.mensajes')
                <div class="col-sm-6">
                    <div class="card ">
                        <div class="card-body mb-5">
                            <label class="col-xs-12 mt-2 " style="font-size: 1.5em"> <strong> Nuevo Menu</strong></label>

                            {!! Form::number('registro', 0, [
                                'style' => 'display:none',
                                'id' => 'registro',
                            ]) !!}
                            <div class="row ms-3">
                                <div class="col-xs-12">
                                    <label class="col-xs-12">Nombre del Menu:</label>
                                </div>
                                <div class="col-xs-12 row ">
                                    <div class="col-xs-12 col-sm-12 col-md-6 ">
                                        {!! Form::text('name', null, [
                                            'style' => 'text-transform:uppercase;',
                                            'id' => 'name',
                                            'class' => ' form-control',
                                        ]) !!}
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        {!! Form::number('edit', 0, ['style'=>'display:none',
                                            'id' => 'edit'
                                        ]) !!}
                                        {!! Form::number('id', null, ['style'=>'display:none',
                                            'id' => 'id'
                                        ]) !!}
                                        @can('CREAR-ROL')
                                        {!! Form::submit('Guardar', ['id'=>'btnguardar','disabled','class' => 'btn btn-warning mx-2']) !!}
                                        @endcan

                                        {!! link_to_route(
                                            'roles.index',
                                            $title = 'Volver',
                                            $parameters = [],
                                            $attributes = ['class' => 'btn btn-secondary fo '],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row ms-3 mt-3">

                                <div class="col-xs-12">
                                    <label class="col-xs-12">Menu Padre:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 ">
                                    <select name="idmenupadre" id="idmenupadre" placeholder="" class="form-select">
                                        <option value=""></option>
                                        @foreach ($listamenus as $listamenu)
                                            <option value="{{ $listamenu->idmenu }}">
                                                {{ $listamenu->nommenu . ' - id: ' . $listamenu->idmenu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row ms-3 mt-3">
                                <div class="col-xs-12">
                                    <label class="col-xs-12">Orden/Posicion:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 ">
                                    {!! Form::select('orden', [], null, ['placeholder' => '', 'id' => 'orden', 'class' => 'form-select']) !!}
                                </div>
                            </div>
                            <div class="row ms-3 mt-3">
                                <div class="col-xs-12">
                                    <label class="col-xs-12">Visible:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 ">
                                    {!! Form::select('visible', ['0' => 'No', '1' => 'Si'], null, [
                                        'placeholder' => '',
                                        'id' => 'visibles',
                                        'class' => 'form-select',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row ms-3 mt-3">
                                <div class="col-xs-12">
                                    <label class="col-xs-12">Menu o Hoja:</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 ">
                                    {!! Form::select('menuhoja', ['0' => 'Hoja', '1' => 'SubMenu'], null, [
                                        'placeholder' => '',
                                        'id' => 'menuhoja',
                                        'class' => 'form-select',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row  ms-3 mt-3" style="display:none" id="vvista">
                                
                                

                                <div class="col-xs-12 d-flex">
                                    <h3 class="col-xs-12">Vista</h3>
                                    <div class="ms-auto form-group">
                                        <label name="state" class="control-label">Buscar</label>
                                        <select name="state" lang="es" class="form-control" style="width: 200px"  id="tags">
                                        </select>
                                    </div>
                                </div>

                                <div class="row ms-3 mt-3 ">
                                    <div class="col-xs-12">
                                        <label class="col-xs-12">Nombre:</label>
                                    </div>
                                    <div class="col-xs-12 row ">
                                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                                            {!! Form::text('nomvista', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'class' => ' form-control',
                                                'id'=>'nomvista',
                                            ]) !!}
                                           
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2  ">
                                            
                                            {!! Form::button('cargar', [
                                                'style' => '',
                                                'id' => 'btnvista',
                                                'class' => 'btn btn-secondary',
                                                'onclick'=>'buscarvista()',
                                            ]) !!}
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 row align-items-center ">
                                            <label class="col-xs-12">Ej.: ROL.INDEX</label>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row ms-3 mt-3">
                                    <div class="col-xs-12">
                                        <label class="col-xs-12">Path:</label>
                                    </div>
                                    <div class="col-xs-12 row ">
                                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                                            {!! Form::text('path', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'class' => ' form-control',
                                                'id'=>'path',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row ms-3 mt-3">
                                    <div class="col-xs-12">
                                        <label class="col-xs-12">Nombre de Archivo:</label>
                                    </div>
                                    <div class="col-xs-12 row ">
                                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                                            {!! Form::text('nomarchivo', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'class' => ' form-control',
                                                'id'=>'nomarchivo',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row ms-3 mt-3">
                                    <div class="col-xs-12">
                                        <label class="col-xs-12">Generar Rol y Permisos Automaticamente:</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 ">
                                        {!! Form::select('rol-permiso-automatico', ['0' => 'NO', '1' => 'SI'], null, [
                                            'placeholder' => '',
                                            'id' => 'rol-permiso-automatico',
                                            'class' => 'form-select',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div id="menus">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ms-3">
                                <div class="row align-items-center justify-content-center">
                                    
                                    <div class="col-xs-12 mt-5 ms-5 d-flex"  >
                                        <label class="col-sm-8" style="font-size: 1.5em"> <strong>
                                            ARBOL</strong></label>
                                        <div class="col-xm-4">
                                            {!! Form::button('Nuevo', ['id'=>'btnnuevo','onclick' => 'nuevomenu()', 'class' => 'btn ms-auto btn-success']) !!}
                                            {!! Form::button('Editar', ['id'=>'btneditar','style'=>'background-color:#e86d6d','onclick' => 'editar()', 'class' => 'btn ms-auto btn-danger']) !!}
                                        </div>
                                    </div>

                                    <ul class="col-xs-12 mt-2 ms-5" id="menu">
                                        @include('Coordinacion.Informatica.GestionUsuarios.roles.menu-vistausuario', ['arbol' => $arbol])
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" style="display: none" id="permiso">
                        <div class="card  border border-3 border-primary border-opacity-75 rounded">
                            <div>
                                <div>
                                    <h5 class="card-header m-0 p-0 ms-4 ">Agregar Permisos </h5>
                                </div>
                                <div
                                    class="d-flex flex-row col-xs-12 col-sm-12 col-md-12 align-items-center justify-content-end">

                                    {!! Form::text('namepermiso', old('namepermiso'), [
                                        'placeholder' => 'Buscar',
                                        'class' => 'form-control col-sm-8 mr-2',
                                        'style' => 'text-transform:uppercase;',
                                        'onkeypress' => 'buscarpermisosname()',
                                        'id' => 'namepermiso',
                                    ]) !!}
                                    {!! Form::button('Buscar', ['id'=>'namepermisobtn','onclick' => 'buscarpermisosname()', 'class' => 'btn btn-secondary']) !!}
                                </div>
                            </div>

                            <br>
                            <h6 class="ms-3 card-title mb-0">Seleccione el permiso permisos que va a tener la persona:
                            </h6>
                            <div class="d-flex flex-row align-items-start justify-content-around ">
                                <div class="card-body ms-2 d-flex flex-column"
                                    id="lista_roles"style="height: 245px;width:50%">


                                    <div id="permisos2" class="d-flex flex-column overflow-auto" style="height: 225px;">
                                        @foreach ($permisos as $value)
                                            <label
                                                id="2{{ $value->name }}">{{ Form::radio('permiso', $value->id, false, ['onclick' => '', 'class' => 'name permisos10 permisoscheck' . $value->id]) }}
                                                {{ $value->name }}</label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12" style="display: none" id="rooles">
                        <div class="card border border-3 border-danger border-opacity-75 rounded">
                            <div class="d-flex flex-row align-items-center justify-content-around ">
                                <div>
                                    <h5 class="card-header m-0 p-0 ms-4">Roles</h5>
                                </div>
                                <div class="d-flex flex-row col-xs-10 col-sm-8 col-md-10 align-items-center justify-content-end">
                                    {!! Form::text('nameroles', old('nameroles'), [
                                        'placeholder' => 'Buscar',
                                        'class' => 'form-control col-sm-8 mr-2',
                                        'style' => 'text-transform:uppercase;',
                                        'onkeypress' => 'buscarroles(1)',
                                        'id' => 'nameroles',
                                    ]) !!}
                                    {!! Form::button('Buscar', ['onclick' => 'buscarroles(1)', 'class' => 'btn btn-secondary']) !!}
                                </div>
                            </div>
                            <br>
                            <h6 class="ms-3 card-title mb-0">Seleccione el rol que va a tener la vista:
                            </h6>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <div class="card-body " id="lista_roles">
                                        <div id="rolles">
                                            <table class="">
                                                <tbody id="radio" class="d-flex flex-column overflow-auto" style="width:200px;height: 250px;">
                                                    @foreach ($roles as $value)
                                                        <tr id="trradio{{ $value->id }}">
                                                            <td style="width: 90%"><label>
                                                                    {{ Form::radio('roless', $value->id, false, ['onclick' => 'buscarpermisos(' . $value->id . ')', 'id' => 'rr' . $value->id, 'class' => 'name ']) }}
                                                                    {{ $value->name }}</label></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="card mx-2  mt-3 " style="background-color: rgb(255, 255, 255); height: 225px; width:98% ">
                                        <h6 class="card-title ms-4 mt-3 ">Permisos</h6>
                                        <div class="overflow-auto ">
                                            <div class="card-body m-0 p-0" id="lista_permisos">
                                                <div id="permisos">
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
@endsection
@section('js')
<script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/roles/crear_grupos.js') }}"></script>
@endsection
