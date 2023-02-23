@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Rubros de Empresas</h3>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 my-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <form method="GET" action="{{route('rubros.index')}}">
                                            <div class="input-group mb-3">
                                                <input name="name" type="text" class="form-control" placeholder="Buscar Rubro" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5 my-auto">
                                    
                                </div>
                                
                                <div class="col-lg-2">
                                    @can('CREAR-RUBROS')
                                        {!! Form::open(['method' => 'GET', 'route' => ['rubros.create'], 'class' => 'd-flex justify-content-end']) !!}
                                            {!! Form::submit('Nuevo Rubro', ['class' => 'btn btn-success my-1']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-Rubros')
                                                {!! Form::open(['method' => 'GET', 'route' => ['rubros.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['rubros.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar Rubro', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div> --}}
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                 {!! $CategoriasLaborales->links() !!}
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;">
                                        <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                        <th class='text-center' style="color:#fff;">Nombre</th>
                                        <th class='text-center' style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($rubros as $rubro)
                                            <tr>
                                                <td class='text-center'>{{$rubro->id}}</td>

                                                <td>{{$rubro->rubro}}</td>

                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        @can('EDITAR-RUBROS')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['rubros.edit', $rubro->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-RUBROS')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['rubros.destroy', $rubro->id],
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

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
<script src="{{ asset('js/modal/success.js') }}"></script>

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
                "aaSorting": []
        });
    });
</script>

    
@endsection