@extends('layouts.app')
@section('css')
    
    <link rel="stylesheet" href="{{ asset('css/Obrasyfinan/ofeobra.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h5>Ofertas de Obras</h5>
        </div>
        <div class="section-body">
            <div class="row " >
                @include('layouts.modal.mensajes')          
                <table id="example" class="table table-hover mt-2">                    
                    <thead style="background-color:#f1c383;">
                        <th scope="col" style="color:#fff;width:8%;">Obra</th>
                        <th scope="col" style="color:#fff;width:25%;">Nombre Obra</th>
                        <th scope="col" style="color:#fff;width:5%;">Plazo</th>
                        <th scope="col" style="color:#fff;width:15%;">Expediente</th>
                        <th scope="col" style="color:#fff;width:18%;">Empresa</th>
                        <th scope="col" style="color:#fff;width:40%;">Acciones</th>
                        <th>
                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                            {!! Form::submit('Crear', ['class' => 'btn  btn-success mt-2 ']) !!}
                            {!! Form::close() !!}
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($Ofertas as $unaOferta)
                            <tr>
                                <td>{{ $unaOferta->idobra }}</td>
                                <td>{{ substr($unaOferta->nomobra, 0, 35) }}</td>
                                <td>{{ $unaOferta->plazo }}</td>
                                <td>{{ $unaOferta->getExpediente->exp_numero }}</td>
                                <td>{{ substr($unaOferta->getEmpresa->nom_emp, 0, 20) }}</td>
                                <td>
                                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.edit',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                    {!! Form::close() !!}
                                        
                                    {!! Form::open([
                                        'method' => 'DELETE','route' => ['ofeobra.destroy', $unaOferta->idobra],'style' => 'display:inline',]) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('Estas seguro que desea ELIMINAR la oferta??')",]) !!}
                                    {!! Form::close() !!}
                                    
                                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitems.itemsoferta',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                        {!! Form::submit('Items', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}

                                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.indexx',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                        {!! Form::submit('Sombrero', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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