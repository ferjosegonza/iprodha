<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Obra PDF</title>
</head>
<body style="margin-left: 3cm">
    <header style="margin-left: 3cm;">
        <img class= "logo column-3" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}">
        <label class="txt column-3">{{$texto[0]->texto_1}}</label>
    </header>
    <footer style="margin-left: 3cm"></footer>   
    <section>
        <div class="section-header">
            <h2>Ítems</h2>
        </div>
        <div class="section-body">            
            @foreach ($vw as $item) 
            <table class="table subtitulo">
                <th>ITEM</th>
            </table>
                <table class="table">                    
                    <thead>
                        <th>Orden</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Monto Total</th>
                    </thead>
                    <tbody>
                        <tr>                             
                            <td>{{$item->orden}}</td>
                            <td>{{$item->nom_item}}</td>
                            <td>{{$item->nom_tipo}}</td>
                            @if (strcmp($item->nom_tipo, "VIVIENDA")==0)
                                <td class= 'text-center'>${{number_format($item->vivienda,2, ',', '.')}}</td>
                            @else
                                @if (strcmp($item->nom_tipo, "INFRAESTRUCTURA")==0)
                                    <td class= 'text-center'>${{number_format($item->infra,2, ',', '.')}}</td>
                                @else
                                    <td class= 'text-center'>${{number_format($item->vivienda + $item->infra,2, ',', '.')}}</td>
                                @endif            
                            @endif
                        </tr>
                    </tbody>                  
                 </table>
                 <table class="table subtitulo">
                    <th>SUBITEMS</th>
                </table>
                <table class="subtable">
                    <thead>                                
                        <tr>
                            <th>Denominacion</th>
                            <th>Costo Unitario</th>
                            <th>Cantidad</th>
                            <th>Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                       @foreach ($item->getSubItems as $subitem)
                            <tr>
                                <td>{{$subitem->denominacion}}</td>
                                <td>${{number_format($subitem->costounitario,2, ',', '.')}}</td>
                                <td>{{$subitem->cantidad}}</td>        
                                <td>${{number_format($subitem->cantidad * $subitem->costounitario,2, ',', '.')}}</td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach                  
        </div>
    </section>    
    <section class="page_break">
        <div class="section-header"><h2>Cronograma</h2></div>
        <div class="section-body">
            @php
                $contador = 1;
                $contadorMes = $cronograma->last()->mes;
                $cont = 0;
            @endphp
            
           @while ($contador <= $contadorMes)
                @if($contador % 12 == 1)
                    <table class="table">
                    <thead>
                        <th class="ord">Orden</th>
                        <th class="nom">Denom. Ítem</th>
                        @php $cont=0; @endphp
                        @while($contador <= $contadorMes)
                            <th class="crono">Mes {{$contador}}</th>
                                    @php
                                        $contador = $contador+1;
                                        $cont=$cont+1;
                                    @endphp    
                            @if($contador % 12 == 1)
                                @break;    
                            @endif           
                        @endwhile
                    </thead>
                    <tbody>
                        @php 
                            $contadorBody = $contador - $cont;
                        @endphp
                        @foreach ($vw as $item)
                            <tr class="row-crono">
                                @php $cont = 0  @endphp
                                <td class="ord">{{$item->orden}}</td>
                                <td class="nom">{{$item->nom_item}}</td>
                                @while ($contadorBody < $contador)
                                    @if (is_null($cronograma->where('iditem', $item->iditem)->where('mes', $contadorBody)->first()))
                                        <td class="crono">-</td>
                                    @else
                                        <td class="crono">{{number_format($cronograma->where('iditem', $item->iditem)->where('mes', $contadorBody)->first()->avance,2, ',', '.')}}%   </td>
                                    @endif
                                    @php
                                        $contadorBody = $contadorBody+1;
                                        $cont = $cont+1;
                                    @endphp
                                @endwhile                                
                                @php
                                    $contadorBody = $contadorBody-$cont;
                                @endphp                                
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">TOTAL POR MES:</td> 
                        @php
                            $total=0;
                            $i = $contador-$cont;
                        @endphp
                        @while ($i< $contador)
                            @foreach ($vw as $item)
                                @if (!is_null($cronograma->where('iditem', $item->iditem)->where('mes', $i)->first()))                            
                                    @php
                                        $total +=$cronograma->where('iditem', $item->iditem)->where('mes', $i)->first()->avance
                                    @endphp
                                @endif
                            @endforeach                        
                            <td class="crono">{{number_format($total,2, ',', '.')}}%</td>
                            @php
                                $total=0;
                                $i++;                                
                            @endphp
                        @endwhile
                        </tr>
                    </tbody>
                </table>                  
                @endif
            @endwhile              
        </div>
    </section>
</body>
</html>