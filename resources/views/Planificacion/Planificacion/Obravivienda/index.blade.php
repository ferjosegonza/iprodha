@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Obras y Viviendas</h3>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 my-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <form method="GET" action="{{route('obravivienda.index')}}">
                                            <div class="input-group mb-3">
                                                <input name="name" type="text" class="form-control" placeholder="Buscar Obra por [Numero o Nombre]" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5 my-auto">
                                    
                                </div>
                                
                                <div class="col-lg-2">
                                    @can('CREAR-OBRAS')
                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.create'], 'class' => 'd-flex justify-content-end']) !!}
                                            {!! Form::submit('Nueva Obra', ['class' => 'btn btn-success my-1']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- @if (count($obras) != 0)
                                <div class="pagination justify-content-end">
                                    {!! $obras->links() !!}
                                </div>
                            @endif --}}
                            
                                                   
                            <div class="table-responsive">
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;">
                                        <th class='ml-3 text-center' style="color:#fff; width:5%;">Numero</th>
                                        <th class='text-center' style="color:#fff; width:20%;">Obra</th>
                                        <th class='text-center' style="color:#fff; width:20%;">Empresa</th>
                                        <th class='text-center' style="color:#fff; width:10%;">Localidad</th>
                                        <th class='text-center' style="color: #fff; width:5%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($obras as $obra)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$obra->num_obr}}</td>

                                                <td style="vertical-align: middle;">{{$obra->nom_obr}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$obra->getEmpresa->nom_emp}}</td>
                                                
                                                @if (!is_null($obra->id_loc))
                                                    <td class='text-center' style="vertical-align: middle;">{{$obra->getLocalidad->nom_loc}}</td>
                                                @else
                                                    <td class='text-center' style="vertical-align: middle;"> NO EXISTE </td>
                                                @endif
                                                

                                                <td>
                                                    <div>
                                                        <div class="row mb-2 ">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                                @can('VER-OBRAS')
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.show',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Ver', ['class' => 'btn btn-primary w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                                @can('VER-OBRAS')
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.edit',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Editar', ['class' => 'btn btn-primary w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                @can('VER-OBRAS')
                                                                {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.viviendas',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Viviendas', ['class' => 'btn btn-success mb-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            @can('VER-OBRAS')
                                                                {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.etapas', $obra->id_obr], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Etapas/Entregas', ['class' => 'btn btn-success mr-2 w-100']) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                            </div>
                                                        </div>
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