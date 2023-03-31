@extends('layouts.app')

@section('content')

@include('layouts.modal.delete', ['modo' => 'Agregar']) 
    <section class="section">
        {{--section header--}}
        <div class="section-header">
            <h3 class="page__heading">Pat Almacen</h3>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        {{--section body--}}
        <div class="section-body"> 
                
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-2">
                        @can('CREAR-ALMACEN')
                            {!! Form::open(['method' => 'GET', 'route' => ['p_almacen.create'], 'class' => 'd-flex justify-content-end']) !!}
                                {!! Form::submit('Nuevo Almacen', ['class' => 'btn btn-success my-1']) !!}
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
                                <th style="color:rgb(20, 20, 20)">Abreviatura</th>
                                <th style="color:rgb(20, 20, 20);">Domicilio</th>
                                <th style="color:rgb(20, 20, 20);">Sector</th>
                                <th style="color:rgb(20, 20, 20);">Acción</th>
                                <th style="color:rgb(20, 20, 20);">Imagen</th>
                            </thead>
                            <tbody>
                                @foreach ($almacen as $pAlmacen)
                                    <tr>                                        
                                        <td> {{$pAlmacen->nom_almacen}} </td>
                                        <td> {{$pAlmacen->abr_almacen}} </td>
                                        <td> {{$pAlmacen->dom_almacen}} </td>
                                        @if($pAlmacen->fk_sector ==null)
                                            <td>Sin asignar</td>
                                        @else
                                        @foreach ($sectores as $s)
                                            @if($s->id_sector == $pAlmacen->fk_sector)
                                                <td>{{$s->nom_sector}}</td>
                                            @endif
                                        @endforeach       
                                        @endif                 
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @can('EDITAR-ALMACENES')
                                                    {!! Form::open(['method' => 'GET', 
                                                                    'route' => ['almacen.editar', $pAlmacen], 
                                                                    'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                                @can('EDITAR-ALMACENES')
                                                    {!! Form::open(['method' => 'GET', 
                                                                    'route' => ['almacen.asignar', $pAlmacen], 
                                                                    'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Asignar Sector', ['class' => 'btn btn-primary mr-2']) !!}
                                                    {!! Form::close() !!}
                                                @endcan

                                                @can('BORRAR-ALMACENES')
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalLong">
                                                    Borrar
                                                    </button>
                                                    
                                                    
                                                @endcan
                                            </div>                                        
                                        <td>                                                
                                            <div class="d-flex justify-content-center">  
                                                @can('EDITAR-ALMACENES')
                                                    {!! Form::open(['method' => 'GET', 
                                                                    'route' => ['almacen.imagen', $pAlmacen], 
                                                                    'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Ver', ['class' => 'btn btn-primary mr-2']) !!}
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
    
    <div class="modal hide fade in" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">¡Atención!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea borrar? Esta acción no puede deshacerse.</p>
                </div>
                <div class="modal-footer">                                        
                    {!! Form::open([
                        'method' => 'DELETE',
                        'class' => 'formulario',
                        'route' => ['almacen.eliminar', $pAlmacen->id_almacen],
                        'style' => 'display:inline',
                        ]) !!}
                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

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