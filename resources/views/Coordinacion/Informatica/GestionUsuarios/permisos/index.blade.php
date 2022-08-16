@extends('layouts.app')

@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])

    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Permisos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col">
                    @include('layouts.modal.mensajes')
                    <div class="card col-sm-6">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-PERMISO')
                                                {!! Form::open(['method' => 'GET', 'route' => ['permisos.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['permisos.index'],
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
                            <div class="pagination justify-content-end">
                                <!-- Ubicamos la paginacion a la derecha -->
                                {!! $permisos->links() !!}
                            </div>
                            <div class=" table-responsive">

                                <table class="table table-striped mt-2">
                                    <thead>
                                        <th style="color:#fff;">Permiso</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($permisos as $permiso)
                                            <tr>
                                                <td>{{ $permiso->name }}</td>
                                                <td>
                                                    <div class="d-flex flex-row align-items-center justify-content-around">
                                                        @can('EDITAR-PERMISO')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['permisos.edit', $permiso->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-PERMISO')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['permisos.destroy', $permiso->id],
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
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/Coordinacion/Informatica/GestionUsuarios/permisos/index_permisos.js') }}"></script>
@endsection
