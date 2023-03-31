@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar']) 
    <section class="section">   
        <div class="section-header">
            <h3 class="page__heading">Sector</h3>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-2">
                        @can('CREAR-SECTOR')
                            {!! Form::open(['method' => 'GET', 'route' => ['sector.create'], 'class' => 'd-flex justify-content-end']) !!}
                                {!! Form::submit('Nuevo Sector', ['class' => 'btn btn-success my-1']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mt-2 dataTables-example display" id="example">
                            <thead style="height:50px;">
                                <th style="color:rgb(20, 20, 20);">Nombre</th>
                                <th style="color:rgb(20, 20, 20)">Descripción</th>
                                <th style="color:rgb(20, 20, 20)">Acción</th>
                            </thead>
                            <tbody>
                                @foreach ($sectores as $sector)
                                    <tr>                                        
                                        <td> {{$sector->nom_sector}} </td>
                                        <td> {{$sector->desc_sector}} </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @can('EDITAR-SECTORES')
                                                    {!! Form::open(['method' => 'GET', 'route' => ['sector.editar', $sector], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                    {!! Form::close() !!}
                                                @endcan

                                                @can('BORRAR-SECTORES')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'class' => 'formulario',
                                                        'route' => ['sector.eliminar', $sector->id_sector],
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
            <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display: none">
                <div class="card">
                    <div id='contenido' class="card-body">
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