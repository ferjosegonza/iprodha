@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <h4 class="titulo page__heading my-auto">Itemizado de obras</h4>
            </div>
            <div class="">
                @include('layouts.favorito.fav', ['modo' => 'Agregar'])
            </div>
            <div class="ms-auto">
            </div>
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
                                        <form method="GET" action="{{route('itemizado_obra.index')}}">
                                            <div class="input-group mb-3">
                                                <input name="name" type="text" class="form-control" placeholder="Buscar Obra por " aria-label="Recipient's username" aria-describedby="button-addon2">

                                                <select name="opcionbusq" class="form-select" aria-label="Default select example">
                                                    <option value=0 >General</option>
                                                    <option value=1 {{ ($opcion == 1 ? "selected":"") }}>Numero de obra</option>
                                                    <option value=2 {{ ($opcion == 2 ? "selected":"") }}>Nombre de obra</option>
                                                    <option value=3 {{ ($opcion == 3 ? "selected":"") }}>Expediente de obra</option>
                                                    <option value=4 {{ ($opcion == 4 ? "selected":"") }}>Plano de obra</option>
                                                    <option value=5 {{ ($opcion == 5 ? "selected":"") }}>Empresa</option>
                                                    {{-- <option value=6>Localidad</option> --}}
                                                </select>

                                                <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5 my-auto">
                                    
                                </div>
                                
                                <div class="col-lg-2">
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
                                        <th class='text-center' style="color:#fff; width:20%;">Expendiente</th>
                                        <th class='text-center' style="color:#fff; width:20%;">Empresa</th>
                                        <th class='text-center' style="color:#fff; width:10%;">Localidad</th>
                                        <th class='text-center' style="color: #fff; width:5%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($obras as $obra)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$obra->num_obr}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$obra->nom_obr}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$obra->expedte}}</td>

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
                                                                {{-- {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.show',$obra->id_obr], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Ver', ['class' => 'btn btn-warning w-100']) !!}
                                                                {!! Form::close() !!} --}}
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                @can('EDITAR-ITEMOBRA')
                                                                    {!! Form::open(['method' => 'GET', 'route' => ['itemizado_obra.edit', $obra->id_obr], 'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Editar Items', ['class' => 'btn btn-primary mb-2 w-100']) !!}
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
        {{-- <div class="">
            <strong>
                <h7>
                    ¿Dudas? <a href="{{ asset('storage/gdu/ObrasViviendas.pdf') }}" style="color: rgb(30, 67, 233)" target="_blank">Descargue un instructivo aqui.</a> 
                </h7>
            </strong>
        </div> --}}
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