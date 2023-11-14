@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Modificar valor del anticipo: {{$laObra->nomobra}}</div>
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::model($laObra, ['method' => 'POST', 'route' => ['ofeobra.modfanticipo', base64url_encode($laObra->idobra)]]) !!}
                            {{-- {!! Form::open(['route' => ['ofeobra.modfanticipo', $laObra->idobra], 'method' => 'POST']) !!} --}}

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Valor anticipo (Porcentaje):', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::text('anticipo', $laObra->anticipo, ['class' => 'form-control', 'data-type' => 'porc' ]) !!}
                                    </div>        
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Tipo anticipo:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        <span class="obligatorio">*</span>
                                        {!! Form::select('idtipoanticipo', $tipoAnticipo, $laObra->id_tipo_anticipo, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_tip_ant',
                                            'required'
                                        ]) !!}
                                    </div>        
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Descripcion anticipo:', null, ['class' => 'control-label fs-6', 'style' => 'white-space: nowrap; ']) !!}
                                        {{-- <span class="obligatorio">*</span> --}}
                                        {!! Form::text('descrip_ant', $laObra->getAnticipo->descripcion ?? '-', ['class' => 'form-control', 'data-type' => 'porc', 'readonly' => true, 'id' => 'descripcion_ant' ]) !!}
                                    </div>        
                                </div>
                            </div>
                            
                            <div class="row pt-3">
                                <div class="d-flex">
                                    <div class="me-auto my-auto">
                                        (<span class="obligatorio">*</span>) <strong><i>Obligatorio</i></strong>
                                    </div>
                                    <div class="p-1">
                                        @if ($laObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 3)
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.show', base64url_encode($laObra->idobra)], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Volver', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/Obrasyfinan/Ofertas/anticipo_oferta.js') }}"></script>
@endsection
