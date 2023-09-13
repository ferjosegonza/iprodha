@extends('layouts.app')

@section('content')  
    <section class="section">
        <div class="section-header d-flex">
                <div class="">
                    <div class="titulo page__heading">Ofertas de Obras</div>
                </div>
                <div class="">
                    @include('layouts.favorito.fav', ['modo' => 'Agregar'])
                </div>
                
                <div class="ms-auto">
                    @can('CREAR-OFEOBRA')
                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                        {!! Form::submit('Crear Oferta', ['class' => 'float-right btn  btn-success mt-2 ']) !!}
                        {!! Form::close() !!}
                    @endcan 
                </div>
        </div>
        <div class="section-body">
            
            <div class="row">
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
                                        <th class= 'text-center' scope="col" style="color:#fff;width:3%;">Obra</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:25%;">Nombre Obra</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:5%;">Plazo</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:10%;">Expediente</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:10%;">Empresa</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:10%;">Total</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:10%;">Estado</th>
                                        <th class= 'text-center' scope="col" style="color:#fff;width:20%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 1;
                                        @endphp
                                        @foreach ($Ofertas as $unaOferta)
                                            <tr>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->idobra }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ substr($unaOferta->nomobra, 0, 35) }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->plazo }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->getExpediente->exp_numero ?? '' }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ substr($unaOferta->getEmpresa->nom_emp, 0, 20) }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    @php
                                                        $costoAcu = 0;
                                                        foreach ($unaOferta->getCronogramaDesem as $desembolso) {
                                                            $costoAcu += $desembolso->costo;
                                                        }
                                                    @endphp
                                                    @money($costoAcu)
                                                </td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">
                                                    {{ $unaOferta->getEstados->sortByDesc('actual')->first()->getEstado->denestado }}
                                                </td>
                                                <td class='text-center' style="overflow: hidden;">
                                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                        @can('EDITAR-OFEOBRA')
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.edit', base64url_encode($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning m-1']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                        {{-- @can('BORRAR-OFEOBRA')
                                                            {!! Form::open([
                                                            'method' => 'DELETE','route' => ['ofeobra.destroy', $unaOferta->idobra],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger m-1','onclick' => "return confirm('Estas seguro que desea ELIMINAR la oferta??')",]) !!}
                                                            {!! Form::close() !!}
                                                        @endcan --}}

                                                        @can('VER-OFEOBRA')
                                                            {!! Form::open([
                                                            'method' => 'GET','route' => ['ofeobra.show', base64url_encode($unaOferta->idobra)],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Ver', ['class' => 'btn btn-primary m-1']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                        
                                                        <button type="button" class="btn btn-info m-1 rounded" data-toggle="collapse" data-target="#demo{{$cont}}">Detalle <i class="fas fa-caret-down"></i></button> 
                                                    </div>
                                                            <div id="demo{{$cont}}" class="collapse pt-1">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitems.itemsoferta',base64url_encode($unaOferta->idobra)],'style' => '']) !!}
                                                                        {!! Form::submit('Items', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.indexx', base64url_encode($unaOferta->idobra)],'style' => '']) !!}
                                                                        {!! Form::submit('Sombrero', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-5">
                                                                        @can('VER-CRONOGRAMAOBRA')
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofecrono.porc',base64url_encode($unaOferta->idobra)],'style' => '']) !!}
                                                                            {!! Form::submit('Cronograma', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}                                  
                                                                        @endcan
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-2">
                                                                <div class="col">

                                                                    @if ((auth()->user()->hasRole('EMPRESA') or auth()->user()->hasRole('OFEOBRA')) and $unaOferta->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.presentar',base64url_encode($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Presentar Oferta', ['class' => 'btn btn-success', 'style' => 'width: 85%']) !!}
                                                                        {!! Form::close() !!}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row btn-group-lg">
                                                                
                                                                @if ($unaOferta->getEstados->sortByDesc('actual')->first()->getEstado->idestado == 2)
                                                                    <div class="col-12 m-0 p-0 pe-1">
                                                                        @can('VALIDAR-OFEOBRA')
                                                                            {!! Form::open(['method' => 'GET', 'class' => 'validacion', 'route' => ['ofeobra.vervalidar',base64url_encode($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                                {!! Form::submit('Validar', ['class' => 'btn btn-success', 'style' => 'width: 79%']) !!}
                                                                            {!! Form::close() !!}                                 
                                                                        @endcan
                                                                    </div>             
                                                                @endif
                                                                
                                                            </div>
                                                </td>
                                            </tr>
                                            @php
                                                $cont = $cont + 1;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>             
            </div>
        </div>
        <div class="">
            <strong>
                <h7>
                    ¿Dudas? <a href="{{ asset('storage/gdu/OfertaObraEmp.pdf') }}" style="color: rgb(30, 67, 233)" target="_blank">Descargue un instructivo aqui.</a> 
                </h7>
            </strong>
        </div>
    </section>
    {{-- @include('layouts.modal.confirmation')  --}}
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
                 order: [[ 0, 'desc' ]],
            });
            });
    </script>
    {{-- <script src="{{ asset('js/Obrasyfinan/Ofertas/index_oferta.js') }}"></script> --}}
@endsection