@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading py-2">Validar la oferta de la Obra</div>
    </div>    
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')

            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card border border-3 border-success" id="info-obra-card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Información de la Obra</h5></div>                        
                        </div>
                        <div class="card-body">
                            {{-- <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text($data->idobra, null, ['style' => 'disabled;' ]) !!}
                            </div> --}}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="form-group">
                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="info-obra" checked>
                                            {!! Form::label('Obra:', null, ['class' => 'control-label form-check-label', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                                        </div> --}}
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('nombobra', $data->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'info-obra-input']) !!}
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
                                        {!! Form::text('nom_emp', $data->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id'=>'empresa']) !!}
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
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="viv-input" id="info-viv" checked>
                                            {!! Form::label('Vivienda:', null, ['class' => 'control-label form-check-label', 'style' => 'white-space: nowrap;']) !!}
                                        </div> 
                                        {{-- {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!} --}}
                                        {!! Form::text('monviv',"$".number_format($obra->monviv,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control border border-success', 'readonly'=> 'true', 'id' => 'viv-input']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="infra-input" id="info-infra" checked>
                                            {!! Form::label('Infraestructura:', null, ['class' => 'control-label form-check-label', 'style' => 'white-space: nowrap;']) !!}
                                        </div> 
                                        {{-- {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!} --}}
                                        {!! Form::text('moninf',"$".number_format($obra->moninf,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control border border-success', 'readonly'=> 'true', 'id'=>'infra-input']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="nexo-input" id="info-nexo" checked>
                                            {!! Form::label('Nexo:', null, ['class' => 'control-label form-check-label', 'style' => 'white-space: nowrap;']) !!}
                                        </div> 
                                        {{-- {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!} --}}
                                        {!! Form::text('monnex',"$".number_format($obra->monnex,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control border border-success', 'readonly'=> 'true', 'id'=>'nexo-input']) !!}
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
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="plazo-input" id="info-plazo" checked>
                                                {!! Form::label('Plazo:', null, ['class' => 'control-label form-check-label',  'style' => 'white-space: nowrap;']) !!}
                                            </div> 
                                            {{-- {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!} --}}
                                            {!! Form::text('plazo',$obra->plazo, ['style' => 'disabled;', 'class' => 'form-control border border-success', 'readonly'=> 'true', 'id'=>'plazo-input']) !!}
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="anio-input" id="info-anio" checked>
                                                {!! Form::label('Año y Mes de Cotización:', null, [
                                                'class' => 'control-label form-check-label',
                                                'style' => 'white-space: nowrap;'
                                                ]) !!}
                                            </div>
                                            {{-- {!! Form::label('Año y Mes de Cotización:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;'
                                            ]) !!} --}}
                                            @if ($obra->mescotizacion !=null and $obra->aniocotizacion !=null)
                                            
                                            {!! Form::month('anioymes', $obra->aniocotizacion. '-' .$obra->mescotizacion, [
                                                'class' => 'form-control border border-success',
                                                'readonly'=> 'true',
                                                'id' => 'anio-input',
                                            ]) !!}                                       
                                            @else
                                            {!! Form::text('cotizacion', 'No se ha definido una fecha' , ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true' ]) !!}
                                            @endif
                                            {{-- <input min="2022-01-01" max="{{\Carbon\Carbon::now()->year . '-12'}}" id="periodo" class="form-control" name="anioymes" type="month" value="{{$unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion}}"> --}}
                                            
                                        </div>
                                    </div>
                                </div>                     
                            </div>
                            {{-- <div class="row">
                                <label>Validar los datos de la oferta.</label>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="col-6">
                                    {!! Form::label('Comentarios:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                                    {!! Form::textarea('descrip', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'required']) !!}
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card border border-3 border-success" id="info-items-card">
                    <div class="card-head">
                        <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="info-items-card" id="info-items" checked>
                            <strong>
                                {!! Form::label('Valor de item y sub-item', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>
                        {{-- <div class="text-center">
                            <h5>Ítems</h5>
                            <input class="form-check-input" type="checkbox" value="" id="" checked>
                        </div>                         --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="items" class="table table-hover mt-2" class="display">
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff;width:0.1%;"></th>
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
                <div class="card border border-3 border-success" id="info-items-gr-card">
                    <div class="card-head">
                        <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="info-items-gr-card" id="info-items-gr" checked>
                            <strong>
                                {!! Form::label('Items', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>                      
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mt-2">
                                <thead>
                                    <th class= 'text-center' style="color:#fff; width:5%;">Orden</th>
                                    <th class= 'text-center' style="color:#fff; width:10%;">Item</th>
                                    <th class= 'text-center' style="color:#fff; width:10%;">Tipo</th>
                                    <th class= 'text-center' style="color:#fff; width:10%;">Monto</th>
                                    <th class= 'text-center' style="color:#fff; width:10%;">% Incidencia</th>
                                </thead>
                                <tbody>
                                    @php
                                        $totalItems = number_format(floatval(0), 2);
                                        $totalInc = 0;
                                    @endphp
                                    @foreach ($items->sortBy('orden') as $item)
                                        <tr>
                                            <td class= 'text-center'>{{$item->orden}}</td>                                            
                                            <td class= 'text-center'>{{$item->nom_item}}</td>                                            
                                            <td class= 'text-center'>{{$item->nom_tipo}}</td>

                                            @if ($item->cod_tipo == 1)
                                                <td class= 'text-center'>${{number_format($item->vivienda,2, ',', '.')}}</td>
                                                @php
                                                    $totalItems += $item->vivienda;
                                                @endphp
                                            @else
                                                @if ($item->cod_tipo == 2)
                                                    <td class= 'text-center'>${{number_format($item->infra,2, ',', '.')}}</td>
                                                    @php
                                                        $totalItems += $item->infra;
                                                    @endphp
                                                @else
                                                    <td class= 'text-center'>${{number_format($item->vivienda + $item->infra,2, ',', '.')}}</td>
                                                    @php
                                                        $totalItems += $item->vivienda + $item->infra;
                                                    @endphp
                                                @endif            
                                            @endif

                                            <td class= 'text-center'>{{number_format($item->por_inc,4)}}</td>
                                            @php
                                                $totalInc += $item->por_inc;
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot align="right" style='background-color: #f3c48638;'>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">$ {{number_format($totalItems,2, ',', '.')}}</th>
                                        <th class="text-center">{{number_format($totalInc,4, ',', '.')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card border border-3 border-success" id="info-som-card">
                    <div class="card-head">
                        <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="info-som-card" id="info-som" checked>
                            <strong>
                            {!! Form::label('Impuestos', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>
                        {{-- <div class="text-center"><h5>Sombrero</h5></div>                         --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                         <table class="table table-hover mt-2">
                             <thead>
                                 <th class= 'text-center' scope="col" style="color:#fff;width:35%;">Concepto</th>
                                 <th class= 'text-center' scope="col" style="color:#fff;width:32%;">Total Vivienda</th>
                                 <th class= 'text-center' scope="col" style="color:#fff;width:32%;">Total Infraestructura</th>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             Subtotal 1
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($data->tot1viv,2, ',', '.')}}
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($data->tot1inf,2, ',', '.')}}
                                         </strong>
                                     </td>
                                 </tr>
                                 
                                 @php
                                     $flete = $sombreros->where('idconceptosombrero', '=', 10)->first()->valor ?? 0;
                                     $somfleteviv = $data->tot1viv * ($flete/100);
                                     $somfleteinfra = $data->tot1inf * ($flete/100);
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         Flete ( {{$flete}}% )
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         $ {{number_format($somfleteviv, 2, ',', '.')}}                                    
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         $ {{number_format($somfleteinfra, 2, ',', '.')}} 
                                     </td>
                                 </tr>
                                 @php
                                     $subtot2viv = $data->tot1viv + $somfleteviv;
                                     $subtot2infra = $data->tot1inf + $somfleteinfra;
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             Subtotal 2
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot2viv, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot2infra, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                 </tr>
                                 @php
                                     $gasto = $sombreros->where('idconceptosombrero', '=', 20)->first()->valor ?? 0;
                                     $somGastoviv = $subtot2viv * ($gasto/100);
                                     $somGastoinfra = $subtot2infra * ($gasto/100);
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         Gastos ( {{$gasto}}% )
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         $ {{number_format($somGastoviv, 2, ',', '.')}}
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         $ {{number_format($somGastoinfra, 2, ',', '.')}}
                                     </td>
                                 </tr>
                                 @php
                                     $subtot3viv = $subtot2viv + $somGastoviv;
                                     $subtot3infra = $subtot2infra + $somGastoinfra;
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             Subtotal 3
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot3viv, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot3infra, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                 </tr>
                                 @php
                                     $uti = $sombreros->where('idconceptosombrero', '=', 30)->first()->valor ?? 0;
                                     $somUtiviv = $subtot3viv * ($uti/100);
                                     $somUtiinfra = $subtot3infra * ($uti/100);
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         Utilidad ( {{$uti}}% )
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         $ {{number_format($somUtiviv, 2, ',', '.')}}
                                     </td>
                                     <td <td class= 'text-center' style="vertical-align: middle;">
                                         ${{number_format($somUtiinfra, 2, ',', '.')}}
                                     </td>
                                 </tr>
                                 @php
                                     $subtot4viv = $subtot3viv + $somUtiviv;
                                     $subtot4infra = $subtot3infra + $somUtiinfra;
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             Subtotal 4
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot4viv, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;">
                                         <strong>
                                             $ {{number_format($subtot4infra, 2, ',', '.')}}
                                         </strong>
                                     </td>
                                 </tr>
                                 @php
                                     $viv = $sombreros->where('idconceptosombrero', '=', 40)->first()->valor ?? 0;
                                     $infra = $sombreros->where('idconceptosombrero', '=', 50)->first()->valor ?? 0;
                                     $somViv = $subtot4viv * ($viv/100);
                                     $somInfra = $subtot4infra * ($infra/100);
                                 @endphp
                                 <tr>
                                     @if($viv != 0)
                                         @if ($infra != 0)
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 IVA + IIBR (Vivienda: {{$viv}}%, Infraestructura: {{$infra}}%)
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somViv, 2, ',', '.')}}
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somInfra, 2, ',', '.')}}
                                             </td>
                                         @else
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 IVA + IIBR (Vivienda: {{$viv}}%, Infraestructura: No existe)
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somViv, 2, ',', '.')}}
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somInfra=0, 2, ',', '.')}}
                                             </td>
                                         @endif
                                     @else
                                         @if ($infra != 0)
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 IVA + IIBR (Vivienda: No existe, Infraestructura: {{$infra}}%)
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somViv, 2, ',', '.')}}
                                             </td>    
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somInfra, 2, ',', '.')}}
                                             </td>
                                         @else
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 IVA + IIBR (Vivienda: No existe, Infraestructura: No existe)
                                             </td>
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somViv=0,2, ',', '.')}}
                                             </td>    
                                             <td class= 'text-center' style="vertical-align: middle;">
                                                 $ {{number_format($somInfra=0,2, ',', '.')}}
                                             </td>
                                         @endif        
                                     @endif                     
                                 </tr>
                                 @php
                                     $subtot5viv = $subtot4viv + $somViv;
                                     $subtot5infra = $subtot4infra + $somInfra;
                                     $totalDef = $subtot5viv + $subtot5infra;
                                 @endphp
                                 <tr>
                                     <td class= 'text-center' style="vertical-align: middle;"><strong>Totales</strong></td>
                                     <td class= 'text-center' style="vertical-align: middle;"><strong>
                                         $ {{number_format($subtot5viv, 2, ',', '.')}}</strong>
                                     </td>
                                     <td class= 'text-center' style="vertical-align: middle;"><strong>
                                         $ {{number_format($subtot5infra, 2, ',', '.')}}</strong>
                                     </td>
                                 </tr>
                             </tbody>     
                         </table>
                         <p class="text-center" style="font-size:18px;">
                             TOTAL:
                             <strong>
                                 $ {{number_format($totalDef, 2, ',', '.')}}
                                 {{-- $ {{$totalDef}} --}}
                             </strong>
                         </p>                       
                        </div>
                     </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card border border-3 border-success" id="info-crono-card">
                    <div class="card-head">
                        <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="info-crono-card" id="info-crono" checked>
                            <strong>
                            {!! Form::label('Cronograma', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>
                        {{-- <div class="text-center"><h5>Cronograma</h5></div>                         --}}
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
                <div class="card border border-3 border-success" id="crono-desem-card">
                    <div class="card-head">
                        <div class="row mt-3">
                            <div class="col-4">
                                <h5 class="ml-4">Anticipo: {{$obra->anticipo}} % {{$obra->getAnticipo->nom_tipo_anticipo ?? null}}</h5>
                            </div>
                            <div class="col-4 text-center">
                                <div class="form-check text-center">
                                    <input class="form-check-input fs-5" type="checkbox" value="crono-desem-card" id="info-crono-desem" checked>
                                    <strong>
                                    {!! Form::label('Cronograma de desembolso', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                                    </strong>
                                </div>     
                            </div>
                            <div class="col-4">
                            </div>         
                        </div>

                        {{-- <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="crono-desem-card" id="info-crono-desem" checked>
                            <strong>
                            {!! Form::label('Cronograma de desembolso', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>                         --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mt-2">
                                <thead>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:20%;">Meses</th>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:40%;">Montos mensuales</th>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:40%;">Montos acumulados</th>
                                </thead>
                                <tbody>
                                    @php
                                        $costoAcu = 0
                                    @endphp
                                    @foreach($desembolsos as $desembolso)
                                        @php
                                            $costoAcu += $desembolso->costo
                                        @endphp
                                        <tr>
                                            <td class= 'text-center'>MES {{$desembolso->mes}}</td>

                                            <td class= 'text-center'>@money($desembolso->costo)</td>

                                            <td class= 'text-center'>@money($costoAcu)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                             
                            </table>                      
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card border border-3 border-success" id="crono-gra-card">
                    <div class="card-head">
                        <br>
                        <div class="form-check text-center">
                            <input class="form-check-input fs-5" type="checkbox" value="crono-gra-card" id="gra-crono-desem" checked>
                            <strong>
                            {!! Form::label('Grafico de desembolso', null, ['class' => 'control-label form-check-label fs-5', 'style' => 'white-space: nowrap;', 'for' => 'flexCheckChecked']) !!}
                            </strong>
                        </div>                         
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12" style="display: none;" id="cardComentario" >
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                {!! Form::open(['method' => 'GET',
                                        'class' => 'rechazar',
                                        'route' => ['ofeobra.rechazar', base64url_encode($data->idobra)],
                                        'style' => 'display:inline',
                                        'id' => 'rechazarOfe']) !!}
                                <label class="control-label" style="">Se rechazo la oferta de obra debido a:</label>
                                {{-- {!! Form::label('Se rechazo la oferta debido a:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!} --}}
                                {!! Form::textarea('comentario', null, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'required']) !!}
                            </div>
                            <div hidden>
                                {!! Form::text('nombobra', $data->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'info-obra-input']) !!}
                                {!! Form::text('nom_emp', $data->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id'=>'empresa']) !!}
                            </div>
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
                                <div class="" style="padding-left: 30%" id="botonVR">
                                    
                                    {!! Form::submit('RECHAZAR', ['class' => 'btn btn-danger', 'style' => 'width: 40%; display:none', 'id'=>'btnRechazar']) !!}
                                    {!! Form::close() !!}
                                    @if ($obra->getEstados->sortByDesc('actual')->first()->getEstado->idestado == 2)
                                        {!! Form::open([
                                            'method' => 'POST',
                                            'route' => ['ofeobra.validar', base64url_encode($data->idobra)],
                                            'class' => 'validacion',
                                            'style' => 'display:inline',
                                            'files'=>'true']) !!}
                                        
                                            {!! Form::submit('VALIDAR', ['class' => 'btn btn-success mr-2', 'style' => 'width: 40%; display: ;', 'id'=>'btnValidar']) !!}
                                            <div hidden>
                                                {!! Form::text('nombobra', $data->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'info-obra-input']) !!}
                                                {!! Form::text('nom_emp', $data->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id'=>'empresa']) !!}
                                            </div>
                                        {!! Form::close() !!}
                                    @endif
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
<script src="{{ asset('js/Obrasyfinan/Ofertas/validar.js') }}"></script>
<script src="{{ asset('js/Obrasyfinan/Ofertas/index_oferta.js') }}"></script>
<script>
    contadorMes = {{$cronograma->last()->mes;}}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

  
<script>
    contadorMes = {{$cronograma->last()->mes}};
    meses = [];
    let acu = 0;
    monto = [];
    var app = @json($desembolsos);
    
    app.forEach(element => {
        // console.log(element.costo.toFixed(2));
        acu += Number(element.costo);
        monto.push(acu.toFixed(2));
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
</script>
@endsection
