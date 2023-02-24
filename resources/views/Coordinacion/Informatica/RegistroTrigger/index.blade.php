@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar'])
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registro de Trigger</h3>
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
                                        <form method="GET" action="{{route('regtrigger.index')}}">
                                            <div class="input-group mb-3">
                                                <input name="name" type="text" class="form-control" placeholder="Buscar Tabla" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5 my-auto">
                                    
                                </div>
                                
                                <div class="col-lg-2">
                                    @can('CREAR-REGTRIGGER')
                                        {!! Form::open(['method' => 'GET', 'route' => ['regtrigger.create'], 'class' => 'd-flex justify-content-end']) !!}
                                            {!! Form::submit('Nuevo Registro', ['class' => 'btn btn-success my-1']) !!}
                                        {!! Form::close() !!}
                                    @endcan
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
                                <table class="table table-striped mt-2" id="example">
                                    <thead style="height:50px;">
                                        <th class='ml-3 text-center' style="color:#fff;">Codigo</th>
                                        <th class='text-center' style="color:#fff;">Esquema</th>
                                        <th class='text-center' style="color: #fff;">Tabla</th>
                                        <th class='text-center' style="color: #fff;">Nom. Logs. Esquema</th>
                                        <th class='text-center' style="color: #fff;">Nom. Logs. Tabla</th>
                                        <th class='text-center' style="color: #fff;">Creacion</th>
                                        <th class='text-center' style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($regtriggers as $regtrigger)
                                            <tr>
                                                <td class='text-center align-middle'>{{$regtrigger->id}}</td>

                                                <td class='text-center align-middle'>{{$regtrigger->origen_esquema}}</td>

                                                <td class='text-center align-middle'>{{$regtrigger->origen_tabla}}</td>

                                                <td class='text-center align-middle'>{{$regtrigger->log_esquema}}</td>

                                                <td class='text-center align-middle'>{{$regtrigger->log_tabla}}</td>

                                                <td class='text-center align-middle'>{{$regtrigger->creacion}}</td>

                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        @can('VER-REGTRIGGER')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['regtrigger.show', $regtrigger->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Ver', ['class' => 'btn btn-warning mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('EDITAR-REGTRIGGER')
                                                            {!! Form::open(['method' => 'GET', 'route' => ['regtrigger.edit', $regtrigger->id], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-REGTRIGGER')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['regtrigger.destroy', $regtrigger->id],
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