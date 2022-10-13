
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-4 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-BARRIO')
                                                {!! Form::open(['method' => 'GET', 'name'=>$nameFiltro ,'route' => $ruta , 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => $ruta,
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-8 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                       
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            {!! Form::open(['method' => 'GET', 'class' => 'd-flex justify-content-evenly', 'route' => [$informepdf]]) !!}
                                            {!! Form::submit('Imprimir', ['class' => 'btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>