@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Carga Masiva de datos para las viviendas</div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                {{-- {!! Form::model($obra,['method' => 'PUT', 'route' => ['obravivienda.update', $obra->id_obr], 'class' => 'd-flex justify-content-start']) !!} --}}
                {{-- {!! Form::open(['route' => 'obravivienda.update', 'method' => 'PUT']) !!} --}}
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label" style="white-space: nowrap;width:20%;">Numero:</label>   
                                        {!! Form::number('num_obr', $obra->num_obr, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        <label for="Obra:" class="control-label" style="white-space: nowrap;width:20%;">Obra:</label>
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
                                        <label for="Empresa:" class="control-label" style="white-space: nowrap;width:20%;">Empresa:</label>
                                        {!! Form::text('idempresa', $obra->getEmpresa->nom_emp, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="Localidad:" class="control-label" style="white-space: nowrap;width:20%;">Localidad: </label>
                                        {!! Form::text('idloc', $obra->getLocalidad->nom_loc, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Expediente:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('expediente', $obra->expedte, ['class' => 'form-control', 'readonly']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Cantidad de viviendas:" class="control-label" style="white-space: nowrap;width:20%;">Cantidad de viviendas: </label>
                                        {!! Form::number('can_viv', $obra->can_viv, ['class' => 'form-control', 'readonly']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha inicio:', null, [
                                                'class' => 'control-label',
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
                                                'class' => 'control-label',
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
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('plazo', $obra->plazo, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                
                            </div>
                            
                    
                            {{-- <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAS')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div> --}}
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
                                {!! Form::label('Viviendas por N° de orden:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            </div>
                            {!! Form::open(['route' => ['obravivienda.guardarcargamasiva', $obra->id_obr], 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Desde:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <select class="form-select" name="ordenDesde" placeholder="Seleccionar" id='selected-orden'>
                                            <option disabled selected>Seleccionar</option>
                                            @for ($i = 1; $i <= $obra->can_viv; $i++)
                                                <option value={{"$i"}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Hasta:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <select class="form-select" name="ordenHasta" placeholder="Seleccionar" id='selected-orden'>
                                            <option disabled selected>Seleccionar</option>
                                            @for ($i = 1; $i <= $obra->can_viv; $i++)
                                                <option value={{"$i"}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Plano:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::number('plano', null, ['class' => 'form-control', 'id' => 'idplano']) !!}
                                    </div>
                                </div>
                            </div> 
                            <div class="row border border-bottom-0">
                                <div class="row">
                                    {!! Form::label('Datos Catastro:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Sección:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('seccion', null, ['class' => 'form-control', 'id' => 'idseccion']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Chacra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('chacra', null, ['class' => 'form-control', 'id' => 'idchacra']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('manzana', null, ['class' => 'form-control', 'id' => 'idmanzana']) !!}
                                            </div>
                                        </div>
                                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Finca:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('finca', null, ['class' => 'form-control', 'id' => 'idfinca']) !!}
                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Edificio:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('edif', null, ['class' => 'form-control', 'id' => 'idedif']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Piso:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('piso', null, ['class' => 'form-control', 'id' => 'idpiso']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Departamento:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('depto', null, ['class' => 'form-control', 'id' => 'iddepto']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Escalera:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('esca', null, ['class' => 'form-control', 'id' => 'idesca']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('Unidad funcional:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('unfun', null, ['class' => 'form-control', 'id' => 'idunfun']) !!}
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>       
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 border">
                                    <div class="row">
                                        {!! Form::label('Identificacion S/Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Manzana:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('letmanza', null, ['class' => 'form-control', 'id' => 'idempmanza']) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 border border-start-0">
                                    <div class="row">
                                        {!! Form::label('Identificacion Municipal:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('N° Calle:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('numcalle', null, ['class' => 'form-control', 'id' => 'idnumcalle']) !!}
                                            </div>
                                        </div> --}}
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('Nombre Calle:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('nomcalle', null, ['class' => 'form-control', 'id' => 'idnomcalle']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('Entre Calles:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::text('ent_calles', null, ['class' => 'form-control', 'id' => 'identcalle']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('N° Finca:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('num_finca', null, ['class' => 'form-control', 'id' => 'idnumfinca']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('Superficie Lote:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                                {!! Form::number('sup_lote', null, ['class' => 'form-control', 'id' => 'idsuplote']) !!}
                                            </div>
                                        </div>
                                    </div> --}}
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
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>            
                                            
                                                
                                            
                                            
                                            
                                            
                                            
                                        
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
