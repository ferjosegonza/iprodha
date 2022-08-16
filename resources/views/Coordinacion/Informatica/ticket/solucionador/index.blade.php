@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Solucionador</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('crear-categorialaboral')
                                                {!! Form::open(['method' => 'GET', 'route' => ['solucionador.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['solucionador.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar Solucionador', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            {!! Form::open(['method' => 'GET', 'class' => 'd-flex justify-content-evenly', 'route' => ['tiposolucionador.index'], 'target' => '_blank']) !!}
                                            {!! Form::submit('tipo', ['class' => 'btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                 {!! $CategoriasLaborales->links() !!}
                            </div> --}}
                            <div class="table-responsive text-center">
                                <table class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        <th style="color:#fff;">ID</th>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">Tipo</th>
                                        <th style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Solucionadores as $Solucionador)
                                            <tr>
                                                <td>{{$Solucionador->idsolucionador}}</td>
                                                <td>{{$Solucionador->nombre}}</td>
                                                <td>{{$Solucionador->getTipo->destipsolucionador}}</td>
                                                {{-- @if ($CategoriaLaboral->web == 1)
                                                    <td>SI</td>
                                                @else
                                                    <td>NO</td>
                                                @endif

                                                @if ($CategoriaLaboral->sumaingreso == 1)
                                                    <td>SI</td>
                                                @else
                                                    <td>NO</td>
                                                @endif
                                                
                                                @switch($CategoriaLaboral->datolab)
                                                    @case(1)
                                                        <td>SI</td>
                                                    @break
                                            
                                                    @case(3)
                                                        <td>SIN OPCION</td>
                                                    @break
                                            
                                                    @default
                                                        <td>NO</td>
                                                @endswitch --}}
                                                <td>
                                                    <div class="align-items-center">
                                                        @can('EDITAR-CATEGORIALABORAL')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['solucionador.edit', $Solucionador->idsolucionador], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-CATEGORIALABORAL')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['solucionador.destroy', $Solucionador->idsolucionador],
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
                <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display: none">
                    <div class="card">
                        <div id='contenido' class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

<script src="{{ asset('js/ticket/index_solucionador.js') }}"></script>

    
@endsection