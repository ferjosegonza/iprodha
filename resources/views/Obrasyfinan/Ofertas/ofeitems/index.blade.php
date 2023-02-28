@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo">Items de la obra: {{$laObra->nomobra}}</div>
        </div>
        <div class="section-body">
            <div class="row " >
                @include('layouts.modal.mensajes')
                <table id="example" class="table table-hover mt-2">
                    <thead style="background-color:#6d7cf1;">
                        <th scope="col" style="color:#fff;width:5%;">Orden</th>
                        <th scope="col" style="color:#fff;width:5%;">Código</th>
                        <th scope="col" style="color:#fff;width:5%;">Tipo</th>
                        <th scope="col" style="color:#fff;width:30%;">Denom.Item</th>
                        <th scope="col" style="color:#fff;width:5%;">Costo</th>
                        <th scope="col" style="color:#fff;width:15%;">Porc. Inc.</th>
                        <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                        <th>                    
                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' =>['ofeobraitems.crear',$laObra]]) !!}
                            {!! Form::submit('Crear', ['class' => 'btn  btn-success mt-2 ']) !!}
                            {!! Form::close() !!}</th>
                    </thead>
                    <tbody>

                        @foreach ($itemsxobra as $unItem)
                            <tr>
                                <td>{{ $unItem->orden }}</td>
                                <td>{{ $unItem->codigo }}</td>
                                <td>{{ $unItem->cod_tipo }}</td>
                                <td>{{ substr($unItem->nom_item, 0, 35) }}</td>                                
                                <td>{{ $unItem->costo }}</td>
                                <td>{{ $unItem->por_inc }}</td>
                                <td>
                                    {!! Form::open(['method' => 'GET','route' => ['ofeobraitems.edit', $unItem->iditem],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                    {!! Form::close() !!}                                    
                                    {!! Form::open([
                                        'method' => 'DELETE','route' => ['ofeobraitems.eliminar',$unItem->iditem],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('Estas seguro que desea ELIMINAR el item??')",]) !!}
                                    {!! Form::close() !!}

                                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitemdet.detalleitem',$unItem],'style' => 'display:inline']) !!}
                                        {!! Form::submit('Sub Items', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Volver', ['class' => 'btn btn-primary mt-2']) !!}
                    {!! Form::close() !!}                    
            </div>
        </div>
    </section>
@endsection

@section('js')
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
                order: [[ 1, 'asc' ]],
            });
            });
    </script>
@endsection