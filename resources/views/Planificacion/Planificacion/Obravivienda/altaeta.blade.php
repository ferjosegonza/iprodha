@extends('layouts.app')

@section('content')
<style>
    .tableFixHead {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       min-height: 400px; /* gives an initial height of 200px to the table */
     }
     .tableFixHead thead th {
       position: sticky; /* make the table heads sticky */
       top: 0px; /* table head will be placed from the top of the table and sticks to it */
     }
     .tableFix {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       min-height: 250px; /* gives an initial height of 200px to the table */
     }
     .tableFix thead th {
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

     .tableFixHeadVivienda {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       height: 400px; /* gives an initial height of 200px to the table */
     }
     .tableFixHeadVivienda thead th {
       position: sticky; /* make the table heads sticky */
       top: 0px; /* table head will be placed from the top of the table and sticks to it */
     }
     #vivien table {
       border-collapse: collapse; /* make the table borders collapse to each other */
       width: 100%;
     }
     /* #viv th,
     #viv td {
       padding: 8px 16px;
       border: 1px solid #ccc;
     }*/
     #vivien th {
       background: #ee9b27;
     } 
</style>
    <section class="section">
        <div class="section-header">
            <h5 class="titulo py-1">Gestion de Etapas y Entregas de la Obra</h5>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- Informacion de la obra --}}
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Informacion de la Obra</h5></div>                        
                        </div>
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
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">

                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de Viviendas:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_viv', $totalDeVivReal, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {{-- <div class="form-group">
                                        {!! Form::label('Acciones:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success form-control']) !!}
                                        {!! Form::close() !!}
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        {!! Form::label('Etapas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_eta', $obra->getEtapas->last()->nro_eta, ['class' => 'form-control', 'readonly']) !!}
                                    </div> --}}
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------------------------ --}}

                {{-- Etapas de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pb-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5>Etapas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.nuevaetapa', $obra->id_obr], 'style' => '']) !!}
                                    {!! Form::submit('Crear', ['class' => 'btn btn-success w-100']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="tableFix">
                                    <table id="viv" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">N° Etapa</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:50%;">Descripcion</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:20%;">Cant. Vivienda</th>
                                            {{-- <th class="text-center" scope="col" style="color:#fff;width:10%;">0 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">2 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">3 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">4 Dormitorios</th> --}}
                                            <th class="text-center" scope="col" style="color:#fff;width:15%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($obra->getEtapas->sortBy('nro_eta') as $etapa)
                                                <tr>                                          
                                                    <td class= 'text-center' >{{$etapa->nro_eta}}</td>
                                                    <td class= 'text-center' >{{$etapa->descripcion}}</td>
                                                    <td class= 'text-center' >{{$etapa->cant_viv}}</td>
                                                    {{-- <td class= 'text-center' >{{$etapa->can_viv_0 ?? 0}}</td>   
                                                    <td class= 'text-center' >{{$etapa->can_viv_2}}</td>                                           
                                                    <td class= 'text-center' >{{$etapa->can_viv_3}}</td>
                                                    <td class= 'text-center' >{{$etapa->can_viv_4}}</td> --}}
                                                    <td class= 'text-center' >
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.editaretapa', $etapa->id_etapa], 'style' => '']) !!}
                                                                {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                            <div class="col-lg-6">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE','route' => ['obravivienda.eliminaretapa', $etapa->id_etapa],'style' => '',]) !!}
                                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('¿Está seguro que desea ELIMINAR la etapa?')",]) !!}
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
                 {{-- -------------------------------- --}}

                 {{-- Entregas de la obra --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pb-1">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 text-center">
                                    <h5>Entregas</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.vernuevaentrega', $obra->id_obr], 'style' => '']) !!}
                                    {!! Form::submit('Crear', ['class' => 'btn btn-success w-100']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="tableFix">
                                    <table id="viv" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">N° Etapa</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">N° Entrega</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">Cant. viviendas</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:45%;">Descripcion</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">Fecha Entrega</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:18%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($obra->getEtapas as $etapa)
                                                @foreach ($etapa->getEntregas as $entrega)
                                                    <tr>      
                                                        <td class= 'text-center' >{{$entrega->getEtapa->nro_eta}}</td>                                    
                                                        <td class= 'text-center' >{{$entrega->num_ent}}</td>
                                                        <td class= 'text-center' >{{$entrega->cant_viv}}</td>
                                                        <td class= 'text-center' >{{$entrega->descripcion}}</td>   
                                                        @if (is_null($entrega->fec_ent))
                                                            <td class= 'text-center'>SIN FECHA</td>
                                                        @else
                                                            <td class= 'text-center'>{{Carbon\Carbon::parse($entrega->fec_ent)->format('d-m-Y')}}</td>
                                                        @endif
                                                        <td>
                                                            <div class= "my-2">
                                                                @if ($entrega->num_ent > 0)
                                                                <div class="row mb-2 ">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.editarentrega', $entrega->id_ent, $obra->id_obr], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                                        {!! Form::open([
                                                                            'method' => 'DELETE','route' => ['obravivienda.eliminarentrega', $entrega->id_ent],'style' => 'display: inline',]) !!}
                                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100','onclick' => "return confirm('¿Está seguro que desea ELIMINAR la entrega?')",]) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.entrega', $obra->id_obr, $entrega->id_ent], 'style' => 'display:inline']) !!}
                                                                        {!! Form::submit('Agregar Viviendas', ['class' => 'btn btn-info mb-2 w-100']) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 {{-- -------------------------------- --}}

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
                                    {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.nuevaviv', $obra->id_obr], 'style' => '']) !!}
                                    {!! Form::submit('Crear', ['class' => 'btn btn-success w-100']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="tableFixHeadVivienda">
                                <table id="vivien" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Viv. Adaptada</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Plano</th>                                                            
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Parcela</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Finca</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Edif.</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Piso</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Dpto</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Escalera</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($viviendasTabla as $vivienda)
                                            <tr>    
                                                <td class= 'text-center' >{{$vivienda->orden}}</td>                                      
                                                <td class= 'text-center' >{{$vivienda->etapa}}</td>
                                                <td class= 'text-center' >{{$vivienda->entrega}}</td>
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
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- -------------------------------- --}}
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
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/altaviv_obravivienda.js') }}"></script>
    <script>
        obra = {{$obra->id_obr}}
    </script>
@endsection
