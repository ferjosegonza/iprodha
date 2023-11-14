<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-head">
            <br>
            <div class="text-center"><h5>Ítems</h5></div>                        
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
