@extends('layouts.app')

@section('content')
    <script type="text/javascript" src="{{ asset('js/iprousuarios/index.js') }}"></script>

    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios de Iprodha</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col">
                    @include('layouts.modal.mensajes')
                    <div class="card col-sm-12">
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                                <div style="height:30px">
                                    @can('CREAR-IPROUSUARIO')
                                        <a class="btn btn-warning" href="{{ route('iprousuarios.create') }}">Nuevo</a>
                                    @endcan
                                </div>
                                {!! Form::open([
                                    'method' => 'GET',
                                    'class' => 'd-flex col-sm-6',
                                    'route' => ['iprousuarios.index'],
                                    'style' => 'display:inline',
                                ]) !!}
                                <input type="text" class="form-control  mx-2 " name='name' placeholder="Buscar">
                                {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-body ">
                            <!-- Centramos la paginacion a la derecha -->
                            <div class="pagination justify-content-end">
                                {!! $iprousuarios->links() !!}
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table style="width:100%;" class=" table table-striped mt-2">
                                    <thead style="height:50px;">
                                        <th class='pl-3' style="color:#fff">Nombre Completo</th>
                                        <th style="color:#fff;">Usuario</th>
                                        <th style="color:#fff;">Iniciales</th>
                                        <th style="color:#fff;">Clave</th>
                                        <th style="color:#fff;">Cod. Are</th>
                                        <th style="color:#fff;">Creacion</th>
                                        <th style="color:#fff;">Fec. Cad</th>
                                        <th style="color:#fff;">Estado</th>
                                        <th style="color:#fff;">ip</th>
                                        <th style="color:#fff;">Terminal</th>
                                        <th style="color:#fff;">Sid</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($iprousuarios as $iprousuario)
                                            <tr>
                                                <td class='pl-3'>{{ $iprousuario->nomcom }}</td>
                                                <td>{{ $iprousuario->nomusu }}</td>
                                                <td>{{ $iprousuario->iniusu }}</td>
                                                <td>{{ $iprousuario->clausu }}</td>
                                                <td>{{ $iprousuario->codare }}</td>
                                                <td>{{ $iprousuario->feccre }}</td>
                                                <td>{{ $iprousuario->feccad }}</td>
                                                @if ($iprousuario->estado == 'A')
                                                    <td>Activo</td>
                                                @else
                                                    <td>Inactivo</td>
                                                @endif

                                                <td>{{ $iprousuario->ip }}</td>
                                                <td>{{ $iprousuario->terminal }}</td>
                                                <td>{{ $iprousuario->sid }}</td>

                                                <td>
                                                    <div class="d-flex flex-row align-items-center justify-content-around">
                                                        @can('EDITAR-IPROUSUARIO')
                                                            <a class="btn btn-primary mr-2"
                                                                href="{{ route('iprousuarios.edit', $iprousuario->nomcom) }}">Editar</a>
                                                        @endcan
                                                        @can('BORRAR-IPROUSUARIO')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['iprousuarios.destroy', $iprousuario->nomcom],
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
@endsection
