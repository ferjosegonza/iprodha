@extends('layouts.app')
@section('content')
<style>
    #viv table {
        max-width:980px;
        table-layout:fixed;
        margin:auto;
    }
    /* #viv th, #viv td {
        padding:5px 10px;
        border:1px solid #000;
    } */
    #viv thead, #viv tfoot {
        display:table;
        width:100%;
        width:calc(100% - 18px);
    }
    #viv tbody {
        height:300px;
        overflow:auto;
        overflow-x:hidden;
        display:block;
        width:100%;
    }
    #viv tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
</style>
<section class="section">
    <div class="section-header">
        <div class="titulo page__heading" style="padding:10px">
            Visualizar obra
        </div>       
    </div>    
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')
            <div class="row">                
                <div class="col-xs-12 col-sm-12 col-md-12"">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="text-center"><h5>Información de la Obra</h5></div>                        
                        </div>
                        <div class="card-body">
                            <div hidden>
                                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                {!! Form::text($obra->id_obr, null, ['style' => 'disabled;' ]) !!}
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                    <div class="form-group">
                                        {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->num_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nombobra', $obra->nom_obr, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_loc', $obra->getLocalidad->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('nom_emp', $obra->getEmpresa->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                        {!! Form::text('tipocontrato', $obra->getTipoOferta->tipocontratofer, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('publicacion', $obra->publica, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>                                 --}}
                            </div>
                            {{-- <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Cod. Barra del Exp.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('idexp',$obra->idexpediente, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <div class="form-group">
                                        {!! Form::label('Exp.Nro.:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        @if($obra->getExpediente != null)
                                            {!! Form::text('exp_numero', $obra->getExpediente->exp_numero, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        @else
                                            {!! Form::text('exp_numero',"-", ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <div class="form-group">
                                        {!! Form::label('Exp.Asunto:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}                   
                                        {!! Form::label('', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        @if($obra->getExpediente != null)
                                        {!! Form::textarea('exp_asunto',$obra->getExpediente->exp_asunto,['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 12vh']) !!}
                                        @else
                                        {!! Form::text('exp_asunto',"No hay expediente", ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Vivienda:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monviv',"$".number_format($obra->monviv,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Infraestructura:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('moninf',"$".number_format($obra->moninf,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Nexo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('monnex',"$".number_format($obra->monnex,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        {!! Form::label('Monto Tope:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                        {!! Form::text('montotope',"$".number_format($obra->montotope,2, ',', '.'), ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}   
                                            
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="d-flex">
                                    <div class="me-auto p-2"></div>
                                    <div class="p-2">
                                        <div class="form-group">
                                            {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                                            {!! Form::text('plazo',$obra->plazo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <div class="form-group">
                                            {!! Form::label('Año y Mes de Cotización:', null, [
                                                'class' => 'control-label',
                                                'style' => 'white-space: nowrap;'
                                            ]) !!}
                                            @if ($obra->mescotizacion !=null and $obra->aniocotizacion !=null)
                                            
                                            {!! Form::month('anioymes', $obra->aniocotizacion. '-' .$obra->mescotizacion, [
                                                'class' => 'form-control',
                                                'readonly'=> 'true'
                                            ]) !!}                                       
                                            @else
                                            {!! Form::text('cotizacion', 'No se ha definido una fecha' , ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true' ]) !!}
                                            @endif
                                            {{-- <input min="2022-01-01" max="{{\Carbon\Carbon::now()->year . '-12'}}" id="periodo" class="form-control" name="anioymes" type="month" value="{{$unaOferta->aniocotizacion. '-' .$unaOferta->mescotizacion}}"> 
                                            
                                        </div>
                                    </div>
                                </div>                     
                            </div> --}}
                            
                        </div>
                    </div>
                </div>
            
            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Etapa</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                <div class="form-group">
                                    {!! Form::label('Numero:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->getEtapas->first()->nro_eta, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <div class="form-group">
                                    {!! Form::label('Descripcion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->getEtapas->first()->descripcion, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nom_loc', $obra->getEtapas->first()->getLocalidad->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            {!! Form::label('Cantidad de Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                <div class="form-group">
                                    {!! Form::label('2 (DOS):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->getEtapas->first()->can_viv_2, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                <div class="form-group">
                                    {!! Form::label('3 (TRES):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->getEtapas->first()->can_viv_3, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                <div class="form-group">
                                    {!! Form::label('4 (CUATRO):', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('nombobra', $obra->getEtapas->first()->can_viv_4, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        --}}
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Etapas</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="items" class="table table-hover mt-2" class="display">
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff; background-color: #f4f6f9" colspan="2"></th>
                                    <th class="text-center" scope="col" style="color:#fff; height: 20px" colspan="3">Dormitorios</th>                                       
                                </thead>
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Etapa</th>                                    
                                    <th class="text-center" scope="col" style="color:#fff;width:55%;">Descripcion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">2</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">3</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">4</th>
                                </thead>
                                <tbody>
                                    @foreach ($obra->getEtapas as $etapa)
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nro_eta}}</td>                                            
                                            <td class= 'text-center align-middle'>{{$etapa->descripcion}}</td>                                            
                                            <td class= 'text-center'>{{$etapa->can_viv_2}}</td>
                                            <td class= 'text-center'>{{$etapa->can_viv_3}}</td>
                                            <td class= 'text-center'>{{$etapa->can_viv_4}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Entregas</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="items" class="table table-hover mt-2" class="display">
                                <thead>
                                    <th class="text-center" scope="col" style="color:#fff;width:15%;">Entrega</th>                                    
                                    <th class="text-center" scope="col" style="color:#fff;width:55%;">Descripcion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:20%;">Fecha</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Cant. Viviendas</th>
                                </thead>
                                <tbody>
                                    @foreach ($obra->getEtapas as $etapa)
                                        @foreach ($etapa->getEntregas as $entrega)
                                            <tr>
                                                <td class= 'text-center' style="vertical-align: middle;">{{$entrega->num_ent}}</td>                                            
                                                <td class= 'text-center align-middle'>{{$entrega->descripcion}}</td>
                                                @if (is_null($entrega->fec_ent))
                                                    <td class= 'text-center'>SIN FECHA</td>
                                                @else
                                                    <td class= 'text-center'>{{Carbon\Carbon::parse($entrega->fec_ent)->format('d-m-Y')}}</td>
                                                @endif                                           
                                                
                                                <td class= 'text-center'>{{$entrega->cant_viv}}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Viviendas</h5></div>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="viv" class="table table-hover mt-2" class="display">
                                <thead style="">
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Etapa</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:5%;">Entrega</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Seccion</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Chacra</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Manzana</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Parcela</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Finca</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Superficie</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:25%;">Deslinde</th>
                                    <th class="text-center" scope="col" style="color:#fff;width:10%;">Plano</th>
                                </thead>
                                <tbody>
                                    {{-- {{$obra->getEtapas->first()->getEntregas->last()->getViviendas}} --}}
                                    @foreach ($obra->getEtapas as $etapa)
                                        @foreach ($etapa->getEntregas as $entrega)
                                            @foreach ($entrega->getViviendas as $vivienda)
                                                <tr>                                          
                                                    <td class= 'text-center align-middle'>{{$vivienda->orden}}</td>
                                                    <td class= 'text-center align-middle'>{{$etapa->nro_eta}}</td>   
                                                    <td class= 'text-center align-middle'>{{$entrega->num_ent}}</td>                                           
                                                    <td class= 'text-center'>{{$vivienda->seccion}}</td>
                                                    <td class= 'text-center'>{{$vivienda->chacra}}</td>
                                                    <td class= 'text-center'>{{$vivienda->manzana}}</td>
                                                    <td class= 'text-center'>{{$vivienda->parcela}}</td>
                                                    <td class= 'text-center'>{{$vivienda->finca}}</td>
                                                    <td class= 'text-center'>{{$vivienda->sup_lot}}</td>
                                                    <td class= 'text-center'>{{$vivienda->deslinde}}</td>
                                                    <td class= 'text-center'>{{$vivienda->plano}}</td>
                                                    {{-- <td class= 'text-center' style="vertical-align: middle;">{{$vivienda->orden}}</td>   --}}
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    {{-- @foreach ($obra->getEtapas as $etapa)
                                    {{$etapa->getEntregas}}
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$etapa->nro_eta}}</td>                                            
                                            <td class= 'text-center align-middle'>{{$etapa->descripcion}}</td>                                            
                                            <td class= 'text-center'>{{$etapa->can_viv_2}}</td>
                                            <td class= 'text-center'>{{$etapa->can_viv_3}}</td>
                                            <td class= 'text-center'>{{$etapa->can_viv_4}}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.modal.confirmation') 
@endsection

@section('js')

@endsection
