@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <a><strong>Subitems - Item: {{ $unItem->nom_item }}  Obra: {{ $unaObra->nomobra}}</strong></a>
        </div>
        <div class="section-body">
            <div class="row " >
                @include('layouts.modal.mensajes')
                <table id="example" class="table table-hover mt-2">
                    <thead style="background-color:#6d7cf1;">
                        <th scope="col" style="color:#fff;width:5%;">Obra</th>
                        <th scope="col" style="color:#fff;width:10%;">Item</th>                        
                        <th scope="col" style="color:#fff;width:25%;">Denominación</th>
                        <th scope="col" style="color:#fff;width:15%;">Unidad</th>
                        <th scope="col" style="color:#fff;width:5%;">Cantidad</th>
                        <th scope="col" style="color:#fff;width:15%;">Costo Unitario</th>
                        <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                    </thead>
                    <tbody>                        
                        @foreach ($subitemxitem as $unSubItem)
                            <tr>
                                <td>{{ $unSubItem->idobra }}</td>
                                <td>{{ $unSubItem->iditem }}</td>
                                <td>{{ $unSubItem->denominacion }}</td>                                
                                <td>{{ $unSubItem->getUnidad->unidad }}</td>
                                <td>{{ $unSubItem->cantidad }}</td>
                                <td>{{ $unSubItem->costounitario }}</td>
                                <td>
                                    
                                    {!! Form::open(['method' => 'GET','route' => ['ofeobraitemdet.editar',$unSubItem->idsubitem,$unItem->iditem ],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                    {!! Form::close() !!}                                    
                                    {!! Form::open([
                                        'method' => 'DELETE','route' => ['ofeobraitemdet.eliminar',$unSubItem->idsubitem,$unItem->iditem],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('Estas seguro que desea ELIMINAR el item??')",]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' =>['ofeobraitemdet.crear',$unItem->iditem]]) !!}
                    {!! Form::submit('Crear', ['class' => 'btn  btn-warning mt-2 ']) !!}
                    {!! Form::close() !!}                
                    {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta',$unaObra->idobra], 'style' => 'display:inline']) !!}
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