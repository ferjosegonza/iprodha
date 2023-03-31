@extends('layouts.app')

@section('content')  

@include('layouts.modal.delete', ['modo' => 'Agregar'])

    <section class="section">
        <div class="section-header d-flex">
                    <div class="titulo page__heading">Estados de las Ofertas de Obras</div>
                
                <div class="">
                    @include('layouts.favorito.fav', ['modo' => 'Agregar'])
                </div>
        </div>
        <div class="section-body">            
            <div class="row">
                @include('layouts.modal.mensajes')
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3 my-auto">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                        <div class="row justify-content-evenly align-items-evenly">
                                            <form method="GET" action="{{route('estadosxobra.buscar')}}">
                                                <div class="input-group mb-3">
                                                    <input name="name" type="text" class="form-control" placeholder="Buscar Obra [Ingrese el nombre de la obra]" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                    <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <div class="col-lg-5 my-auto">                                        
                                </div>                                    
                                <div class="col-lg-2">                                        
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
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
                                        @foreach ($Ofertas as $unaOferta)
                                            <tr>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->idobra }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ substr($unaOferta->nomobra, 0, 35) }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->plazo }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ $unaOferta->getExpediente->exp_numero }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">{{ substr($unaOferta->getEmpresa->nom_emp, 0, 20) }}</td>
                                                <td class= 'text-center' style="vertical-align: middle;">
                                                    @money($unaOferta->monviv+$unaOferta->montotope+$unaOferta->moninf+ $unaOferta->monnex+$unaOferta->monterr)
                                                </td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">
                                                    {{ $unaOferta->getEstados->sortByDesc('idestado')->first()->getEstado->denestado }}
                                                </td>
                                                <td class='text-center' style="overflow: hidden;">
                                                    <div class="row pb-1 btn-group-lg">
                                                        <div class="m-0 p-0 pe-1">
                                                            {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['estadosxobra.verestados',$unaOferta->idobra],'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Ver estados', ['class' => 'btn btn-primary w-200']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>   
                                                </td>
                                            </tr>
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
    @include('layouts.modal.confirmation') 
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
    <script src="{{ asset('js/Obrasyfinan/Ofertas/index_oferta.js') }}"></script>
@endsection