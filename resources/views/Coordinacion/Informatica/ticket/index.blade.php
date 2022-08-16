@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Tickets</h3>
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
                                            @can('CREAR-CATEGORIALABORAL')
                                                {!! Form::open(['method' => 'GET', 'route' => ['categorialaboral.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['categorialaboral.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar Categoria', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            {!! Form::open(['method' => 'GET', 'class' => 'd-flex justify-content-evenly', 'route' => ['categorialaboral.pdf'], 'target' => '_blank']) !!}
                                            {!! Form::submit('Imprimir', ['class' => 'btn btn-success my-1']) !!}
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
                            <div class="table-responsive">
                                <table class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        <th class='ml-3' style="color:#fff;">Cat. Laboral</th>
                                        <th style="color:#fff;">WEB</th>
                                        <th style="color:#fff;">Suma Ingreso</th>
                                        <th style="color:#fff;">Datos Lab.</th>
                                        <th style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($CategoriasLaborales as $CategoriaLaboral)
                                            <tr>
                                                <td>{{$CategoriaLaboral->catlaboral}}</td>

                                                @if ($CategoriaLaboral->web == 1)
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
                                                @endswitch
                                                <td>
                                                    <div class="d-flex flex-row align-items-center justify-content-around">
                                                        @can('EDITAR-CATEGORIALABORAL')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['categorialaboral.edit', $CategoriaLaboral->id_catlaboral], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-CATEGORIALABORAL')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['categorialaboral.destroy', $CategoriaLaboral->id_catlaboral],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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

<script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script>
<script src="{{ asset('js/modal/success.js') }}"></script>

    
@endsection