@extends('layouts.app')

@section('content')
<style>
    .obligatorio {
        color: red;
    }
</style>
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nueva Obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'obravivienda.store', 'method' => 'POST', 'class' => 'formulario']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Numero: <span class="obligatorio">*</span></label>
                                        {{-- {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!} --}}
                                        
                                        {!! Form::number('num_obr', null, ['class' => 'form-control', 'required', 'id'=>'num_obr']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <div class="form-group">
                                        <label for="Obra:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Obra: <span class="obligatorio">*</span></label>
                                        {{-- {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!} --}}
                                        {!! Form::text('nom_obra', null, [
                                            'id'=>'nom_obr',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('idloc', $Localidad, 98, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="Empresa:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Empresa: <span class="obligatorio">*</span></label>
                                        {{-- {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!} --}}
                                        <select name="idempresa" class="selectpicker w-100 form-select"  placeholder="Seleccionar" required>
                                            @foreach ($Empresa as $unaEmpresa)
                                                @if ($unaEmpresa->id_emp == 0)
                                                    <option value="{{$unaEmpresa->id_emp}}" selected>{{$unaEmpresa->nom_emp}}</option>
                                                @else
                                                    <option value="{{$unaEmpresa->id_emp}}">{{$unaEmpresa->nom_emp}}</option>
                                                @endif
                                                {{-- <option value="{{$unaEmpresa->id_emp}}">{{$unaEmpresa->nom_emp}}</option> --}}
                                            @endforeach
                                        </select>
                                        {{-- {!! Form::select('idempresa', $Empresa, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!} --}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="Localidad:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Localidad: <span class="obligatorio">*</span></label>
                                        {{-- {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!} --}}
                                        <select name="idloc" class="selectpickerLoc w-100 form-select"  placeholder="Seleccionar" required>
                                            @foreach ($Localidad as $unaLocalidad)
                                            @if ($unaLocalidad->id_loc == 00)
                                                    <option value="{{$unaLocalidad->id_loc}}" selected>{{$unaLocalidad->nom_loc}}</option>
                                                @else
                                                    <option value="{{$unaLocalidad->id_loc}}">{{$unaLocalidad->nom_loc}}</option>
                                                @endif
                                                {{-- <option value="{{$unaLocalidad->id_loc}}">{{$unaLocalidad->nom_loc}}</option> --}}
                                            @endforeach
                                        </select>
                                        {{-- {!! Form::select('idloc', $Localidad, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select', 'required']) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Expediente:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('expediente', null, ['class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Operatoria:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {!! Form::select('idope', $TipoOpe, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Cantidad de viviendas:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Cant. Viviendas: <span class="obligatorio">*</span></label>
                                        {!! Form::number('can_viv', null, ['class' => 'form-control', 'required']) !!} 
                                    </div>
                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha inicio:', null, [
                                                'class' => 'control-label fs-6',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {!! Form::date('fec_ini', null, [
                                                'min' => '1900-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha fin:', null, [
                                                'class' => 'control-label fs-6',
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
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('plazo', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7  border">
                                    {!! Form::label('Etapa INICIAL:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                            <div class="form-group">
                                                {!! Form::label('N° Etapa:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                                {!! Form::number('num_eta', 1, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                            <div class="form-group">
                                                {!! Form::label('Descripcion:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                                <span class="obligatorio">*</span>
                                                {!! Form::text('descrip', null, ['class' => 'form-control', 'style' => 'text-transform:uppercase', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase()', 'required']) !!}
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    {!! Form::label('Viviendas:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                            <div class="form-group">
                                                <label for="Cantidad de viviendas:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Cantidad de Viviendas: <span class="obligatorio">*</span></label>
                                                {!! Form::number('can_viv', 0, ['class' => 'form-control', 'required', 'id'=>'can_viv']) !!} 
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                        {!! Form::label('Cantidad de Dormitorios:', null, ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                <div class="form-group">
                                                    {!! Form::label('0 (CERO):', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                                    {!! Form::number('can_viv_0', 0, ['class' => 'form-control', 'readonly']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                <div class="form-group">
                                                    {!! Form::label('2 (DOS):', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                                    {!! Form::text('can_viv_2', 0, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                <div class="form-group">
                                                    {!! Form::label('3 (TRES):', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                                    {!! Form::text('can_viv_3', 0, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                                <div class="form-group">
                                                    {!! Form::label('4 (CUATRO):', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                                    {!! Form::text('can_viv_4', 0, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div> --}}
                                
                                
                            </div>
                    
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('CREAR-OBRAVIVIENDA')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => 'obravivienda.index', 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary']) !!}
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
    @include('Planificacion.Planificacion.Obravivienda.mConfirmStore')
    <script src="{{ asset('js/Planificacion/Planificacion/Obravivienda/crear_obravivienda.js') }}"></script>
@endsection
