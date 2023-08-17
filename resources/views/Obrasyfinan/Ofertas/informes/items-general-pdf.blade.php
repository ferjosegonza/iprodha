<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Items de la Oferta de Obra PDF</title>
</head>
<body style="margin-left: 3cm">
    <header style="margin-left: 1cm;">
        <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}">
        <label class="txt column-2"><br>{{$texto[0]->texto_1}}</label>
    </header>
    <footer style="margin-left: 3cm">   
    </footer>
    <section class="section">
        <div class="section-header">
            <h4 style="">INSTITUTO PROVISIONAL DE DESARROLLO HABITACIONAL</h4>            
        </div>
        <div class="section-body">
            <div class="section-border">      
                <div class="row">         
                    <div class="form-group">
                        <label><b>Obra: <b></label> 
                        <label>{{$obra->nomobra}}</label>
                    </div>             
                </div>
                <div class="row">
                    <div class="column-3 form-group">
                        <label><b>Localidad: <b></label>
                        <label>{{$obra->getLocalidad->nom_loc}}</label>                    
                    </div>   
                    <div class="column-3 form-group">
                        <label><b>Empresa:<b></label>
                        <label>{{$obra->getEmpresa->nom_emp}}</label>
                    </div>
                    {{-- <div class="column-3 form-group">
                        <label><b>Tipo de Contrato: <b></label>
                        <label>{{$obra->getTipoOferta->tipocontratofer}}</label>
                    </div> --}}
                </div>
                <div class="row">                          
                    <div class="column-4 form-group">                        
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{$obra->publica}}</label>
                        </div>
                    {{-- <div class="column-3 form-group"> 
                        <label><b>Código de barra del expediente:<b></label>
                        <label>{{$obra->idexpediente}}</label> 
                    </div>                     --}}
                    <div class="column-4 form-group"> 
                        <label><b>Expediente Número:<b></label>
                        <label>{{$obra->getExpediente->exp_numero}}</label>
                    </div>
                </div>
                {{-- <div class="row">        
                    <div class="form-group">             
                        <label><b>Asunto del Expediente:<b></label>
                        <label>{{$obra->getExpediente->exp_asunto}}</label>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="column-4 form-group"> 
                        <label><b>Vivienda:<b></label><br>
                        <label>${{number_format($obra->monviv,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Infraestructura:<b></label><br>
                        <label>${{number_format($obra->moninf,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Nexo:<b></label><br>
                        <label>${{number_format($obra->monnex,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Monto Tope:<b></label><br>
                        <label>${{number_format($obra->montotope,2, ',', '.')}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="column-2 form-group"> 
                    <label><b>Plazo:<b></label>
                    <label>{{$obra->plazo}}</label>
                    </div>
                    <div class="column-2 form-group"> 
                    <label><b>Año Y Mes De Cotización:<b></label>
                    <label>{{$obra->aniocotizacion. '-' .$obra->mescotizacion}}</label>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    
    @if($tieneInfra)
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto">ITEMS DE LA OFERTA DE OBRA - INFRAESTRUCTURA</h4>
        </div>
        <div class="section-body">
            <table class="table">
                <thead>
                    <th>Orden</th>
                    <th>Denominacion</th>
                    <th>Codigo</th>
                    <th>Monto</th>
                    <th>% costo</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $totalinc = 0;
                    @endphp
                    @foreach ($itemsInfra as $item)
                        <tr>
                            <td>{{$item->orden}}</td>
                            <td>{{$item->nom_item}}</td>
                            <td>{{$item->iditem}}</td>

                            
                            <td>$ {{number_format($item->infra,2, ',', '.')}}</td>
                            @php
                                $total += $item->infra;
                            @endphp
                            
                            <td>{{number_format($item->por_inc,4, ',', '.')}}</td> 
                            @php
                                $totalinc += $item->por_inc;
                            @endphp
                            {{-- <td>${{number_format($data->tot1viv,2, ',', '.')}}</td>
                            <td>${{number_format($data->tot1inf,2, ',', '.')}}</td> --}}
                        </tr>
                    @endforeach
                    <tr style="background-color: rgb(190, 190, 190)">
                        <td></td>
                        <td></td>
                        <td>Sub total 1:</td>
                        <td>
                            ${{number_format($total,2, ',', '.')}}
                        </td>
                        <td>
                            {{number_format($totalinc,4, ',', '.')}}
                        </td>
                    </tr>      
                </tbody>
            </table>
        </div>
    </section>
    
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto">TOTALES CON SOMBRERO</h4>
        </div>
        <div class="section-body">
            @php
                $contador = 2;
                $subtotal = $total;
            @endphp
            @foreach ($conceptos as $concepto)
            @if ($concepto->idconceptosombrero < 40)
                <table class="table" style="margin-top: 30px">
                    <thead>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Monto</th>
                        <th>SubTotal {{$contador}}</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$concepto->conceptosombrero}}</td>
                            <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                            <td>$ {{number_format((($subtotal*$concepto->valor)/100),2, ',', '.')}}</td>
                            <td>$ {{number_format(((($subtotal*$concepto->valor)/100)+$subtotal),2, ',', '.')}}</td>
                        </tr>
                        <tr style="background-color: rgb(190, 190, 190)">
                        </tr>
                    </tbody>
                </table>
                @php
                    $contador += 1;
                    $subtotal += $subtotal*($concepto->valor/100);
                @endphp
            @elseif($concepto->idconceptosombrero == 50)
                <table class="table" style="margin-top: 30px">
                    <thead>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Monto</th>
                        <th>SubTotal {{$contador}}</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$concepto->conceptosombrero}}</td>
                            <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                            <td>$ {{number_format((($subtotal*$concepto->valor)/100),2, ',', '.')}}</td>
                            <td>$ {{number_format(((($subtotal*$concepto->valor)/100)+$subtotal),2, ',', '.')}}</td>
                        </tr>
                        <tr style="background-color: rgb(190, 190, 190)">
                        </tr>
                    </tbody>
                </table>
                @php
                    $contador += 1;
                    $subtotal += $subtotal*($concepto->valor/100);
                    $totalInfra = $subtotal;
                @endphp
            @endif
        @endforeach
                <table class="table" style="margin-top: 30px">
                    <tbody>
                        <tr>
                            <th>MONTO TOTAL</th>
                            <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                        </tr>
                    </tbody>
                </table>
        </div>
    </section>
    @endif

    @if(1)
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto">ITEMS DE LA OFERTA DE OBRA - VIVIENDA</h4>
        </div>
        <div class="section-body">
            <table class="table">
                <thead>
                    <th>Orden</th>
                    <th>Denominacion</th>
                    <th>Codigo</th>
                    <th>Monto</th>
                    <th>% costo</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $totalinc = 0;
                    @endphp
                    @foreach ($itemsViv as $item)
                        <tr>
                            <td>{{$item->orden}}</td>
                            <td>{{$item->nom_item}}</td>
                            <td>{{$item->iditem}}</td>

                            
                            <td>$ {{number_format($item->infra,2, ',', '.')}}</td>
                            @php
                                $total += $item->infra;
                            @endphp
                            
                            <td>{{number_format($item->por_inc,4, ',', '.')}}</td> 
                            @php
                                $totalinc += $item->por_inc;
                            @endphp
                            {{-- <td>${{number_format($data->tot1viv,2, ',', '.')}}</td>
                            <td>${{number_format($data->tot1inf,2, ',', '.')}}</td> --}}
                        </tr>
                    @endforeach
                    <tr style="background-color: rgb(190, 190, 190)">
                        <td></td>
                        <td></td>
                        <td>Sub total 1:</td>
                        <td>
                            ${{number_format($total,2, ',', '.')}}
                        </td>
                        <td>
                            {{number_format($totalinc,4, ',', '.')}}
                        </td>
                    </tr>      
                </tbody>
            </table>
        </div>
    </section>
    
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto">TOTALES CON SOMBRERO</h4>
        </div>
        <div class="section-body">
            @php
                $contador = 2;
                $subtotal = $total;
            @endphp
            @foreach ($conceptos as $concepto)
            @if ($concepto->idconceptosombrero < 40)
                <table class="table" style="margin-top: 30px">
                    <thead>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Monto</th>
                        <th>SubTotal {{$contador}}</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$concepto->conceptosombrero}}</td>
                            <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                            <td>$ {{number_format((($subtotal*$concepto->valor)/100),2, ',', '.')}}</td>
                            <td>$ {{number_format(((($subtotal*$concepto->valor)/100)+$subtotal),2, ',', '.')}}</td>
                        </tr>
                        <tr style="background-color: rgb(190, 190, 190)">
                        </tr>
                    </tbody>
                </table>
                @php
                    $contador += 1;
                    $subtotal += $subtotal*($concepto->valor/100);
                @endphp
            @elseif($concepto->idconceptosombrero == 40)
                <table class="table" style="margin-top: 30px">
                    <thead>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Monto</th>
                        <th>SubTotal {{$contador}}</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$concepto->conceptosombrero}}</td>
                            <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                            <td>$ {{number_format((($subtotal*$concepto->valor)/100),2, ',', '.')}}</td>
                            <td>$ {{number_format(((($subtotal*$concepto->valor)/100)+$subtotal),2, ',', '.')}}</td>
                        </tr>
                        <tr style="background-color: rgb(190, 190, 190)">
                        </tr>
                    </tbody>
                </table>
                @php
                    $contador += 1;
                    $subtotal += $subtotal*($concepto->valor/100);
                    $totalViv = $subtotal;
                @endphp
            @endif
        @endforeach
                <table class="table" style="margin-top: 30px">
                    <tbody>
                        <tr>
                            <th>MONTO TOTAL</th>
                            <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                        </tr>
                    </tbody>
                </table>
        </div>
    </section>
    @endif
    {{-- <section style="margin-top: 10px">
        <div class="section-body">
            <table class="table" style="margin-top: 30px">
                <tbody>
                    <tr>
                        <th>MONTO INFRAESTRUCTURA</th>
                        <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                    </tr>
                </tbody>
            </table>
        
            <table class="table" style="margin-top: 30px">
                <tbody>
                    <tr>
                        <th>MONTO VIVIENDA</th>
                        <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                    </tr>
                </tbody>
            </table>
        
            <table class="table" style="margin-top: 30px">
                <tbody>
                    <tr>
                        <th>MONTO NEXO</th>
                        <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                    </tr>
                </tbody>
            </table>

            <table class="table" style="margin-top: 30px">
                <tbody>
                    <tr>
                        <th>MONTO TOTAL</th>
                        <th><strong>$ {{number_format($subtotal, 2, ',', '.')}}</strong></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>   --}}
    
</body>
</html>