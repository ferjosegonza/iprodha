@extends('layouts.app')


@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    @include('layouts.modal.mensajes')
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-USUARIO')
                                                {!! Form::open(['method' => 'GET', 'route' => ['usuarios.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                    {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['usuarios.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-8 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            {!! Form::open(['method' => 'GET', 'class' => 'd-flex justify-content-evenly', 'route' => ['usuarios.pdf']]) !!}
                                                {!! Form::submit('Imprimir', ['class' => 'btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card  col-md-7 ">
                        <div class="card-body">
                            {{--<!-- Centramos la paginacion a la derecha -->
                            <div class="pagination justify-content-end">
                                 $usuarios->links() 
                            </div>--}}
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2 ">
                                    <thead style="height:50px;">
                                        <th class='ml-3' style="color:#fff">ID</th>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">E-mail</th>
                                        {{--<th style="color:#fff;width:25%">Roles</th>--}}
                                        {{--<th style="color:#fff;">Grupos</th>--}}
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                            <tr>
                                                <td class='pl-3'>{{ $usuario->id }}</td>
                                                <td>{{ $usuario->name }}</td>
                                                <td>{{ $usuario->email }}</td>
                                                {{--<td>
                                                    <div class="d-flex  flex-wrap align-items-center">
                                                        @if (!empty($usuario->getRoleNames()))
                                                            @foreach ($usuario->getRoleNames() as $rolNombre)
                                                                @foreach ($roles_permisos as $roles)
                                                                    @if ($roles->name == $rolNombre)
                                                                        <div class="badge badge-danger ">{{ $rolNombre }}
                                                                        </div>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </td>--}}
                                                
                                                <td >
                                                    <div class="d-flex flex-row align-items-center justify-content-around">
                                                        @can('EDITAR-USUARIO')
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'route' => ['usuarios.edit', $usuario->id],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                                        {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-USUARIO')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'formulario',
                                                            'route' => ['usuarios.destroy', Crypt::encrypt($usuario->id)],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {{--{!! Form::open([
                                                            'method' => 'DELETE',
                                                            'class' => 'formulario',
                                                            'route' => ['usuarios.destroy', Crypt::encrypt($usuario->id)],
                                                            'style' => 'display:inline',
                                                        ]) !!}--}}
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
                </div>
                <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display: none">
                    <div class="card">
                        <div id='contenido' class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/usuarios/index_usuarios.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
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