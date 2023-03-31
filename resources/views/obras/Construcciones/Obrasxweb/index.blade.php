@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Obras Autorizadas para WEB</h3>
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
                                    <form method="GET" action="{{route('obraweb.index')}}">
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
                            <div class="">
                                <table id="example" class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        {{-- <th style="color:#fff;">ID</th> --}}
                                        <th style="color:#fff;">N°</th>
                                        <th style="color:#fff;">N°2</th>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">Empresa</th>
                                        <th style="color:#fff;">Localidad</th>
                                        <th style="color:#fff;">Foja</th>
                                        <th style="color: #fff">Cupo</th>
                                        <th style="color: #fff">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Obras as $Obra)
                                            <tr class='align-item-center'>
                                                {!! Form::open(['method' => 'GET','route' => ['obraweb.edit', $Obra->id_obr],'style' => 'display:inline']) !!}
                                                <td>{{$Obra->num_obr}}</td>
                                                <td>{{$Obra->num_obr1}}</td>     
                                                <td>{{$Obra->nom_obr}}</td>
                                                <td>{{$Obra->nom_emp}}</td>
                                                <td>{{$Obra->nom_loc}}</td>
                                                <td style="width: 80px">
                                                    {!! Form::select('foja', ['0' => 'No', '1' => 'Si'], $Obra->foja, ['class'=>'form-select', 'id'=>'', 'required']) !!}                                               
                                                </td>
                                                <th style="width: 80px">
                                                    {!! Form::select('cupo', ['0' => 'No', '1' => 'Si'], $Obra->cupo, ['class'=>'form-select', 'id'=>'', 'required']) !!}
                                                </th>
                                                <td>
                                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                                    {!! Form::close() !!}
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