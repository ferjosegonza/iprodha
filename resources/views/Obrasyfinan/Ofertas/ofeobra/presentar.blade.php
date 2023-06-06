@extends('layouts.app')
@section('content')

<head><link rel="stylesheet" href="{{asset('css/ofeobra/presentar.css')}}">
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading" style="padding:10px">
            Presentar obra
        </div>       
        <div class="dropdown" style="float:right;">
            <button class="dropbtn">
                <i class="fas fa-print" style="color: #ffffff;"></i>
            </button>
            <div class="dropdown-content">
                <a href={{route('archivo.consultar')}} target="_blank">Imprimir Todo</a>
                <a href={{route('ofeobra.pdf2', $data->idobra)}} target="_blank">Informacion de obra y sombrero</a>
                <a href={{route('ofeobra.pdf1', $data->idobra)}} target="_blank">Items y cronograma</a>
            </div>
        </div>
    </div>    
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')
            <div class="row">                
                <div class="col-xs-12 col-sm-12 col-md-12"">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Información de la Obra</h5></div>                        
                        </div>
                        <div class="card-body">
                            <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text($data->idobra, null, ['style' => 'disabled;' ]) !!}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $data->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_loc', $data->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $data->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Ítems</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="items" class="table table-hover mt-2" class="display">
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;"></th>
                                    <th class="text-center" scope="col" style="color:#fff;width:20%;">Orden</th>                                    
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Ítem</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Tipo</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:30%;">Monto Total</th>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td></td>
                                            <td class= 'text-center'>{{$item->orden}}</td>                                            
                                            <td class= 'text-center'>{{$item->nom_item}}</td>                                            
                                            <td class= 'text-center'>{{$item->nom_tipo}}</td>
                                            @if (strcmp($item->nom_tipo, "VIVIENDA")==0)
                                            <td class= 'text-center'>${{number_format($item->vivienda,2, ',', '.')}}</td>
                                            @else
                                                @if (strcmp($item->nom_tipo, "INFRAESTRUCTURA")==0)
                                                <td class= 'text-center'>${{number_format($item->infra,2, ',', '.')}}</td>
                                                @else
                                                <td class= 'text-center'>${{number_format($item->vivienda + $item->infra,2, ',', '.')}}</td>
                                                @endif            
                                            @endif
                                            <td>{{$item->iditem}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Cronograma</h5></div>                        
                    </div>
                    <div class="card-body">
                        @php
                            $contador = 1;
                            $contadorMes = $cronograma->last()->mes;
                        @endphp
                        {{-- {{$contadorMes = $cronograma->sortByDesc('mes')->first()->mes}} --}}
                        <div class="table-responsive">
                            <table class="table table-hover mt-2" id='cronogramaa'>
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Denom. Ítem</th>
                                    @while($contador <= $contadorMes)
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">{{$contador}}</th>
                                        @php
                                            $contador = $contador+1;
                                        @endphp
                                    @endwhile
                                </thead>
                                <tfoot align="right" style='background-color: #f3c48638;'>
                                    <tr> <th></th><th></th>
                                    @for($i = 1; $i <= $contadorMes; $i++)
                                        <th></th>
                                    @endfor
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $contador = 1;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$item->orden}}</td>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$item->nom_item}}</td>
                                            @while ($contador <= $contadorMes)
                                                @if (is_null($cronograma->where('iditem', $item->iditem)->where('mes', $contador)->first()))
                                                    <td class= 'text-center' style="vertical-align: middle;"></td>
                                                @else
                                                    <td class= 'text-center' style="vertical-align: middle;">{{$cronograma->where('iditem', $item->iditem)->where('mes', $contador)->first()->avance}}</td>
                                                @endif

                                                @php
                                                    $contador = $contador+1;
                                                @endphp
                                            @endwhile
                                            @php
                                                $contador = 1;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>       

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Cronograma de desembolso</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover mt-2">
                                <thead>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:20%;"></th>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:40%;">Montos mensuales</th>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:40%;">Montos acumulados</th>
                                </thead>
                                <tbody>
                                    @foreach($desembolsos as $desembolso)
                                        <tr>
                                            <td class= 'text-center'>MES {{$desembolso->mes}}</td>

                                            <td class= 'text-center'>@money($desembolso->montomensual)</td>

                                            <td class= 'text-center'>@money($desembolso->acumulado)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                             
                            </table>                      
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Grafico de desembolso</h5></div>                        
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Sombrero</h5></div>                        
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                        <table id="example" class="table table-hover mt-2">
                            <thead>
                                <th class= 'text-center' scope="col" style="color:#fff;width:1%;"></th>
                                <th class= 'text-center' scope="col" style="color:#fff;width:3%;">Total Vivienda</th>
                                <th class= 'text-center' scope="col" style="color:#fff;width:3%;">Total Infraestructura</th>
                            </thead>
                            <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Subtotal 1</td>
                                <td class= 'text-center' style="vertical-align: middle;">${{number_format($data->tot1viv,2, ',', '.')}}</td>
                                <td class= 'text-center' style="vertical-align: middle;">${{number_format($data->tot1inf,2, ',', '.')}}</td>
                            </tr>
                            <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Flete ({{$sombreros->where('idconceptosombrero', 10)->first()->valor}}%)</td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($fleteviv=$data->tot1viv * (($sombreros->where('idconceptosombrero', '=', 10)->first()->valor)/100),2, ',', '.')}}                                    
                                </td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($fleteinf=$data->tot1inf * (($sombreros->where('idconceptosombrero', '=', 10)->first()->valor)/100),2, ',', '.')}} 
                                </td>
                            </tr>
                             <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Subtotal 2</td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot2viv=$data->tot1viv + $fleteviv,2, ',', '.')}}
                                </td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot2inf=$data->tot1inf + $fleteinf,2, ',', '.')}}
                                </td>
                            </tr> 
                            <tr>
                                <td <td class= 'text-center' style="vertical-align: middle;">Gastos ({{$sombreros->where('idconceptosombrero', '=', 20)->first()->valor}}%)</td>
                                <td <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($gastosviv=$tot2viv * (($sombreros->where('idconceptosombrero', '=', 20)->first()->valor)/100),2, ',', '.')}}
                                </td>
                                <td <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($gastosinf=$tot2inf * (($sombreros->where('idconceptosombrero', '=', 20)->first()->valor)/100),2, ',', '.')}}
                                </td>
                            </tr>
                            <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Subtotal 3</td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot3viv = $tot2viv + $gastosviv,2, ',', '.')}}
                                </td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot3inf = $tot2inf + $gastosinf,2, ',', '.')}}
                                </td>
                            </tr>
                            <tr>
                                <td <td class= 'text-center' style="vertical-align: middle;">Utilidad ({{$sombreros->where('idconceptosombrero', '=', 30)->first()->valor}}%)</td>
                                <td <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($utiviv=$tot3viv * (($sombreros->where('idconceptosombrero', '=', 30)->first()->valor)/100),2, ',', '.')}}
                                </td>
                                <td <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($utiinf=$tot3inf * (($sombreros->where('idconceptosombrero', '=', 30)->first()->valor)/100),2, ',', '.')}}
                                </td>
                            </tr>
                            <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Subtotal 4</td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot4viv = $tot3viv + $utiviv),2, ',', '.'}}
                                </td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot4inf = $tot3inf + $utiinf),2, ',', '.'}}
                                </td>
                            </tr>
                            <tr>
                                @if($sombreros->where('idconceptosombrero', '=', 40)->first() != null)
                                    @if ($sombreros->where('idconceptosombrero', '=', 50)->first() != null)
                                    <td class= 'text-center' style="vertical-align: middle;">IVA + IIBR (Vivienda: {{$sombreros->where('idconceptosombrero', '=', 40)->first()->valor}}%, Infraestructura: {{$sombreros->where('idconceptosombrero', '=', 50)->first()->valor}}%)</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivaviv=$tot4viv * (($sombreros->where('idconceptosombrero', '=', 40)->first()->valor)/100),2, ',', '.')}}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivainf=$tot4inf * (($sombreros->where('idconceptosombrero', '=', 50)->first()->valor)/100),2, ',', '.')}}</td>
                                    @else
                                    <td class= 'text-center' style="vertical-align: middle;">IVA + IIBR (Vivienda: {{$sombreros->where('idconceptosombrero', '=', 40)->first()->valor}}%, Infraestructura: No existe)</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivaviv=$tot4viv * (($sombreros->where('idconceptosombrero', '=', 40)->first()->valor)/100),2, ',', '.')}}</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivainf=0,2, ',', '.')}}</td>
                                    @endif
                                @else
                                    @if ($sombreros->where('idconceptosombrero', '=', 50)->first() != null)
                                    <td class= 'text-center' style="vertical-align: middle;">IVA + IIBR (Vivienda: No existe, Infraestructura: {{$sombreros->where('idconceptosombrero', '=', 50)->first()->valor}}%)</td>
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivaviv=0,2, ',', '.')}}</td>    
                                    <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivainf=$tot4inf * (($sombreros->where('idconceptosombrero', '=', 50)->first()->valor)/100),2, ',', '.')}}</td>
                                    @else
                                        <td class= 'text-center' style="vertical-align: middle;">IVA + IIBR (Vivienda: No existe, Infraestructura: No existe)</td>
                                        <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivaviv=0,2, ',', '.')}}</td>    
                                        <td class= 'text-center' style="vertical-align: middle;">${{number_format($ivainf=0,2, ',', '.')}}</class=>
                                    @endif        
                                @endif                     
                            </tr>
                            <tr>
                                <td class= 'text-center' style="vertical-align: middle;">Totales</td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot5viv = $tot4viv + $ivaviv,2, ',', '.')}}
                                </td>
                                <td class= 'text-center' style="vertical-align: middle;">
                                    ${{number_format($tot5inf = $tot4inf + $ivainf,2, ',', '.')}}
                                </td>
                            </tr>       
                        </table>
                        <p class="text-center" style="font-size:18px;">TOTAL: ${{number_format($total=$tot5viv + $tot5inf,2, ',', '.')}}</p>                       
                       </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <a href="{{ route('ofeobra.index') }}"class="btn btn-primary fo">Volver</a>
                            </div>
                            <div class="col-11">
                                <div class="" style="padding-left: 30%">
                                    {!! Form::open([
                                        'method' => 'POST',
                                        'route' => ['ofeobra.presentarSave', base64url_encode($data->idobra)],
                                        'class' => 'formulario',
                                        'style' => 'display:inline',
                                        'files'=>'true']) !!}
                                    
                                    {!! Form::submit('Presentar', ['class' => 'btn btn-success mr-2', 'style' => 'width: 40%']) !!}
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
<input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
@include('layouts.modal.confirmation') 
@endsection

@section('js')
<script src="{{ asset('js/Obrasyfinan/Ofertas/presentacion.js') }}"></script>

<script>
    contadorMes = {{$cronograma->last()->mes;}}
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

  
<script>
    contadorMes = {{$cronograma->last()->mes}};
    meses = [];
    monto = [0];
    var app = @json($desembolsos);

    app.forEach(element => {
        monto.push(Number(element.acumulado.toFixed(2)))
        console.log(element.acumulado)
    });

    for (let index = 0; index <= contadorMes; index++) {
        meses.push('mes '+index); 
    }
    meses.push('mes '+(contadorMes+1)); 
    const ctx = document.getElementById('myChart');
    // Chart.register(ChartDataLabels);
    
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
                    size: 18
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



</script>
@endsection
