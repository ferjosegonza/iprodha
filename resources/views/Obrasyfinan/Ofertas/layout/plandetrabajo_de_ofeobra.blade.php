<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-head">
            <br>
            <div class="text-center"><h5>Plan de trabajo</h5></div>                        
        </div>
        <div class="card-body">
            @php
                $contador = 1;
                $contadorMes = $cronograma->last()->mes ?? 0;
            @endphp
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
