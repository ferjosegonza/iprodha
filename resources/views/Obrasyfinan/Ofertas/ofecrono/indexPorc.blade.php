@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header" >
            {{-- <h3 class="titulo">Cronograma para Obra n°: {{decrypt($id)}}</h3> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <h3 class="titulo my-auto">Cronograma para Obra n°: </h3>    
            </div>
            <div class="col-lg-5 my-auto">
            </div>
            <div class="col-lg-2 my-auto">
                {{-- <a href="{{ route('ofeobra.index') }}" class="btn btn-primary my-1" Style="width: 80%">Volver</a> --}}
            </div> 
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
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
                                        <th class= 'text-center' style="color:#fff; width:10%;">% Incidencia</th>
                                        <th class= 'text-center' style="color:#fff; width:10%;">% Acumulado</th>
                                        <th class= 'text-center' style="color:#fff; width:10%;">Estado</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalItems = number_format(floatval(0), 2);
                                            $totalInc = 0;
                                        @endphp
                                        @foreach ($losItems as $item)
                                            <tr>
                                                <td class= 'text-center'>{{$item->orden}}</td>                                            
                                                <td class= 'text-center'>{{$item->nom_item}}</td>                                            
                                                <td class= 'text-center'>{{number_format($item->por_inc, 4, ',','.')}}</td>
                                                <td class= 'text-center'>{{$item->avaitempor}} %</td>
                                                @if ($item->estado == 1)
                                                    <td class= 'text-center' style="color: green">Completo</td>
                                                @else
                                                    <td class= 'text-center' style="color: red">Incompleto</td>
                                                @endif
                                                
    
                                                {{-- @if ($item->cod_tipo == 1)
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
                                                @endphp --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{-- <tfoot align="right" style='background-color: #f3c48638;'>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">$ {{number_format($totalItems,2, ',', '.')}}</th>
                                            <th class="text-center">{{number_format($totalInc,4, ',', '.')}}</th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Mes:</label>
                                        <select class="form-select form-control" id="mes" aria-label="Example select with button addon">
                                            <option value="0" selected disabled>Seleccionar...</option>
                                            @for($i = 1; $i <= $plazo; $i++)
                                            <option value="{{$i}}">{{$i}}</option>>
                                            @endfor
                                        </select> 
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="formFile" class="form-label fs-6">Item: </label>
                                        {!! Form::select('item', $items, null,['class'=>'form-select form-control', 'id' => 'item']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="formFile" class="form-label fs-6">Avance: </label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="00" type="text" name="avance" id='avance' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="avance">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 my-auto">
                                    <div class="form-group my-auto">
                                        <input id="addRow" class="btn btn-success my-auto" style="width: 70%" type="submit" value="Agregar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Inc. item:</label>
                                        {!! Form::text('inc_item', 0, ['class' => 'form-control', 'readonly', 'id' => 'inc_i']) !!} 
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;">Inc. acu. item:</label>
                                        {!! Form::text('inc_item_acu', 0, ['class' => 'form-control', 'readonly', 'id' => 'acuu']) !!} 
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="Numero:" class="control-label fs-6" style="white-space: nowrap;width:20%;"> % Inc. acu. item:</label>
                                        {!! Form::text('inc_item_acu_por', 0, ['class' => 'form-control', 'readonly', 'id' => 'inc_i_p']) !!} 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                

                                <div class="col-xs-12 col-sm-8 col-md-1 col-lg-1 my-auto py-2">
                                    <label for="formFile" class="form-label fs-5"><b>Mes:</b></label>  
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-1 col-lg-1 py-2">
                                    <select class="form-select" id="mes" aria-label="Example select with button addon">
                                        <option value="0" selected disabled>Seleccionar...</option>
                                        @for($i = 1; $i <= $plazo; $i++)
                                        <option value="{{$i}}">{{$i}}</option>>
                                        @endfor
                                    </select> 
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1 my-auto py-2">
                                    <label for="formFile" class="form-label fs-5">Item: </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 py-2">
                                    {!! Form::select('item', $items, null,['class'=>'form-select', 'id' => 'item']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-1 col-lg-1 my-auto py-2">
                                    <label for="formFile" class="form-label fs-5">Avance: </label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 py-2">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="00" type="text" name="avance" id='avance' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="avance">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                    {{-- <input class="form-control" placeholder="0.0000" type="text" name="avance" id='avance' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="avance">
                                    
                                        <span class="input-group-text" id="basic-addon2">@example.com</span>
                                   
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 py-2">
                                    <label id='acu' for="formFile" class="form-label">%acu: 00.0000</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 py-2">
                                    <input id="addRow" class="btn btn-success my-auto" style="width: 70%" type="submit" value="Agregar">
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div> --}}
    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}   
                            </div> --}}
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        <th style="color:#fff;">Item</th>
                                        <th style="color:#fff;">Avance</th>
                                        <th style="color:#fff;">Av. Acu</th>
                                        {{-- <th style="color:#fff;">Av. Total</th> --}}
                                        <th style="color:#fff;">Incidencia</th>
                                        <th style="color:#fff;">Importe</th>
                                        <th style="color:#fff;">Costo</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tfoot align="right" style='background-color: #ff910033;'>
                                        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('ofeobra.index') }}" class="btn btn-primary my-1" Style="width: 20%">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    let obra = {{$id}};
</script>
<script src="{{ asset('js/Obrasyfinan/Ofertas/index_crono_porc.js') }}"></script>
    
@endsection