@extends('layouts.app')

@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles - Menu</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col row d-flex justify-content-evenly">
                    @include('layouts.modal.mensajes')
                    <div class="card col-sm-8">
                        <div class="card-body">
                            
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-5 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="d-flex justify-content-evenly align-items-evenly">
                                                @can('CREAR-ROL')
                                                {!! Form::open(['method' => 'GET', 'route' => ['roles.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo Rol', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                            @can('CREAR-ROL')
                                                {!! Form::open(['method' => 'get', 'route' => ['roles.creargrupo'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo Menu', ['class' => 'btn btn-success my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                            </div>
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'style'=>'text-transform:uppercase;',
                                                'class' => '',
                                                'route' => ['roles.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card col-sm-6">
                        <div class="card-body ">
                            {{--<div class="pagination justify-content-end">
                                <!-- Ubicamos la paginacion a la derecha -->
                                {!! $roles->links() !!}
                            </div>--}}
                            <div class="table-responsive">

                                <table class="table table-striped mt-2">
                                    <thead>
                                        <th style="color:#fff;">Rol</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <div class="d-flex flex-row align-items-center justify-content-around">
                                                        @can('EDITAR-ROL')
                                                            {!! Form::model($role, [
                                                                'method' => 'GET',
                                                                'class' => 'd-flex ',
                                                                'route' => ['roles.edit', $role->id],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::text('id', null, ['class' => 'd-none', 'value' => $role->id, 'placeholder' => $role->id]) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-ROL')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['roles.destroy', $role->id],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card col-sm-6">
                        <div class="card-body ">
                            {{--<div class="pagination justify-content-end">
                                <!-- Ubicamos la paginacion a la derecha -->
                                {!! $roles->links() !!}
                            </div>--}}
                            <div class="table-responsive">

                                <table  class="table table-striped mt-2" >
                                    <thead style=" background-color:#7ce670">
                                        <th style="color:#fff;">Menus</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles_sinpermisos as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')
    <script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/roles/index_roles.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
            });

            });

    </script>
@endsection
