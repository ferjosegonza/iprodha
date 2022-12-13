@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cupos para Obras</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                {{-- {{var_dump($cargaCupos)}} --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="row">
                                    <form method="GET" action="{{route('cupoobra.index')}}">
                                        <div class="input-group">
                                            <input name="numero" type="text" class="form-control" placeholder="Buscar por numero de Obra" aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}   
                            </div> --}}
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        {{-- <th style="color:#fff;">ID</th> --}}
                                        <th style="color:#fff;">N°</th>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">Año</th>
                                        <th style="color:#fff;">Mes</th>
                                        <th style="color: #fff">Periodo</th>
                                        <th style="color: #fff">Monto</th>
                                        <th style="color: #fff">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Obras as $Obra)
                                            <tr class='align-item-center'>
                                                {{-- <td>{{$Obra->id_obr}}</td> --}}
                                                {{-- {!! Form::open(array('route' => 'cupo_obra.edit','method'=>'POST', 'enctype'=>'multipart/form-data')) !!} --}}
                                                {!! Form::open(['method' => 'GET','route' => ['cupoobra.edit', $Obra->id_obr],'style' => 'display:inline']) !!}
                                                <td>{{$Obra->num_obr}}</td>
                                                <td>{{$Obra->nom_obr}}</td>     
                                                <td>{{$Obra->aÑo}}</td>
                                                <td>{{$Obra->mes}}</td>
                                                <td>{{$Obra->periodo_o}}</td>
                                                <td>
                                                    <input class="form-control" type="text" name="cupo" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="@money($Obra->cupo)" data-type="currency">
                                                </td>
                                                <th>
                                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                                    {!! Form::close() !!}
                                                </th>
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

{{-- <script src="{{ asset('js/tarea/index_tarea.js') }}"></script> --}}
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
<script src="{{ asset('js/Obras/Construcciones/cupoxobra/index_cupoxobra.js') }}"></script>
    
@endsection