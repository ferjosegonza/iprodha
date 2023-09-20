<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CUADRO A y B - GENERAL</title>
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
            <h4 style="">INSTITUTO PROVINCIAL DE DESARROLLO HABITACIONAL</h4> 
            <h4 style="text-align: center;">CUADRO A y B - GENERAL</h4>            
        </div>
        <div class="section-body">
            <div class="section-border" style="font-size:90%">      
                <div class="row">         
                    <div class="form-group">
                        <label><b>Obra: <b></label> 
                        <label>{{$obra->nomobra}}</label>
                    </div>             
                </div>
                <div class="row">
                    <div class="column-2 form-group">
                        <label><b>Empresa:<b></label>
                        <label>{{$obra->getEmpresa->nom_emp}}</label>
                    </div>
                    <div class="column-2 form-group">
                        <label><b>Localidad: <b></label>
                        <label>{{$obra->getLocalidad->nom_loc}}</label>                    
                    </div>   
                </div>
                <div class="row">                          
                    <div class="column-2 form-group">                        
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{\Carbon\Carbon::parse($obra->publica)->format('d-m-Y')}}</label>
                    </div>
                    <div class="column-2 form-group"> 
                        <label><b>Expediente Número:<b></label>
                        <label>{{$obra->getExpediente->exp_numero ?? '-'}}</label>
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

    <section style="margin-top: 10px">
        <div class="section-body">
            <table class="table" style="margin-top: 10px; font-size:80%">
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

                        $totalInfra = 0;
                        $totalViv = 0;
                        $totalNex = 0;
                    @endphp
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->orden}}</td>
                            <td>{{$item->nom_item}}</td>
                            <td>{{$item->iditem}}</td>

                            @if ($item->cod_tipo == 1)
                                <td>$ {{number_format($item->vivienda,2, ',', '.')}}</td>
                                @php
                                    $total += $item->vivienda;
                                @endphp
                            @else
                                <td>$ {{number_format($item->infra,2, ',', '.')}}</td>
                                @php
                                    $total += $item->infra;
                                @endphp
                            @endif
                            
                            
                            
                            <td>{{number_format($item->por_inc,4, ',', '.')}}</td> 
                            @php
                                $totalinc += $item->por_inc;

                                switch ($item->cod_tipo) {
                                    case 1:
                                        $totalViv += $item->vivienda;
                                        break;
                                    case 2:
                                        $totalInfra += $item->infra;
                                        break;
                                    case 3:
                                        $totalNex += $item->infra;
                                        break;
                                }
                            @endphp
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
        <div class="section-body">
            @php
                $contador = 2;
                $subtotal = $totalViv + $totalInfra + $totalNex;
                $totalFinal = 0;
            @endphp

            @foreach ($obra->getSombrero as $concepto)
                @if ($concepto->idconceptosombrero < 40)
                    <table class="table" style="margin-top: 10px; table-layout:fixed; font-size:80%">
                        <thead>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Monto</th>
                            <th>Sub Total {{$contador}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$concepto->getConceptoSombrero->conceptosombrero}}</td>
                                <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                                <td>$ {{number_format((($subtotal*$concepto->valor)/100),2, ',', '.')}}</td>
                                <td>$ {{number_format(((($subtotal*$concepto->valor)/100)+$subtotal),2, ',', '.')}}</td>
                            </tr>
                            <tr style="background-color: rgb(190, 190, 190)">
                            </tr>
                        </tbody>
                    </table>
                    @php
                        $contador = $contador + 1;
                        

                        $totalInfra += $totalInfra*($concepto->valor/100);
                        $totalViv += $totalViv*($concepto->valor/100);
                        $totalNex += $totalNex*($concepto->valor/100);
                        
                        $subtotal += $subtotal*($concepto->valor/100);
                    @endphp
                @elseif($concepto->idconceptosombrero == 40)
                {{-- {{$totalViv}} --}}
                    <table class="table" style="margin-top: 10px; table-layout:fixed; font-size:80%">
                        <thead>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Monto</th>
                            <th>SubTotal {{$contador}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$concepto->getConceptoSombrero->conceptosombrero}} e Ingresos Brutos</td>
                                <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                                <td>$ {{number_format($totalViv*($concepto->valor/100),2, ',', '.')}}</td>
                                @php
                                    $totalViv += $totalViv*($concepto->valor/100);
                                @endphp
                                <td>$ {{number_format($totalViv,2, ',', '.')}}</td>
                            </tr>
                            <tr style="background-color: rgb(190, 190, 190)">
                            </tr>
                        </tbody>
                    </table>
                @else
                    @php
                        if(!$tieneNex){
                            $totalNex = 0;
                        }
                        $totalInfra += $totalNex;
                    @endphp
                    <table class="table" style="margin-top: 10px; table-layout:fixed; font-size:80%">
                        <thead>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Monto</th>
                            <th>SubTotal {{$contador}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$concepto->getConceptoSombrero->conceptosombrero}} e Ingresos Brutos</td>
                                <td>% {{number_format($concepto->valor,2, ',', '.')}}</td>
                                <td>$ {{number_format((($totalInfra*$concepto->valor)/100),2, ',', '.')}}</td>
                                @php
                                    $totalInfra += $totalInfra*($concepto->valor/100);
                                @endphp
                                <td>$ {{number_format($totalInfra,2, ',', '.')}}</td>
                            </tr>
                            <tr style="background-color: rgb(190, 190, 190)">
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endforeach
        </div>
    </section>
    
    @php
        if(!$tieneInfra){
            $totalInfra = 0;
        }

        if(!$tieneViv){
            $totalViv = 0;
        }

        $totalFinal = $totalInfra + $totalViv;
    @endphp

    <table class="table" style="margin-top: 30px">
        <tbody>
            <tr>
                <th>MONTO TOTAL</th>
                <th><strong>$ {{number_format($totalFinal, 2, ',', '.')}}</strong></th>
            </tr>
        </tbody>
    </table>
    
</body>
</html>