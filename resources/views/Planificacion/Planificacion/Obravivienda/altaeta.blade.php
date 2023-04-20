@extends('layouts.app')

@section('content')
<style>
    .tableFixHead {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       height: 400px; /* gives an initial height of 200px to the table */
     }
     .tableFixHead thead th {
       position: sticky; /* make the table heads sticky */
       top: 0px; /* table head will be placed from the top of the table and sticks to it */
     }
     .tableFix {
       overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
       height: 250px; /* gives an initial height of 200px to the table */
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
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Gestion de Etapas y Entregas de la Obra</div>
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
                                        {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('num_obr', $obra->num_obr, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
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
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idempresa', $obra->getEmpresa->nom_emp, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::text('idloc', $obra->getLocalidad->nom_loc, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                               
                            </div>
                            
                            
                            <div class="row">
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">

                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de Viviendas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_viv', $obra->can_viv, ['class' => 'form-control', 'readonly']) !!}
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
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Etapas</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('N° Etapa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('num_eta', 1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('descrip', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('0 Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('2 Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('3 Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('4 Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('Acciones:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success form-control']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>  
                            </div>
                            {{-- <div class="row">
                                {!! Form::label('Cantidad de Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('0 (CERO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('can_viv_0', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('2 (DOS):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_2', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('3 (TRES):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_3', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('4 (CUATRO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('can_viv_4', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Cantidad de Viviendas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_viv', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Etapas:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('can_eta', 1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="tableFix">
                                    <table id="viv" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">N° Etapa</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:50%;">Descripcion</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">0 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">2 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">3 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">4 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            {{-- {{$obra->getEtapas->first()->getEntregas->last()->getViviendas}} --}}
                                            @foreach ($obra->getEtapas as $etapa)
                                                <tr>                                          
                                                    <td class= 'text-center' >{{$etapa->nro_eta}}</td>
                                                    <td class= 'text-center' >{{$etapa->descripcion}}</td>
                                                    <td class= 'text-center' >0</td>   
                                                    <td class= 'text-center' >{{$etapa->can_viv_2}}</td>                                           
                                                    <td class= 'text-center' >{{$etapa->can_viv_3}}</td>
                                                    <td class= 'text-center' >{{$etapa->can_viv_4}}</td>
                                                    <td class= 'text-center' >
                                                        boton editar
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- @foreach ($obra->getEtapas as $etapa)
                                            {{$etapa->getEntregas}}
                                                <tr>
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nro_eta}}</td>                                            
                                                    <td class= 'text-center align-middle'>{{$etapa->descripcion}}</td>                                            
                                                    <td class= 'text-center'>{{$etapa->can_viv_2}}</td>
                                                    <td class= 'text-center'>{{$etapa->can_viv_3}}</td>
                                                    <td class= 'text-center'>{{$etapa->can_viv_4}}</td>
                                                </tr>
                                            @endforeach --}}
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
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Entregas</h5></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('N° Entrega:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('num_eta', 1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('descrip', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Entrega:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ter', null, [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('Acciones:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success form-control']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="tableFix">
                                    <table id="viv" class="table table-hover mt-2" class="display">
                                        <thead style="">
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">N° Etapa</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:50%;">Descripcion</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">0 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">2 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">3 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:10%;">4 Dormitorios</th>
                                            <th class="text-center" scope="col" style="color:#fff;width:5%;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($obra->getEtapas as $etapa)
                                                <tr>                                          
                                                    <td class= 'text-center' >{{$etapa->nro_eta}}</td>
                                                    <td class= 'text-center' >{{$etapa->descripcion}}</td>
                                                    <td class= 'text-center' >0</td>   
                                                    <td class= 'text-center' >{{$etapa->can_viv_2}}</td>                                           
                                                    <td class= 'text-center' >{{$etapa->can_viv_3}}</td>
                                                    <td class= 'text-center' >{{$etapa->can_viv_4}}</td>
                                                    <td class= 'text-center' >
                                                        boton editar
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
                {{-- ---------------------------------------- --}}
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Viviendas</h5></div>                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="tableFixHead">
                                <table id="viv" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Plano</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Parcela</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Finca</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Edif.</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Piso</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Dpto</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Escalera</th>
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:5%;">Superficie</th> --}}
                                    </thead>
                                    <tbody>
                                        {{-- {{$obra->getEtapas->first()->getEntregas->last()->getViviendas}} --}}
                                        @foreach ($obra->getEtapas as $etapa)
                                            @foreach ($etapa->getEntregas as $entrega)
                                                @foreach ($entrega->getViviendas as $vivienda)
                                                    <tr>                                          
                                                        <td class= 'text-center' >{{$vivienda->orden}}</td>
                                                        <td class= 'text-center' >{{$vivienda->plano}}</td>
                                                        <td class= 'text-center' >{{$etapa->nro_eta}}</td>   
                                                        <td class= 'text-center' >{{$entrega->num_ent}}</td>                                           
                                                        <td class= 'text-center' >{{$vivienda->seccion}}</td>
                                                        <td class= 'text-center' >{{$vivienda->chacra}}</td>
                                                        <td class= 'text-center' >{{$vivienda->manzana}}</td>
                                                        <td class= 'text-center' >{{$vivienda->parcela}}</td>
                                                        <td class= 'text-center' >{{$vivienda->finca}}</td>
                                                        <td class= 'text-center' >{{$vivienda->edificio}}</td>
                                                        <td class= 'text-center' >{{$vivienda->piso}}</td>
                                                        <td class= 'text-center' >{{$vivienda->departamento}}</td>
                                                        <td class= 'text-center' >{{$vivienda->escalera}}</td>
                                                        {{-- <td class= 'text-center' >{{$vivienda->sup_lot}}</td> --}}
                                                        
                                                        {{-- <td class= 'text-center' style="vertical-align: middle;">{{$vivienda->orden}}</td>   --}}
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        {{-- @foreach ($obra->getEtapas as $etapa)
                                        {{$etapa->getEntregas}}
                                            <tr>
                                                <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nro_eta}}</td>                                            
                                                <td class= 'text-center align-middle'>{{$etapa->descripcion}}</td>                                            
                                                <td class= 'text-center'>{{$etapa->can_viv_2}}</td>
                                                <td class= 'text-center'>{{$etapa->can_viv_3}}</td>
                                                <td class= 'text-center'>{{$etapa->can_viv_4}}</td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
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
