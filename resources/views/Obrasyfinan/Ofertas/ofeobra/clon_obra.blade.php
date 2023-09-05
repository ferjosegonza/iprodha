@extends('layouts.app')
@section('content')

<head><link rel="stylesheet" href="{{asset('css/ofeobra/presentar.css')}}">
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <div class="titulo page__heading py-1 fs-5">Clonar oferta de obra</div>
        </div>
        <div class="ms-auto">
        </div>
    </div>
    
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body border border-danger border-3" >
                        <label class="fs-5">
                            La oferta de obra actual no posee items, sub-items, cronograma y sombrero.
                        </label>
                    </div>
                </div>
            </div>
                          
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Información de la Obra</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div hidden>
                            {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text($obra->idobra, null, ['style' => 'disabled;' ]) !!}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                <div class="form-group">
                                    {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nom_loc', $obra->getLocalidad->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nom_emp', $obra->getEmpresa->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('tipocontrato', $obra->getTipoOferta->tipocontratofer, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('publicacion', $obra->publica, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>                                
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('idexp',$obra->idexpediente, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Exp.Nro.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    @if($obra->getExpediente != null)
                                        {!! Form::text('exp_numero', $obra->getExpediente->exp_numero, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    @else
                                        {!! Form::text('exp_numero',"-", ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('Exp.Asunto:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}                   
                                    {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    @if($obra->getExpediente != null)
                                    {!! Form::textarea('exp_asunto',$obra->getExpediente->exp_asunto,['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 12vh']) !!}
                                    @else
                                    {!! Form::text('exp_asunto',"No hay expediente", ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    @endif
                                    {{-- {!! Form::textarea('exp_Asunto', $unaOferta->getExpediente->exp_asunto, ['class' => 'form-control', 'required' => 'required']) !!} --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('monviv',"$".number_format($obra->monviv,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('moninf',"$".number_format($obra->moninf,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('monnex',"$".number_format($obra->monnex,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('montotope',"$".number_format($obra->montotope,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}   
                                        
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex">
                                <div class="me-auto p-2"></div>
                                <div class="p-2">
                                    <div class="form-group">
                                        {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('plazo',$obra->plazo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="form-group">
                                        {!! Form::label('Año y Mes de Cotización:', null, [
                                            'class' => 'control-label',
                                            'style' => 'white-space: nowrap;'
                                        ]) !!}
                                        @if ($obra->mescotizacion !=null and $obra->aniocotizacion !=null)
                                        
                                        {!! Form::month('anioymes', $obra->aniocotizacion. '-' .$obra->mescotizacion, [
                                            'class' => 'form-control',
                                            'readonly'=> 'true'
                                        ]) !!}                                       
                                        @else
                                        {!! Form::text('cotizacion', 'No se ha definido una fecha' , ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true' ]) !!}
                                        @endif
                                        {{-- <input min="2022-01-01" max="{{\Carbon\Carbon::now()->year . '-12'}}" id="periodo" class="form-control" name="anioymes" type="month" value="{{$unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion}}"> --}}
                                        
                                    </div>
                                </div>
                            </div>                     
                        </div>
                        
                    </div>
                </div>
            </div>
            @can('VALIDAR-OFEOBRA')
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Detalle a clonar</h5></div>                        
                    </div>
                    <div class="card-body">
                        {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobra.verclonar', base64url_encode($obra->idobra)],'style' => 'display:inline']) !!}                                    
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Obra N° DESTINO:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('num_obr_d', $obra->idobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}        
                                </div>
                            </div>
                            {{-- <div class="col">
                                <div class="form-group">
                                    <i class="fas fa-arrow-left" style='font-size: 5em'></i>
                                </div>
                            </div> --}}
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Obra N° ORIGEN:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::text('num_obr_o', null, ['style' => 'disabled;', 'class' => 'form-control', 'required']) !!}        
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('Acciones:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            {{-- <a href="{{ route('ofeobra.index') }}"class="btn btn-primary fo">Preparar</a> --}}
                                            {!! Form::submit('Preparar', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                        {{-- <div class="col">
                                            <a href="{{ route('ofeobra.index') }}"class="btn btn-success fo">Clonar</a>  
                                        </div> --}}
                                    </div>     
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @endcan

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <a href="{{ route('ofeobra.index') }}"class="btn btn-primary fo">Volver</a>
                            </div>
                            <div class="col-11">
                                
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
@include('layouts.modal.confirmation') 
@endsection

@section('js')
<script src="{{ asset('js/Obrasyfinan/Ofertas/presentacion.js') }}"></script>

{{-- <script>
    contadorMes = {{$cronograma->last()->mes;}}
</script> --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

  
{{-- <script>
    contadorMes = {{$cronograma->last()->mes}};
    meses = [];
    let acu = 0;
    monto = [];
    var app = @json($desembolsos);
    
    app.forEach(element => {
        acu += Number(element.costo);
        monto.push(acu.toFixed(2));
    });

    for (let index = 0; index <= contadorMes; index++) {
        meses.push('mes '+index); 
    }
    meses.push('mes '+(contadorMes+1)); 
    const ctx = document.getElementById('myChart');
    
    new Chart(ctx, {
       type: 'line',
       data: {
         labels: meses,
         datasets: [{
           label: 'Desembolso por mes',
           data: monto,
           borderWidth: 1,
           pointStyle: 'rect',
         }]
       },
       plugins: [ChartDataLabels],
       options: {
        plugins: {
      // Change options for ALL labels of THIS CHART
            datalabels: {
                font: {
                    size: 15
                },
            }
        },
         scales: {
           y: {
            beginAtZero: true
           },
         },
       }
     });
</script> --}}
@endsection
