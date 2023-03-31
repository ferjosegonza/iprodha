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
                {!! Form::model($unaOferta, ['method' => 'PUT', 'route' => ['ofeobra.update', encrypt($unaOferta->idobra)]]) !!}
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
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nomobra', $unaOferta->nomobra, ['class' => 'form-control', 'required' => 'required', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                                        {!! Form::select('idloc', $Localidad, $unaOferta->idloc, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select', $editaTodo
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::select('idempresa', $Empresa, $unaOferta->idempresa, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select', $editaTodo
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::select('idtipocontrato', $TipoContrato, $unaOferta->idtipocontratofer, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::date('publica', $unaOferta->publica, [
                                            'min' => '2022-01-01',
                                            'max' => \Carbon\Carbon::now()->year . '-12',
                                            'id' => 'periodo',
                                            'class' => 'form-control',
                                            $editaTodo
                                        ]) !!}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idexpediente', $unaOferta->idexpediente, ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Exp.Nro.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {{-- {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!} --}}
                                        {!! Form::text('exp_numero', $unaOferta->getExpediente->exp_numero, ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Exp.Asunto::', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}                   
                                        {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::textarea('exp_Asunto', $unaOferta->getExpediente->exp_asunto, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 12vh', $editaTodo]) !!}

                                        {{-- {!! Form::textarea('exp_Asunto', $unaOferta->getExpediente->exp_asunto, ['class' => 'form-control', 'required' => 'required']) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monviv', $unaOferta->monviv, ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('moninf', $unaOferta->moninf, ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monnex', $unaOferta->monnex, ['class' => 'form-control', $editaTodo]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        <input class="form-control" name="montotope" type="text" value="@money($unaOferta->montotope)" {{$editaTodo}}>
                                        {{-- {!! Form::text('montotope', $unaOferta->montotope, ['class' => 'form-control', $editaTodo]) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto p-2"></div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
                                            {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                                            {!! Form::text('plazo', $unaOferta->plazo, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="p-2" style="background-color: rgb(223, 188, 144)">
                                        <div class="form-group">
                                            {!! Form::label('Año y Mes de Cotización:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;',
                                            ]) !!}
                                            {{-- <input min="2022-01-01" max="{{\Carbon\Carbon::now()->year . '-12'}}" id="periodo" class="form-control" name="anioymes" type="month" value="{{$unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion}}"> --}}
                                            {!! Form::month('anioymes', $unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion, [
                                                'min' => '2022-01-01',
                                                'max' => \Carbon\Carbon::now()->year . '-12',
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => '']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-outline-primary ']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="section-body">
            <div hidden>
                @if(Auth::user()->hasRole('EMPRESA'))
                {{ $editaTodo='disabled'}}
                @else
                {{ $editaTodo='enabled' }} 
                @endif
            </div>
            {!! Form::model($unaOferta, ['method' => 'PUT', 'route' => ['ofeobra.update', encrypt($unaOferta->idobra)]]) !!}
                @include('layouts.modal.mensajes')
                @csrf
                @method('PUT')
                
                <fieldset  style="" {{ $editaTodo ?? '' }} >
                    <div style="width:99%;float:left;" >
                        <div hidden>
                            {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <div style="width:65%;float:left;margin-left:1%;" >                              
                            {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('nomobra', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div style="width:25%;float:left;margin-left:1%;">
                            {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;width:20%;']) !!}
                            {!! Form::select('idloc', $Localidad, $unaOferta->idloc, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                            ]) !!}
                        </div>
                    </div>
                    
                    <div style="width:99%;float:left;">
                        <div style="width:45%;float:left;margin-left:1%;">
                            {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::select('idempresa', $Empresa, $unaOferta->id_emp, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                            ]) !!}
                        </div>
                        <div style="width:30%;float:left;margin-left:1%;">
                            {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::select('idtipocontrato', $TipoContrato, $unaOferta->idtipocontratofer, [
                                'placeholder' => 'Seleccionar',
                                'class' => 'form-select',
                            ]) !!}
                        </div>
                        <div style="width:15%;float:left;margin-left:1%;">
                            {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::date('periodo', \Carbon\Carbon::now(), [
                                'min' => '2022-01-01',
                                'max' => \Carbon\Carbon::now()->year . '-12',
                                'id' => 'periodo',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div style="width:20%;float:left;margin-left:1%;">
                            {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('idexpediente', null, ['class' => 'form-control']) !!}
                        </div>
                        <div style="width:15%;float:left;margin-left:1%;">
                            {!! Form::label('Exp.Nro.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('exp_numero', $unaOferta->getExpediente->exp_numero, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div style="width:60%;float:left;margin-left:1%;">     
                            {!! Form::label('Exp.Asunto::', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}                   
                            {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('exp_Asunto', $unaOferta->getExpediente->exp_asunto, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>
                
                    <div style="width:99%;float:left; ">
                        <div style="width:24%;float:left;margin-left:1%;">
                            {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('monviv', $unaOferta->monviv, ['class' => 'form-control']) !!}
                        </div>
                        <div style="width:24%;float:left;margin-left:1%;">
                            {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('moninf', $unaOferta->moninf, ['class' => 'form-control']) !!}
                        </div>
                        <div style="width:24%;float:left;margin-left:1%;">
                            {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('monnex', $unaOferta->monnex, ['class' => 'form-control']) !!}
                        </div>
                        <div style="width:19%;float:left;margin-left:1%;">
                            {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::label('montotope', $unaOferta->montotope, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </fieldset >
                <div style="width:99%;float:left;background-color: rgb(236, 208, 194); padding:1%;margin-top:1%;">
                    <div style="width:19%;float:left;margin-left:1%;">
                        {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                        {!! Form::text('plazo', null, ['class' => 'form-control']) !!}
                    </div>
                    {{-- {{\Carbon\Carbon::now()->format('m-Y')}} 
                    {{-- {{$unaOferta->mescotizacion}} 
                    <div style="width:19%;float:left;margin-left:1%;">
                        {!! Form::label('Año y Mes de Cotización:', null, [
                            'class' => 'control-label',
                            'style' => 'white-space: nowrap;',
                        ]) !!}
                        {!! Form::month('anioymes', \Carbon\Carbon::now(), [
                            'min' => '2022-01-01',
                            'max' => \Carbon\Carbon::now()->year . '-12',
                            'id' => 'periodo',
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                {!! Form::submit('Grabar', ['class' => 'btn btn-warning mt-2']) !!}
            {!! Form::close() !!}
            
        </div>

        <div class="mt-2" style="width:10%;float:left;margin-left:0%;">
            {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => 'display:inline']) !!}
            {!! Form::submit('Volver', ['class' => 'btn btn-primary ']) !!}
            {!! Form::close() !!}
        </div> 
    </section> --}}
@endsection

