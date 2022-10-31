@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3>Ofertas de Obras</h3>
        </div>
        <div class="section-body">
            <div class="row " >
                @include('layouts.modal.mensajes')
                <a href="#barra" class="btn btn-warning mb-3" data-toggle="collapse">Buscar...</a>
                <div id="barra" class="collapse in">
                    <div>
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                                <div style="width:90%;float:left;margin-left:1%;">
                                    <div class="col-md-3 col-lg-6 mb-3">
                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.index']]) !!}
                                            {!! Form::text('name', null, ['placeholder' => 'Buscar Oferta', 'class' => 'form-control mb-2']) !!}
                                            {!! Form::submit('Buscar', ['class' => 'btn  btn-primary  ']) !!}
                                        {!! Form::close() !!}
                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                                            {!! Form::submit('Crear', ['class' => 'btn  btn-warning mt-2 ']) !!}
                                        {!! Form::close() !!}
                                        {{-- <div class="pagination justify-content-end">
                                            {!! $Ofertas->links() !!}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-hover mt-2">
                    <thead style="background-color:#6d7cf1;">
                        <th scope="col" style="color:#fff;width:8%;">Obra</th>
                        <th scope="col" style="color:#fff;width:30%;">Nombre Obra</th>
                        <th scope="col" style="color:#fff;width:5%;">Plazo</th>
                        <th scope="col" style="color:#fff;width:15%;">Expediente</th>
                        <th scope="col" style="color:#fff;width:20%;">Empresa</th>
                        <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($Ofertas as $unaOferta)
                            <tr>
                                <td>{{ $unaOferta->idobra }}</td>
                                <td>{{ substr($unaOferta->nomobra, 0, 35) }}</td>
                                <td>{{ $unaOferta->plazo }}</td>
                                <td>{{ $unaOferta->exp_numero }}</td>
                                <td>{{ substr($unaOferta->nom_emp, 0, 20) }}</td>
                                <td>
                                    <a class="btn btn-info"
                                        href="{{ route('ofeobra.edit', $unaOferta->idobra) }}">Editar</a>
                                    {!! Form::open([
                                        'method' => 'DELETE','route' => ['ofeobra.destroy', $unaOferta->idobra],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('Estas seguro que desea ELIMINAR la oferta??')",]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="pagination justify-content-end">
                    {!! $Ofertas->links() !!}
                </div> --}}
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