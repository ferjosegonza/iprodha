@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="me-auto">
                <div class="titulo">Conceptos Sombrero - Obra: <strong>{{$unaObra->nomobra}}</strong></div>
            </div>
            <div class="px-1">
                @if ($unaObra->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.editar', $unaObra]]) !!}
                {!! Form::submit('Edición de Conceptos', ['class' => 'btn  btn-warning mt-2 ']) !!}
                {!! Form::close() !!}
                @endif
            </div>
            <div class="px-1">
                @if ($unaObra->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.crear', $unaObra]]) !!}
                {!! Form::submit('Asignar Conceptos', ['class' => 'btn  btn-success mt-2']) !!}
                {!! Form::close() !!}
                @endif
            </div>      
        </div>
        {{-- <div class="section-header">
            <div class="titulo py-1">Conceptos Sombrero - Obra: <strong>{{$unaObra->nomobra}}</strong></div>
            {{-- <h5>Conceptos Sombrero - Obra: {{ $unaObra->nomobra }}</h5>
        </div> --}}
        <div class="section-body">
            <div class="row">                
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example" class="table table-hover mt-2">
                                <thead>
                                    <th scope="col" style="color:#fff;width:40%; text-align: center;">Conc. Sombrero</th> 
                                    <th scope="col" style="color:#fff;width:5%; text-align: center; ">Valor</th> 
                                    <th scope="col" style="color:#fff;width:20%; text-align: center;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ( $unaObra->getSombrero as $sombrero )
                                    <tr>
                                        <td>{{ $sombrero->getConceptoSombrero->conceptosombrero}}</td>
                                        <td style="text-align: right;">{{ $sombrero->formattedvalor }}</td>
                                        <td >
                                            
                                        {{--!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombrero.edit',$unaObra->idobra],'style' => 'padding-left:10%; display:inline']) !!}
                                                {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                            {!! Form::close() !!--}}
                                            @if ($unaObra->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                                            {!! Form::open([
                                                'method' => 'DELETE','route' => ['ofesombreroxobra.eliminar', $sombrero->idobra,$sombrero->idconceptosombrero],'style' => 'display:inline;',]) !!}
                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('Estas seguro que desea ELIMINAR el Concepto??')",]) !!}
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                

                {{-- <div class="pagination justify-content-end">
                    {!! $Ofertas->links() !!}
                </div> --}}
            </div>
            <div class="d-flex justify-content-start">
                {{-- <div style="margin-left:1%;">
                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.editar', $unaObra]]) !!}
                    {!! Form::submit('Edición de Conceptos', ['class' => 'btn  btn-warning mt-2 ']) !!}
                {!! Form::close() !!}
                </div>
                <div style="margin-left:1%;">
                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.crear', $unaObra]]) !!}
                    {!! Form::submit('Asignar Conceptos', ['class' => 'btn  btn-success mt-2']) !!}
                {!! Form::close() !!}                
                </div> --}}
                <div style="margin-left:1%;">
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