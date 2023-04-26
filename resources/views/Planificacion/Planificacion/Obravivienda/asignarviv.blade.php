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
            <div class="titulo py-1">Agregar viviendas a la entrega</div>
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

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <div class="row">
                                {!! Form::label('Etapa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                            </div> --}}
                            <div class="row border">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                {!! Form::label('Etapa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    <div class="row">                
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('N° Etapa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('num_eta', $etapa->nro_eta, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                            <div class="form-group">
                                                {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                                {!! Form::text('descrp', $etapa->descripcion, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        {!! Form::label('Cantidad de Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('0 (CERO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::number('can_viv_0', 0, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('2 (DOS):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('can_viv_2', $etapa->can_viv_2, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('3 (TRES):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('can_viv_3', $etapa->can_viv_3, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('4 (CUATRO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                                {!! Form::text('can_viv_4', $etapa->can_viv_4, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border border-top-0">
                                {!! Form::label('Entrega:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('N° entrega', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::number('num_ent', $entre->num_ent, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idempresa', $entre->descripcion, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha entrega:', null, [
                                                        'class' => 'control-label',
                                                        'style' => 'white-space: nowrap;',
                                                    ]) !!}
                                                    {!! Form::date('fec_ter', \Carbon\Carbon::parse($entre->fec_ent)->format('Y-m-d'), [
                                                        'min' => '1900-01-01',
                                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                                        'id' => 'periodo',
                                                        'class' => 'form-control',
                                                        'readonly',
                                                    ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                {{-- {{$listaViviendas}} --}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="pb-2">Viviendas:</h4>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                                    <input id="buscarubro" name="name" type="text" class="form-control" placeholder="Buscar Vivienda" aria-label="Recipient's username" aria-describedby="button-addon2">
                                </div>
                                {{-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 my-auto">
                                    {!! Form::submit('Buscar', ['class' => 'btn btn-primary mr-2']) !!}
                                </div> --}}
                            </div>
                            <div class="row pt-3">
                                <h6>Seleccione las viviendas que tiene la entrega:</h6>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-row align-items-start justify-content-around mb-3">
                                    <div class="card-body ms-2 d-flex flex-column" style="height: 250px;width:50%">
                                        <div class="">
                                            <label>Viviendas:</label>
                                        </div>
                                        <div id="rubrosParaAsignar" class="d-flex flex-column overflow-auto" style="height: 225px;">
                                            <div class="ms-auto d-flex align-items-center">
                                                <input id="checkpermisos" onclick="seleccionarpermisostodos()" class="me-2 name" name="checkpermisos" type="checkbox">
                                                <div>Selec. todo</div>
                                            </div>
                                            @foreach ($todasLasViviendas as $viv)
                                                {{-- {{in_array($viv->id_viv, $listaViviendas)}} --}}
                                                @php
                                                    if(in_array($viv->id_viv, $listaViviendas)){
                                                        $bandera = true;
                                                    }else{
                                                        $bandera = false;
                                                    } 
                                                @endphp
                                                @if ($bandera)
                                                    <label id='{{$viv->id_viv}}'><input checked onclick="" class="radiockeck{{$viv->orden}}" name="" type="checkbox" value="{{$viv->id_viv}}"> {{'Viv. Orden N°: '.$viv->orden}} </label>
                                                @else
                                                    <label id='{{$viv->id_viv}}'><input onclick="" class="radiockeck{{$viv->orden}}" name="" type="checkbox" value="{{$viv->id_viv}}"> {{'Viv. Orden N°: '.$viv->orden}} </label>
                                                @endif

                                                
                                            @endforeach
                                            {{-- @for ($i = 1; $i <= $obra->can_viv; $i++)
                                                @php
                                                    $bandera = array_search($rubro->id, $listaRubros);
                                                    if(in_array($rubro->id, $listaRubros)){
                                                        $bandera = true;
                                                    }else{
                                                        $bandera = false;
                                                    }
                                                @endphp

                                                <label id='{{$i}}'><input checked onclick="" class="radiockeck{{$i}}" name="" type="checkbox" value="{{$i}}"> {{'Viv. Orden N°: '.$i}} </label>
                                            @endfor --}}
                                            {{-- @foreach($rubros as $rubro)
                                                @php
                                                    $bandera = array_search($rubro->id, $listaRubros);
                                                    if(in_array($rubro->id, $listaRubros)){
                                                        $bandera = true;
                                                    }else{
                                                        $bandera = false;
                                                    }

                                                @endphp
                                                
                                                @if ($bandera)
                                                    <label id='{{$rubro->id}}'><input checked onclick="agregarRubro('{{$rubro->id}}','{{$rubro->rubro}}')" class="radiockeck{{$rubro->id}}" name="" type="checkbox" value="{{$rubro->id}}"> {{$rubro->rubro}} </label>
                                                @else
                                                    <label id='{{$rubro->id}}'><input onclick="agregarRubro('{{$rubro->id}}','{{$rubro->rubro}}')" class="radiockeck{{$rubro->id}}" name="" type="checkbox" value="{{$rubro->id}}"> {{$rubro->rubro}} </label>
                                                @endif
                                                
                                            @endforeach --}}
                                        </div>
                                    </div>

                                    <div class="card me-3  mt-3 " style="background-color: rgb(255, 255, 255);height: 225px; width:100% ">
                                        <h6 class="card-title ms-4 mt-4 pb-0 mb-2">Viviendas Asignadas</h6>
                                        {!! Form::open([
                                            'method' => 'GET',
                                            // 'route' => ['rubros.show', $empresa->id_emp],
                                            'style' => 'display:inline',
                                            'class' => 'validar overflow-auto'
                                        ]) !!}
                                        <div class="overflow-auto">
                                            <div class="card-body d-flex flex-column pt-0 overflow-auto" id="rubrosAsignados">
                                                @foreach($entre->getViviendas as $viv)
                                                {{-- onclick="eliminarRubro('{{$rubroAsignado->id}}')" class="ru{{$rubroAsignado->id}}" --}}
                                                    <label id="viv{{$viv->orden}}"><input checked name="vivs[]" type="checkbox" value="{{$viv->id_viv}}"> {{'Viv. Orden N°: '.$viv->orden}}</label> 
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success m-auto', 'style' => 'width: 40%']) !!}
                                        {!! Form::close() !!} 
                            </div>
                        </div>
                    </div>  
                </div> 
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Informacion viviendas asignadas</h5></div>                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="tableFixHead">
                                <table id="viv" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
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
                                        {{-- <th class="text-center" scope="col" style="color:#fff;width:5%;">Superficie</th> --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($entre->getViviendas as $vivienda)
                                        <tr>                                          
                                            <td class= 'text-center' >{{$vivienda->orden}}</td>
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
                                            {{-- <td class= 'text-center' >{{$vivienda->sup_lot}}</td> --}}
                                            
                                            {{-- <td class= 'text-center' style="vertical-align: middle;">{{$vivienda->orden}}</td>   --}}
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
        </div>
    </section>
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/altaviv_obravivienda.js') }}"></script>
    <script>
        obra = {{$obra->id_obr}}
    </script>
@endsection
