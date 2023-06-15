@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo py-1">Subitems - Item: <strong>{{ $unItem->nom_item }}</strong>   Obra: <strong>{{ $unaObra->nomobra}}</strong></div>
            </div>
            <div class="ms-auto">
                @if ($unaObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' =>['ofeobraitemdet.crear', base64url_encode($unItem->iditem)]]) !!}
                    {!! Form::submit('Crear Sub-Item', ['class' => 'btn  btn-success mt-2 ']) !!}
                    {!! Form::close() !!}
                @endif
            </div>  
        </div>
        <div class="section-body">
            <div class="row" >
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}   
                            </div> --}}
                            <div class="table-responsive">
                                <table id="example" class="table table-hover mt-2">
                                    <thead>                     
                                        <th class="text-center" scope="col" style="color:#fff;width:25%;">Denominación</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Unidad</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Cantidad</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Costo Unitario</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Costo Sub-Item</th>
                                        @if ($unaObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                        <th class="text-center" scope="col" style="color:#fff;width:30%;">Acciones</th>
                                        @endif
                                    </thead>
                                    <tbody>                        
                                        @foreach ($subitemxitem as $unSubItem)
                                            <tr>
                                                <td class="text-center" style="vertical-align: middle;">{{ $unSubItem->denominacion }}</td>                                
                                                <td class="text-center" style="vertical-align: middle;">{{ $unSubItem->getUnidad->unidad }}</td>
                                                <td class="text-center" style="vertical-align: middle;">{{ number_format($unSubItem->cantidad,2, ',', '.') }}</td>
                                                <td class="text-center" style="vertical-align: middle;">@money($unSubItem->costounitario)</td>
                                                <td class="text-center" style="vertical-align: middle;">@money($unSubItem->cantidad * $unSubItem->costounitario)</td>
                                                @if ($unaObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                                <td class="text-center" style="vertical-align: middle;">
                                                        {!! Form::open(['method' => 'GET','route' => ['ofeobraitemdet.edit', base64url_encode($unSubItem->idsubitem)],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                                        {!! Form::close() !!}

                                                        {!! Form::open([
                                                            'method' => 'DELETE','route' => ['ofeobraitemdet.destroy', $unSubItem->idsubitem],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('¿Está seguro que desea ELIMINAR el subitem?')",]) !!}
                                                        {!! Form::close() !!}
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>    
                
             
                    {!! Form::open(['method' => 'GET', 'route' => ['ofeobraitems.itemsoferta', base64url_encode($unaObra->idobra)], 'style' => 'display:inline']) !!}
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