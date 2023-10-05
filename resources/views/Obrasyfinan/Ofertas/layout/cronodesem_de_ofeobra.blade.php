<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-head">
            <div class="row mt-3">
                <div class="col-4">
                    <h5 class="ml-4">Anticipo: {{$obra->anticipo}} %  {{$obra->getAnticipo->nom_tipo_anticipo ?? null}}</h5>
                </div>
                <div class="col-4 text-center">
                    <h5>Cronograma de desembolso</h5>
                    
                </div>
                <div class="col-4">
                    <div class="float-end">
                        @can('VALIDAR-OFEOBRA')
                            {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.anticipo', $data->idobra], 'style' => '']) !!}
                            {!! Form::submit('Editar anticipo', ['class' => 'btn btn-success w-60 float-right mr-4']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </div>
                </div>           
            </div>
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