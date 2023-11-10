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

    #example thead input {
        width: 100%;
    }
</style>
    <section class="section">
        <div class="section-header d-flex">
                <div class="flex-grow-1">
                    <div class="titulo page__heading fs-5">Gestion de Viviendas de la Obra</div>
                </div>
                <div class="px-1">
                    <a href=#carga-individual class="btn btn-primary">Carga Individual</a>
                </div>
                <div class="px-1">
                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.cargamasiva', $obra->id_obr], 'style' => '', 'target' => '_blank']) !!}
                    {!! Form::submit('Carga Masiva', ['class' => 'btn btn-primary', 'target' => '_blank']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="px-1">
                    <div class="dropdown">
                        <a class="btn btn-info dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Informes <i class="fas fa-print" style="color: #ffffff;"></i>
                        </a>
                        @if (count($obra->getEtapas) != 0)
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('infovivienda.pdf', [base64url_encode($obra->id_obr), 1, 0, 0])}}" target="_blank">Todas las viviendas</a></li>
                            @foreach ($obra->getEtapas->sortBy('nro_eta') as $etapa)
                                @foreach ($etapa->getEntregas->sortBy('num_ent') as $entrega)
                                    <li><a class="dropdown-item" href="{{route('infovivienda.pdf', [base64url_encode($obra->id_obr), 0, base64url_encode($entrega->id_ent), base64url_encode($etapa->id_etapa)])}}" target="_blank">Viviendas Etapa {{$etapa->nro_eta}} Entrega {{$entrega->num_ent}}</a></li>
                                @endforeach
                            @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
    </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Numero:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('num_obr', $obra->num_obr, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nomobra', $obra->nom_obr, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'readonly',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idempresa', $obra->getEmpresa->nom_emp, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('idloc', $obra->getLocalidad->nom_loc, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                               
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de Viviendas:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_viv', $totalDeVivReal ?? 0, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Departamento:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('depp', $obra->can_viv, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Municipio:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('munn', $obra->can_viv, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5 class="text-center">Viviendas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.nuevavivalt', $obra->id_obr], 'style' => '']) !!}
                                    {!! Form::submit('Crear', ['class' => 'btn btn-success w-100']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            {{-- <br>
                            <div class="text-center"><h5>Viviendas</h5></div>                         --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="tableFixHead">
                                <table id="example" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Viv. Adaptada</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Partida</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Plano</th>                                                            
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Parcela</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Finca</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Municipio</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Departamento</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Edif.</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Piso</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Dpto</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Escalera</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Unidad fun</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                    </thead>
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
                                                <td class= 'text-center' >{{$vivienda->getMunicipio->nom_municipio}}</td>
                                                <td class= 'text-center' >{{$vivienda->getMunicipio->getDepartamento->nom_dep}}</td>
                                                <td class= 'text-center' >{{$vivienda->edificio}}</td>
                                                <td class= 'text-center' >{{$vivienda->piso}}</td>
                                                <td class= 'text-center' >{{$vivienda->departamento}}</td>
                                                <td class= 'text-center' >{{$vivienda->escalera}}</td>
                                                <td class= 'text-center' >{{$vivienda->uni_fun}}</td>
                                                <td class= 'text-center' >
                                                    @can('EDITAR-OBRAVIVIENDA')
                                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.editarviv', $vivienda->id_viv, $obra->id_obr], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary mb-2 w-100']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- @foreach ($obra->getEtapas as $etapa)
                                            @foreach ($etapa->getEntregas as $entrega)
                                                @foreach ($entrega->getViviendas as $vivienda)
                                                    <tr>    
                                                        <td class= 'text-center' >{{$vivienda->orden}}</td>                                      
                                                        <td class= 'text-center' >{{$etapa->nro_eta}}</td>
                                                        <td class= 'text-center' >{{$entrega->num_ent}}</td>
                                                        @if ($vivienda->discap == 1)
                                                            <td class= 'text-center' >SI</td>
                                                        @else
                                                            <td class= 'text-center' >NO</td>
                                                        @endif
                                                        <td class= 'text-center' >{{$vivienda->plano}}</td>
                                                        <td class= 'text-center' >{{$vivienda->seccion}}</td>
                                                        <td class= 'text-center' >{{$vivienda->chacra}}</td>
                                                        <td class= 'text-center' >{{$vivienda->manzana}}</td>
                                                        <td class= 'text-center' >{{$vivienda->parcela}}</td>
                                                        <td class= 'text-center' >{{$vivienda->finca}}</td>
                                                        <td class= 'text-center' >{{$vivienda->edificio}}</td>
                                                        <td class= 'text-center' >{{$vivienda->piso}}</td>
                                                        <td class= 'text-center' >{{$vivienda->departamento}}</td>
                                                        <td class= 'text-center' >{{$vivienda->escalera}}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach --}}
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12" id="carga-individual">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center">
                                <h6>Vivienda</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method' => 'POST','route' => 'obravivienda.guardarvivienda']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="background-color: #ff9500b6">
                                    {!! Form::label('Seleccione el numero de orden:', null, ['class' => 'control-label fs-7 text-black']) !!}
                                </div>
                                {{-- ee9b27 --}}
                            </div>
                            <div class="row">
                                <div class="" hidden>
                                    {!! Form::text('id_obr', $obra->id_obr, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" style="background-color: #ff9500b6">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda Orden N°:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        <select class="form-select" name="vivienda" placeholder="Seleccionar" id='selected-orden'>
                                            <option disabled selected>Seleccionar</option>
                                            @foreach ($viviendas->sortBy('orden') as $vivienda)
                                                <option value={{"$vivienda->id_viv"}}>{{$vivienda->orden}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" style="background-color: #ff9500b6">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plano:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('plano', null, ['class' => 'form-control', 'id' => 'idplano', 'disabled', 'data-type' => 'limitcarac10']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Partida:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('partida', null, ['class' => 'form-control', 'id' => 'idpartida', 'disabled', 'data-type' => 'limitcarac12']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Partida UCAC:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('partidaucac', null, ['class' => 'form-control', 'id' => 'idpartidaucac', 'disabled', 'data-type' => 'limitcarac12']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Viv. para Discapacitados:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('vivdisc', [ 0 => 'NO', 1 => 'SI'], 0, ['class' => 'form-select', 'id' => 'idvivdisc', 'disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row border border-bottom-0">
                                <div class="row">
                                    {!! Form::label('Datos Catastro:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Sección:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('seccion', null, ['class' => 'form-control', 'id' => 'idseccion', 'disabled', 'data-type' => 'limitcarac3']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Chacra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('chacra', null, ['class' => 'form-control', 'id' => 'idchacra', 'disabled', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('manzana', null, ['class' => 'form-control', 'id' => 'idmanzana', 'disabled', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Parcela:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('parcela', null, ['class' => 'form-control', 'id' => 'idparcela', 'disabled', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Finca:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('finca', null, ['class' => 'form-control', 'id' => 'idfinca', 'disabled', 'data-type' => 'limitcarac6']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Edificio:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('edif', null, ['class' => 'form-control', 'id' => 'idedif', 'disabled', 'data-type' => 'limitcarac5' ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Piso:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('piso', null, ['class' => 'form-control', 'id' => 'idpiso', 'disabled', 'data-type' => 'limitcarac2']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Departamento:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('depto', null, ['class' => 'form-control', 'id' => 'iddepto', 'disabled', 'data-type' => 'limitcarac5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Escalera:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('esca', null, ['class' => 'form-control', 'id' => 'idesca', 'disabled', 'data-type' => 'limitcarac5']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Unidad funcional:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('unfun', null, ['class' => 'form-control', 'id' => 'idunfun', 'disabled', 'data-type' => 'limitcarac6']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 border">
                                    <div class="row">
                                        {!! Form::label('Identificacion S/Empresa:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('letmanza', null, ['class' => 'form-control', 'id' => 'idempmanza', 'disabled', 'data-type' => 'limitcarac4']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Lote:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('lote', null, ['class' => 'form-control', 'id' => 'idlote', 'disabled', 'data-type' => 'limitcarac12']) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 border border-start-0">
                                    <div class="row">
                                        {!! Form::label('Identificacion Municipal:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('N° Calle:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('numcalle', null, ['class' => 'form-control', 'id' => 'idnumcalle', 'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('Nombre Calle:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('nomcalle', null, ['class' => 'form-control', 'id' => 'idnomcalle', 'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Entre Calles:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('ent_calles', null, ['class' => 'form-control', 'id' => 'identcalle', 'disabled']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie cubierta:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('sup_fin', null, ['class' => 'form-control', 'id' => 'idnumfinca', 'step' => '.01', 'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie Lote:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('sup_lote', null, ['class' => 'form-control', 'id' => 'idsuplote', 'step' => '.01', 'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row pt-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                    <div class="form-group">
                                        {!! Form::label('Deslinde:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::textarea('deslinde', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'id' => 'iddeslinde', 'disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @can('CARGAR-VIVIENDAS')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success', 'id' => 'guardarVivienda']) !!}
                                        @endcan
                                        {!! Form::close() !!}
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
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/altaviv_obravivienda.js') }}"></script>
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/format_obravivienda.js') }}"></script>
    <script>
        obra = {{$obra->id_obr}}
    </script>
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');
        
            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();
        
                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');
        
                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('change', function (e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();
        
                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function (e) {
                                    e.stopPropagation();
        
                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>
@endsection
