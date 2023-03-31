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
                    @can('CREAR-OBRA')
                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                        {!! Form::submit('Crear Oferta', ['class' => 'float-right btn  btn-success mt-2 ']) !!}
                        {!! Form::close() !!}
                    @endcan 
                </div>
            
            {{-- <div class="titulo page__heading">Ofertas de Obras</div>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
            @can('CREAR-OBRA')
                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                {!! Form::submit('Crear', ['class' => 'float-right btn  btn-success mt-2 ']) !!}
                {!! Form::close() !!}
            @endcan   --}}
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
                                        {{-- <th class= 'text-center'>
                                            @can('CREAR-OBRA')
                                                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.create']]) !!}
                                                {!! Form::submit('Crear', ['class' => 'btn  btn-success mt-2 ']) !!}
                                                {!! Form::close() !!}
                                            @endcan           
                                        </th> --}}
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
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->getExpediente->exp_numero }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ substr($unaOferta->getEmpresa->nom_emp, 0, 20) }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    {{-- {{ $unaOferta->monviv+$unaOferta->montotope+$unaOferta->moninf+ $unaOferta->monnex+$unaOferta->monterr }} --}}
                                                    @money($unaOferta->monviv+$unaOferta->montotope+$unaOferta->moninf+ $unaOferta->monnex+$unaOferta->monterr)
                                                </td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">
                                                    {{-- $Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 1 --}}
                                                    {{ $unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->denestado }}
                                                </td>
                                                <td class='text-center' style="overflow: hidden;">
                                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                        {{-- <button type="button" class="btn btn-warning" onclick="window.location='{{ URL::route('ofeobra.edit', encrypt($unaOferta->idobra));}}'">Editar</button> --}}
                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.edit',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning m-1']) !!}
                                                        {!! Form::close() !!}

                                                        @can('BORRAR-OFEOBRA')
                                                        {!! Form::open([
                                                            'method' => 'DELETE','route' => ['ofeobra.destroy', $unaOferta->idobra],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger m-1','onclick' => "return confirm('Estas seguro que desea ELIMINAR la oferta??')",]) !!}
                                                        {!! Form::close() !!}
                                                        @endcan
                                                        {{-- <button type="button" class="btn btn-primary">Borrar</button> --}}
                                                      
                                                        {{-- <div class="btn-group" role="group"> --}}
                                                            {{-- <input class="btn btn-info m-1 rounded" type="button" value="Detalle"  data-toggle="collapse" data-target="#demo"> --}}
                                                            <button type="button" class="btn btn-info m-1 rounded" data-toggle="collapse" data-target="#demo{{$cont}}">Detalle <i class="fas fa-caret-down"></i></button>
                                                        {{-- </div> --}}
                                                    </div>
                                                    
                                                            <div id="demo{{$cont}}" class="collapse pt-1">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitems.itemsoferta',encrypt($unaOferta->idobra)],'style' => '']) !!}
                                                                        {!! Form::submit('Items', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.indexx',$unaOferta->idobra],'style' => '']) !!}
                                                                        {!! Form::submit('Sombrero', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-5">
                                                                        @can('VER-CRONOGRAMAOBRA')
                                                                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofecrono.edit',encrypt($unaOferta->idobra)],'style' => '']) !!}
                                                                            {!! Form::submit('Cronograma', ['class' => 'btn btn-primary']) !!}
                                                                        {!! Form::close() !!}                                  
                                                                        @endcan
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-2">
                                                                <div class="col">
                                                                    @if (auth()->user()->hasRole('EMPRESA') and $unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.presentar',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Presentar Oferta', ['class' => 'btn btn-success', 'style' => 'width: 60%']) !!}
                                                                        {!! Form::close() !!}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row btn-group-lg">
                                                                @if ($unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->idestado == 2)
                                                                    <div class="col-12 m-0 p-0 pe-1">
                                                                        @can('BORRAR-OFEOBRA')
                                                                            {!! Form::open(['method' => 'GET', 'class' => 'validacion', 'route' => ['ofeobra.vervalidar',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                                {!! Form::submit('Validar', ['class' => 'btn btn-success', 'style' => 'width: 79%']) !!}
                                                                            {!! Form::close() !!}                                 
                                                                        @endcan
                                                                    </div>             
                                                                @endif
                                                                
                                                            </div>

                                                    {{-- <h2>Simple Collapsible</h2>
                                                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Detalle <i class="fas fa-caret-down"></i></button>
                                                    <div id="demo" class="collapse">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                                    </div> --}}
                                                </td>
                                                {{-- <td class='text-center' style="overflow: hidden;">
                                                    <div class="row pb-2 btn-group-lg">
                                                        <div class="col-4  m-0 p-0 pe-1">
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.edit',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="col-4  m-0 p-0 pe-1">
                                                            @can('BORRAR-OFEOBRA')
                                                                {!! Form::open([
                                                                    'method' => 'DELETE','route' => ['ofeobra.destroy', $unaOferta->idobra],'style' => 'display:inline',]) !!}
                                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100','onclick' => "return confirm('Estas seguro que desea ELIMINAR la oferta??')",]) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </div>
                                                        <div class="col-4  m-0 p-0">
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitems.itemsoferta',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Items', ['class' => 'btn btn-primary w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                    <div class="row pb-2 btn-group-lg">                                                       
                                                        <div class="col-6 m-0 p-0 pe-1">
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofesombreroxobra.indexx',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Sombrero', ['class' => 'btn btn-primary w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="col-6 m-0 p-0">
                                                            @can('VER-CRONOGRAMAOBRA')
                                                                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofecrono.edit',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Cronograma', ['class' => 'btn btn-primary w-100']) !!}
                                                                {!! Form::close() !!}                                  
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="row pb-1 btn-group-lg">
                                                        <div class="col-6 m-0 p-0 pe-1">
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['estadosxobra.index',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Ver estados', ['class' => 'btn btn-primary w-200']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>   
                                                    <div class="row pb-2 btn-group-lg">
                                                        <div class="col m-0 p-0">
                                                            @if (auth()->user()->hasRole('EMPRESA') and $unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->idestado < 2)
                                                                {!! Form::open(['method' => 'GET', 'class' => 'formulario', 'route' => ['ofeobra.presentar',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Presentar Oferta', ['class' => 'btn btn-success w-100']) !!}
                                                                {!! Form::close() !!}
                                                            @endif
                                                            {{-- @can('VER-CRONOGRAMAOBRA')
                                                                {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofecrono.edit',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                    {!! Form::submit('Presentar Oferta', ['class' => 'btn btn-success w-100']) !!}
                                                                {!! Form::close() !!}                                  
                                                            @endcan 
                                                        </div>
                                                    </div>
                                                    <div class="row btn-group-lg">
                                                        @if ($unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->idestado == 2)
                                                            <div class="col-6 m-0 p-0 pe-1">
                                                                @can('BORRAR-OFEOBRA')
                                                                    {!! Form::open(['method' => 'GET', 'class' => 'validacion', 'route' => ['ofeobra.validar',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Validar', ['class' => 'btn btn-success w-100']) !!}
                                                                    {!! Form::close() !!}                                  
                                                                @endcan
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                @can('BORRAR-OFEOBRA')
                                                                    {!! Form::open(['method' => 'GET', 'class' => 'rechazar', 'route' => ['ofeobra.rechazar',encrypt($unaOferta->idobra)],'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Rechazar', ['class' => 'btn btn-danger w-100']) !!}
                                                                    {!! Form::close() !!}                                  
                                                                @endcan
                                                            </div>
                                                        @endif
                                                        
                                                    </div>   
                                                </td> --}}
                                            </tr>
                                            @php
                                                $cont = $cont + 1;
                                            @endphp
                                            {{-- {{$cont = $cont + 1;}} --}}
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
                order: [[ 1, 'asc' ]],
            });
            });
    </script>
    {{-- <script src="{{ asset('js/Obrasyfinan/Ofertas/index_oferta.js') }}"></script> --}}
@endsection