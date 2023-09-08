@extends('layouts.app')
@section('content')
<style>
     .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 500px; /* gives an initial height of 200px to the table */
      }
      .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
      }
      #viv table {
        border-collapse: collapse; /* make the table borders collapse to each other */
        width: 100%;
      }
      /* #viv th,
      #viv td {
        padding: 8px 16px;
        border: 1px solid #ccc;
      }*/
      #viv th {
        background: #ee9b27;
      }
</style>
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1">Ver Obra</div>
            </div>
            <div class="ms-auto">
                <div class="dropdown">
                    <a class="btn btn-info dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Informes <i class="fas fa-print" style="color: #ffffff;"></i>
                    </a>

                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{route('infovivienda.pdf', base64url_encode($obra->id_obr))}}" target="_blank">Datos viviendas</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Información de la Obra</h5></div>
                        </div>
                        <div class="card-body">
                            <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text($obra->id_obr, null, ['style' => 'disabled;' ]) !!}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->num_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->nom_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_loc', $obra->getLocalidad->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $obra->getEmpresa->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Etapas de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Etapas</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="items" class="table table-hover mt-2" class="display">
                                    <thead>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:55%;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Cant. Viviendas</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:10%;">0 Dormitorios</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">2 Dormitorios</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">3 Dormitorios</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">4 Dormitorios</th> --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($obra->getEtapas as $etapa)
                                            <tr>
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nro_eta}}</td>
                                                <td class= 'text-center align-middle'>{{$etapa->descripcion}}</td>
                                                <td class= 'text-center'>{{$etapa->cant_viv}}</td>
                                                {{-- <td class= 'text-center'>0</td>
                                                <td class= 'text-center'>{{$etapa->can_viv_2}}</td>
                                                <td class= 'text-center'>{{$etapa->can_viv_3}}</td>
                                                <td class= 'text-center'>{{$etapa->can_viv_4}}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Entregas de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Entregas</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="items" class="table table-hover mt-2" class="display">
                                    <thead>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:50%;">Descripcion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Cant. Viviendas</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($obra->getEtapas as $etapa)
                                            @foreach ($etapa->getEntregas as $entrega)
                                                <tr>
                                                    <td class= 'text-center align-middle'>{{$etapa->nro_eta}}</td>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$entrega->num_ent}}</td>
                                                    <td class= 'text-center align-middle'>{{$entrega->descripcion}}</td>
                                                    @if (is_null($entrega->fec_ent))
                                                        <td class= 'text-center'>SIN FECHA</td>
                                                    @else
                                                        <td class= 'text-center'>{{Carbon\Carbon::parse($entrega->fec_ent)->format('d-m-Y')}}</td>
                                                    @endif

                                                    <td class= 'text-center'>{{$entrega->cant_viv}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                {{-- Viviendas de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pb-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5>Viviendas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">

                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="tableFixHead">
                                <table id="viv" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Viv. Adaptada</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Partida</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Plano</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Parcela</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Finca</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Sup. Finca</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Sup. Lote</th>
                                        <th class="text-center" scope="col" style="color:#fff;">N° Calle</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Calle</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Municipio</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Departamento</th>
                                        <th class="text-center" scope="col" style="color:#fff; width:15%">Longitud</th>
                                        <th class="text-center" scope="col" style="color:#fff; width:15%">Latitud</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Edif.</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Piso</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Dpto</th>
                                        <th class="text-center" scope="col" style="color:#fff;">Escalera</th>
                                    <tbody>
                                        @foreach ($viviendasTabla as $vivienda)
                                            <tr>
                                                <td class= 'text-center' >{{$vivienda->orden}}</td>
                                                <td class= 'text-center' >{{$vivienda->getEntrega->getEtapa->nro_eta}}</td>
                                                <td class= 'text-center' >{{$vivienda->getEntrega->num_ent}}</td>
                                                @if ($vivienda->discap == 1)
                                                    <td class= 'text-center' >SI</td>
                                                @else
                                                    <td class= 'text-center' >NO</td>
                                                @endif
                                                <td class= 'text-center' >{{$vivienda->partida}}</td>
                                                <td class= 'text-center' >{{$vivienda->plano}}</td>
                                                <td class= 'text-center' >{{$vivienda->seccion}}</td>
                                                <td class= 'text-center' >{{$vivienda->chacra}}</td>
                                                <td class= 'text-center' >{{$vivienda->manzana}}</td>
                                                <td class= 'text-center' >{{$vivienda->parcela}}</td>
                                                <td class= 'text-center' >{{$vivienda->finca}}</td>
                                                <td class= 'text-center' >{{$vivienda->sup_fin}}</td>
                                                <td class= 'text-center' >{{$vivienda->sup_lot}}</td>
                                                <td class= 'text-center' >{{$vivienda->num_cal}}</td>
                                                <td class= 'text-center' >{{$vivienda->nom_cal}}</td>
                                                <td class= 'text-center' >{{$vivienda->getMunicipio->nom_municipio}}</td>
                                                <td class= 'text-center' >{{$vivienda->getMunicipio->getDepartamento->nom_dep}}</td>
                                                <td class= 'text-center' >{{$vivienda->latitud}}</td>
                                                <td class= 'text-center' >{{$vivienda->longitud}}</td>
                                                <td class= 'text-center' >{{$vivienda->edificio}}</td>
                                                <td class= 'text-center' >{{$vivienda->piso}}</td>
                                                <td class= 'text-center' >{{$vivienda->departamento}}</td>
                                                <td class= 'text-center' >{{$vivienda->escalera}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------- --}}

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        {{-- (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong> --}}
                                    </div>
                                    <div class="p-1">
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'obravivienda.index', 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
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

@endsection
