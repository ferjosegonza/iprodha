@extends('layouts.app')


@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alumnos</h3>
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
                                           
                                           
                                            @can('CREAR-ALUMNOS')
                                                {!! Form::open(['method' => 'GET', 'route' => ['alumnos.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                    {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        
                                        
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open(['method' => 'GET','class' => '','route' => ['alumnos.index'],]) !!}
                                                <div class="row justify-content-evenly align-items-center">
                                                    <div
                                                        class="col-xs-9 col-sm-9 col-md-9 col-lg-8 d-flex justify-content-evenly">
                                                        {!! Form::text('nombre', null, ['placeholder' => 'Buscar por Nombre', 'class' => 'form-control  ']) !!}
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
                    <div class="card  col-md-7 ">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2 ">
                                    <thead style="height:50px;">
                                        <th class='ml-3' style="color:#fff">DNI</th>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">Cuil</th>
                                        <th style="color:#fff;">Fecha Nac.</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumnos as $alumno)
                                            <tr>
                                                <td class='pl-3'>{{ $alumno->dni }}</td>
                                                <td>{{ $alumno->nombre }}</td>
                                                <td>{{ $alumno->cuil }}</td>
                                                <td>{{ $alumno->fechanac }}</td>
                                                <td>
                                                    @can('EDITAR-ALUMNOS')
                                                        {!! Form::open(['method' => 'GET','route' => ['alumnos.edit', $alumno->dni],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan

                                                    @can('BORRAR-ALUMNOS')
                                                        {!! Form::open(['method' => 'DELETE','class' => 'formulario','route' => ['alumnos.destroy', $alumno->dni],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
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
@endsection

@section('js')
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