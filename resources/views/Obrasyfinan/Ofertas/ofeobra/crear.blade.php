@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Nueva Oferta de Obra</div>
        </div>
        <div class="section-body">
            <div class="row">
                {!! Form::open(['route' => 'ofeobra.store', 'method' => 'POST', 'class' => 'form-prevent-multiple-submits']) !!}
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nomobra', null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        <select name="idloc" class="selectpickerLoc w-100 form-select"  placeholder="Seleccionar" required>
                                            @foreach ($Localidad as $unaLocalidad)
                                                <option value="{{$unaLocalidad->id_loc}}">{{$unaLocalidad->nom_loc}}</option>
                                            @endforeach
                                        </select>
                                        {{-- {!! Form::select('idloc', $Localidad, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        <select name="idempresa" class="selectpicker w-100 form-select"  placeholder="Seleccionar" required>
                                            @foreach ($Empresa as $unaEmpresa)
                                                <option value="{{$unaEmpresa->id_emp}}">{{$unaEmpresa->nom_emp}}</option>
                                            @endforeach
                                        </select>
                                        {{-- {!! Form::select('idempresa', $Empresa, null, ['placeholder' => 'Seleccionar', 'class' => 'form-select selectpicker']) !!}                                        --}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idtipocontrato', $TipoContrato, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Situacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {!! Form::select('idsituacion', $TipoSituacion, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Numero del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('numExp', null, ['class' => 'form-control', 'placeholder' => '00000-A/00', 'required','onkeyup' => 'javascript:this.value=this.value.toUpperCase()']) !!} 
                                        {{-- {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!}  --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('monviv', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('moninf', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::number('monnex', null, ['readonly','class' => 'form-control']) !!}
                                    </div>
                                </div> --}}
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Numero del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control col-lg-4" placeholder="00000" aria-label="Username">
                                            <span class="input-group-text">-</span>
                                            <input type="text" class="form-control col-lg-2" placeholder="A" aria-label="Server" style="width: 5px">
                                            <span class="input-group-text">/</span>
                                            <input type="text" class="form-control col-lg-2" placeholder="00" aria-label="Server">
                                        </div>
                                    </div>         
                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" type="text" name="montotope" value = '0.00' data-type="currency">
                                        </div>
                                        {{-- {!! Form::number('montotope', null, ['class' => 'form-control']) !!} --}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('publica', \Carbon\Carbon::now(), [
                                            'min' => '2022-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'fec_pub',
                                            'class' => 'form-control',
                                            'readonly'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="d-flex">
                                        <div class="me-auto p-2"></div>
                                        <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                            <div class="form-group">
                                                {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                                <span class="obligatorio">*</span>
                                                {!! Form::number('plazo', null, ['class' => 'form-control', 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                            <div class="form-group">
                                                {!! Form::label('Año y Mes de Cotización:', null, [
                                                    'class' => 'control-label',
                                                    'style' => 'white-space: nowrap;',
                                                ]) !!}
                                                <span class="obligatorio">*</span>
                                                {!! Form::month('anioymes', \Carbon\Carbon::now(), [
                                                    'min' => '2022-01-01',
                                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                                    'id' => 'periodo',
                                                    'class' => 'form-control',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto p-2"></div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
                                            {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                            <span class="obligatorio">*</span>
                                            {!! Form::number('plazo', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
                                            {!! Form::label('Año y Mes de Cotización:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            <span class="obligatorio">*</span>
                                            {!! Form::month('anioymes', \Carbon\Carbon::now(), [
                                                'min' => '2022-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'id' => 'periodo',
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>                      
                            </div> --}}
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto my-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('CREAR-OFEOBRA')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success button-prevent-multiple-submits']) !!}
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
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
    <script src="{{ asset('js/Obrasyfinan/Ofertas/crear_oferta.js') }}"></script>
    <script src="{{ asset('js/input-format-dinero.js') }}"></script>
    <script src="{{ asset('js/prevent_multiple_submits.js') }}"></script>
    <script>
        function oneClick() {
        // Disable the button
            document.getElementById("btnGuardar").disabled = true;
        }
    </script>
@endsection
