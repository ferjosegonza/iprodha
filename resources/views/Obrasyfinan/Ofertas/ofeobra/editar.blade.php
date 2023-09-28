@extends('layouts.app')
@section('css')
    
    <link rel="stylesheet" href="{{ asset('css/Obrasyfinan/ofeobra.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo">Editar Oferta de la Obra: {{$unaOferta->nomobra}} </div>
        </div>
        <div class="section-body">
            <div hidden>
                @if(Auth::user()->hasRole('EMPRESA'))
                {{ $editaTodo='disabled'}}
                @else
                {{ $editaTodo='enabled' }} 
                @endif
            </div>
            <div class="row">
                @can('EDITAR-OFEOBRA')
                {!! Form::model($unaOferta, ['method' => 'PUT', 'route' => ['ofeobra.update', base64url_encode($unaOferta->idobra)]]) !!}
                @endcan
                @csrf
                @method('PUT')
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-11">
                    <div class="card">
                        <div class="card-body">

                            <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('nomobra', $unaOferta->nomobra, ['class' => 'form-control', 'required' => 'required', $editaTodo]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label fs-6']) !!}
                                        <span class="obligatorio">*</span>
                                        <select name="idloc" class="selectpickerLoc w-100 form-select"  placeholder="Seleccionar" required {{$editaTodo}}>
                                            @foreach ($Localidad as $unaLocalidad)
                                                @if ($unaLocalidad->id_loc == $unaOferta->idloc)
                                                    <option value="{{$unaLocalidad->id_loc}}" selected>{{$unaLocalidad->nom_loc}}</option>
                                                @else
                                                    <option value="{{$unaLocalidad->id_loc}}">{{$unaLocalidad->nom_loc}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        <select name="idempresa" class="selectpicker w-100 form-select"  placeholder="Seleccionar" required {{$editaTodo}}>
                                            @foreach ($Empresa as $unaEmpresa)
                                                @if ($unaEmpresa->id_emp == $unaOferta->idempresa)
                                                    <option value="{{$unaEmpresa->id_emp}}" selected>{{$unaEmpresa->nom_emp}}</option>
                                                @else
                                                    <option value="{{$unaEmpresa->id_emp}}">{{$unaEmpresa->nom_emp}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idtipocontrato', $TipoContrato, $unaOferta->idtipocontratofer, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Situacion:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idsituacion', $TipoSituacion, $unaOferta->id_situacion, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required', $editaTodo
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    
                                </div>
                                
                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Operatoria:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idope', $TipoOpe, $unaOferta->id_ope ?? null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo de oferta:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idtipofe', $TipoOferta, $unaOferta->id_tip_obr ?? null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo obra:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idtipobr', $TipoObra, $unaOferta->id_tipo_obra ?? null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'required',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Numero de Licitacion:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('numlic', $unaOferta->num_lic ?? null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'data-type' => 'numlic',
                                            'style' => 'text-transform:uppercase',
                                            'onkeyup' => 'javascript:this.value=this.value.toUpperCase()',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Numero del exp:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('numExp', trim($unaOferta->getExpediente->exp_numero, " ") ?? '', ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idexpediente', $unaOferta->idexpediente ?? '', ['class' => 'form-control', 'readonly' ,$editaTodo]) !!}
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Exp.Asunto:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::textarea('exp_Asunto', $unaOferta->getExpediente->exp_asunto ?? '', ['class'=>'form-control', 'readonly','rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 12vh', $editaTodo]) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monviv', '$ '.number_format(($unaOferta->monviv ?? 0), 2, ',','.'), ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('moninf', '$ '.number_format(($unaOferta->moninf ?? 0), 2, ',','.'), ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monnex', '$ '.number_format(($unaOferta->monnex ?? 0), 2, ',','.'), ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="montotope" data-type="currency" value="@money($unaOferta->montotope)" {{$editaTodo}}>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::date('publica', $unaOferta->publica, [
                                            'min' => '2022-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'periodo',
                                            'class' => 'form-control',
                                            'readonly'
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap;']) !!}
                                        <div class="input-group mb-3">
                                            {{-- <span class="input-group-text">$</span> --}}
                                            <input class="form-control" type="text" name="montotope" data-type="currency" value="@money($unaOferta->montotope)" {{$editaTodo}}>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="d-flex">
                                        <div class="me-auto p-2"></div>
                                        <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                            <div class="form-group">
                                                {!! Form::label('Plazo:', null, ['class' => 'control-label fs-6',  'style' => 'white-space: nowrap;']) !!}
                                                <span class="obligatorio">*</span>
                                                {!! Form::text('plazo', $unaOferta->plazo, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                            <div class="form-group">
                                                {!! Form::label('Año y Mes de Cotización:', null, [
                                                    'class' => 'control-label fs-6',
                                                    'style' => 'white-space: nowrap;',
                                                ]) !!}
                                                <span class="obligatorio">*</span>
                                                {!! Form::month('anioymes', $unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion, [
                                                    'min' => '2022-01-01',
                                                    'max' => \Carbon\Carbon::now()->year . '-12',
                                                    'class' => 'form-control',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto my-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @can('EDITAR-OFEOBRA')
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                        
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-primary ']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{ asset('js/Obrasyfinan/Ofertas/crear_oferta.js') }}"></script>
    <script src="{{ asset('js/input-format-dinero.js') }}"></script>
    <script src="{{ asset('js/formato/input-format-num-lic.js') }}"></script>
@endsection

