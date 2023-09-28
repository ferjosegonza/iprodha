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
                    {!! Form::text($data->idobra, null, ['style' => 'disabled;' ]) !!}
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <div class="form-group">
                            {!! Form::label('Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('nombobra', $data->nomobra, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('Localidad:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('nom_loc', $data->nom_loc, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Empresa:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('nom_emp', $data->nom_emp, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('Tipo Contrato:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('tipocontrato', $obra->getTipoOferta->tipocontratofer, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('Situacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {{-- <span class="obligatorio">*</span> --}}
                            {!! Form::text('situacion', $obra->getSituacion->descripcion, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!} 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('Fecha Publicación:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('publicacion', $obra->publica, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>                                
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="form-group">
                            {!! Form::label('Operatoria:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('ope', $obra->getOperatoria->operatoria, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!} 
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('Tipo de Oferta:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('tipofe', $obra->getTipoOfeObra->tipo_obra ?? null, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <div class="form-group">
                            {!! Form::label('Tipo de Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                            {!! Form::text('tipobr', $obra->getTipoObra->nom_tipo_obra ?? null, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('Numero de Licitacion:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('tipoobr', $obra->num_lic ?? null, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}  
                        </div>
                    </div>
                </div>

                <div class="row">
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
                </div>
                <div class="row">
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
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                            {!! Form::label('Total de obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('totaldobra',"$0.00", ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true', 'id' => 'totalobr']) !!}         
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                        <div class="form-group">
                            {!! Form::label('Plazo:', null, ['class' => 'control-label',  'style' => 'white-space: nowrap;']) !!}
                            {!! Form::text('plazo',$obra->plazo, ['style' => 'disabled;', 'class' => 'form-control', 'readonly'=> 'true']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
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
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>