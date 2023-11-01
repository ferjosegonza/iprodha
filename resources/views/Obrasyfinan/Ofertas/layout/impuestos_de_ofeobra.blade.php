<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-head">
                <br>
                <div class="text-center"><h5>Impuestos</h5></div>                        
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
</div>