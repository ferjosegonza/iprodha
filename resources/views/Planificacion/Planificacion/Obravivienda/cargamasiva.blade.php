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
            <div class="titulo py-1">Carga Masiva de datos para las viviendas</div>
        </div>
        <div class="section-body">
            @include('layouts.modal.mensajes')
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Numero:</label>   
                                        {!! Form::number('num_obr', $obra->num_obr, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        <label for="Obra:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Obra:</label>
                                        {!! Form::text('nom_obra', $obra->nom_obr, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                            'readonly'
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="Empresa:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Empresa:</label>
                                        {!! Form::text('idempresa', $obra->getEmpresa->nom_emp, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="Localidad:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Localidad: </label>
                                        {!! Form::text('idloc', $obra->getLocalidad->nom_loc, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Expediente:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('expediente', $obra->expedte, ['class' => 'form-control', 'readonly']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Cantidad de viviendas:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Cantidad de viviendas: </label>
                                        {!! Form::number('can_viv', $obra->can_viv, ['class' => 'form-control', 'readonly']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha inicio:', null, [
                                                'class' => 'control-label fs-6',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ini', \Carbon\Carbon::parse($obra->fec_ini)->format('Y-m-d'), [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                                'readonly'
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha fin:', null, [
                                                'class' => 'control-label fs-6',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ter', \Carbon\Carbon::parse($obra->fec_ent)->format('Y-m-d'), [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                                'readonly'
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('plazo', $obra->plazo, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-11">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Datos Compartidos de Viviendas</h5></div>                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="tableFixHead">
                                <table id="viv" class="table table-hover mt-2" class="display">
                                    <thead style="">
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Plano</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana s/emp</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Calle</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:20%;">Entre calles</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($viviendas as $vivienda)
                                            <tr>                                          
                                                <td class= 'text-center' >{{$vivienda->orden}}</td>
                                                <td class= 'text-center' >{{$vivienda->etapa}}</td>   
                                                <td class= 'text-center' >{{$vivienda->entrega}}</td>
                                                <td class= 'text-center' >{{$vivienda->plano}}</td>                                           
                                                <td class= 'text-center' >{{$vivienda->seccion}}</td>
                                                <td class= 'text-center' >{{$vivienda->chacra}}</td>
                                                <td class= 'text-center' >{{$vivienda->manzana}}</td>
                                                <td class= 'text-center' >{{$vivienda->man_emp}}</td>
                                                <td class= 'text-center' >{{$vivienda->nom_cal}}</td>
                                                <td class= 'text-center' >{{$vivienda->entrecalles}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h6>Viviendas</h6></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="background-color: #ff9500b6">
                                    {!! Form::label('Viviendas por N° de orden:', null, ['class' => 'control-label text-black', 'style' => 'white-space: nowrap;']) !!}
                                </div>
                            </div>
                            {!! Form::open(['route' => ['obravivienda.guardarcargamasiva', $obra->id_obr], 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" style="background-color: #ff9500b6">
                                    <div class="form-group">
                                        {!! Form::label('Desde:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <select class="form-select" name="ordenDesde" placeholder="Seleccionar" id='selected-orden-desde'>
                                            <option disabled selected>Seleccionar</option>
                                            @for ($i = 1; $i <= $totalViviendas; $i++)
                                                <option value={{"$i"}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2" style="background-color: #ff9500b6">
                                    <div class="form-group">
                                        {!! Form::label('Hasta:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <select class="form-select" name="ordenHasta" placeholder="Seleccionar" id='selected-orden-hasta'>
                                            <option disabled selected>Seleccionar</option>
                                            @for ($i = 1; $i <= $totalViviendas; $i++)
                                                <option value={{"$i"}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plano:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('plano', null, ['class' => 'form-control', 'id' => 'idplano']) !!}
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
                                                {!! Form::number('seccion', null, ['class' => 'form-control', 'id' => 'idseccion']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Chacra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('chacra', null, ['class' => 'form-control', 'id' => 'idchacra']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('manzana', null, ['class' => 'form-control', 'id' => 'idmanzana']) !!}
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
                                                {!! Form::text('letmanza', null, ['class' => 'form-control', 'id' => 'idempmanza']) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 border border-start-0">
                                    <div class="row">
                                        {!! Form::label('Identificacion Municipal:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('Nombre Calle:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('nomcalle', null, ['class' => 'form-control', 'id' => 'idnomcalle']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Entre Calles:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('ent_calles', null, ['class' => 'form-control', 'id' => 'identcalle']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAS')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['obravivienda.viviendas', $obra->id_obr], 'style' => '']) !!}
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
    {{-- <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/cargamasiva_obravivienda.js') }}"></script> --}}
@endsection
