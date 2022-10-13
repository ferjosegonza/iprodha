
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-4 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class=" d-flex ">
                                                {!! Form::model('Fc_concosxbarrio', array('route' => array($ruta)))  !!}
                                                    {!! Form::label('Plazo:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                                                    {!! Form::select('filtro',$valores, $valores
                                                        , ['placeholder' => 'Seleccionar', 'class' => 'form-select']
                                                        , 'onclick'=>'hasNoDiploma();'
                                                        ) !!}
                                                
                                                {!! Form::close() !!}

                                                
                                                

                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => $ruta,
                                            ]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>