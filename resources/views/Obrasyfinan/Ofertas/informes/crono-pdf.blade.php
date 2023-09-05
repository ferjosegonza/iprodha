<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cronograma de avance PDF</title>
</head>
<body> {{-- style="margin-left: 3cm" --}} 
    <header> {{-- style="margin-left: 1cm" --}} 
        <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}">
        <label class="txt column-2"><br>{{$texto[0]->texto_1}}</label>
    </header>
    <footer> {{-- style="margin-left: 3cm" --}} 
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
                    <div class="column-3 form-group"> 
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
    
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto" >CRONOGRAMA DE AVANCE</h4>
        </div>
        <div class="section-body">
            <table class="table" style="table-layout:fixed; font-size:70%">
                <thead>
                    <th class="width: 1%">Orden</th>
                    <th class="width: 10%">Denominacion</th>
                    <th class="width: 5%">Monto</th>
                    <th class="width: 5%">Inc</th>
                    <th class="width: 1%">0</th>
                    @for ($i = 1; $i <= $obra->plazo; $i++)
                        <th class="width: 1%">{{$i}}</th>
                    @endfor
                    
                </thead>
                <tbody>
                    @php
                        $contador = 1;
                        $montoAcu = 0;
                        $totalInc = 0;
                        $totalMes = 0;
                        // $cronoMen = array();
                        for ($i=0; $i < $obra->plazo; $i++) { 
                            $cronoMen[] = 0;
                        }

                        for ($i=0; $i < $obra->plazo; $i++) { 
                            $acuMen[] = 0;
                        }

                        // for ($i=0; $i < $obra->plazo; $i++) { 
                        //     $acuMenMon[] = 0;
                        // }
                    @endphp
                    @foreach ($items as $item)
                        <tr>
                            @php
                                $montoAcu += $item->monto;
                            @endphp
                            <td class= 'text-center' style="vertical-align: middle;">{{$item->orden}}</td>
                            <td class= 'text-center' style="vertical-align: middle; font-size:80%">{{$item->nom_item}}</td>
                            <td class= 'text-center' style="vertical-align: middle;">$ {{number_format($item->monto, 2, ',','.')}}</td>
                            <td class= 'text-center' style="vertical-align: middle;">{{number_format($item->por_inc, 4, ',', '.')}}</td>
                            <td class= 'text-center' style="vertical-align: middle;"></td>
                            @while ($contador <= $obra->plazo)
                                @if (is_null($cronograma->where('iditem', $item->iditem)->where('mes', $contador)->first()))
                                    <td class= 'text-center' style="vertical-align: middle;"></td>
                                @else
                                    <td class= 'text-center' style="vertical-align: middle;">{{$cronograma->where('iditem', $item->iditem)->where('mes', $contador)->first()->avance}}</td>
                                    @php
                                        $cronoMen[$contador-1] += $cronograma->where('iditem', $item->iditem)->where('mes', $contador)->first()->avance;
                                        // array_push($cronoMen, $totalMes);
                                    @endphp
                                @endif

                                @php
                                    $contador = $contador+1;
                                @endphp
                            @endwhile
                            @php
                                $totalInc += $item->por_inc;
                                $contador = 1;
                            @endphp
                        </tr>
                    @endforeach
                        <tr style="background-color: rgb(141, 141, 141)">
                            <td style="color: rgb(141, 141, 141)">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @for ($i = 1; $i <= $obra->plazo; $i++)
                                <td></td>
                            @endfor
                        </tr>
                        @php
                            $ax = 0;
                            for ($i=0; $i < $obra->plazo; $i++) { 
                                $acuMen[$i] = $ax + $cronoMen[$i];
                                $ax += $cronoMen[$i];
                            }
                            $ax = 0;
                            foreach ($desembolsos as $unDesem) {
                                $acuMenMon[] = $ax + $unDesem->costo;
                                $ax += $unDesem->costo;
                            }
                        @endphp
                        <tr>
                            <td></td>
                            <td>Totales</td>
                            <td>$ {{number_format($montoAcu, 2, ',','.')}}</td>
                            <td>{{number_format($totalInc,4, ',', '.')}}</td>
                            <td></td>
                            @for ($i = 0; $i < $obra->plazo; $i++)
                                <td>{{$cronoMen[$i]}}</td>
                            @endfor
                            {{-- @foreach( $cronoMen as $unCrono)
                                <td>{{$unCrono}}</td>
                            @endforeach --}}
                        </tr>

                        <tr style="background-color: rgb(141, 141, 141)">
                            <td style="color: rgb(141, 141, 141)">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @for ($i = 1; $i <= $obra->plazo; $i++)
                                <td></td>
                            @endfor
                        </tr>

                        <tr>
                            <td></td>
                            <td>Inc. Acumulado</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @for ($i = 0; $i < $obra->plazo; $i++)
                                <td>{{$acuMen[$i]}}</td>
                            @endfor
                        </tr>

                        <tr style="background-color: rgb(141, 141, 141)">
                            <td style="color: rgb(141, 141, 141)">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @for ($i = 1; $i <= $obra->plazo; $i++)
                                <td></td>
                            @endfor
                        </tr>

                        <tr>
                            <td></td>
                            <td>Monto mensual</td>
                            <td></td>
                            <td></td>
                            @foreach ($desembolsos as $undesem)
                                <td>$ {{number_format($undesem->costo, 2, ',', '.')}}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td></td>
                            <td>Monto Acumulado</td>
                            <td></td>
                            <td></td>
                            @for ($i = 0; $i < $obra->plazo+1; $i++)
                                <td>$ {{number_format($acuMenMon[$i], 2, ',','.')}}</td>
                            @endfor
                        </tr>
                </tbody>
            </table>
        </div>
    </section> 
</body>
</html>