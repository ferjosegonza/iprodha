@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header" >
            {{-- <h3 class="titulo">Cronograma para Obra n°: {{decrypt($id)}}</h3> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <h3 class="titulo my-auto">Cronograma para Obra n°: {{base64url_decode($id)}}</h3>    
            </div>
            <div class="col-lg-5 my-auto">
            </div>
            <div class="col-lg-2 my-auto">
                {{-- <a href="{{ route('ofecrono.porc', base64url_decode($id)) }}" class="btn btn-primary my-1" Style="width: 80%">Cronograma %</a> --}}
            </div> 
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="">
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
                                    <input class="form-control" placeholder="0.0000" type="text" name="avance" id='avance' pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="avance">
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
                </div>
    
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
    let obra = {{ base64url_decode($id) }};
</script>
<script src="{{ asset('js/Obrasyfinan/Ofertas/index_crono.js') }}"></script>
    
@endsection