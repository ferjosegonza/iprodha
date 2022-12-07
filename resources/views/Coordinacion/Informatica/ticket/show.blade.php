@extends('layouts.app')

@section('content')
<style>
    .desvanecer:hover {
        opacity: 0.3;
        -webkit-transition: opacity 500ms;
        -moz-transition: opacity 500ms;
        -o-transition: opacity 500ms;
        -ms-transition: opacity 500ms;
        transition: opacity 500ms;
    }

    .mostrar{
        opacity: 0.1;
    }
    .mostrar:hover {
        opacity: 0.6;
        -webkit-transition: opacity 500ms;
        -moz-transition: opacity 500ms;
        -o-transition: opacity 500ms;
        -ms-transition: opacity 500ms;
        transition: opacity 500ms;
    }

</style>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Ver Ticket #{{$Ticket->idtarea}} </h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    {{-- @include('layouts.modal.ticket', ['modo' => 'Agregar']) --}}
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('categoria', $Ticket->getCategoriaProb->getCatProblema->descatprob, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Sub-Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('subcateg', $Ticket->getCategoriaProb->catprobsub, array('class' => 'form-control','disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('N° de interno:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::number('interno', $Ticket->interno, array('class' => 'form-control', 'type' => 'number', 'disabled')) !!}
                                </div>
                                @can('ATENDER-TICKET')
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Usuario:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('interno', $Ticket->usuario, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('IP:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('interno', $Ticket->iporigentarea, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                @endcan
                                {{-- <div class="form-group d-flex align-items-center">
                                    {!! Form::label('IP:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('interno', $Ticket->iporigentarea, array('class' => 'form-control', 'disabled')) !!}
                                </div> --}}
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Solucionador:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('solu', $Ticket->getSolucionador->nombre, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Estado:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('estado', $Ticket->getEstadoTarea->last()->getEstado->denestado, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripcion del requerimiento:</label>
                                    {!! Form::textarea('descrip', $Ticket->descripciontarea, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'disabled']) !!}
                                </div>
                                @if (!is_null($Image))
                                <div class="form-group">
                                    <label for="">Imagen: </label>
                                    <div class="div-padre mt-2" style="height: 350px; position: relative; background-color: #fff">
                                            <div class="hijo2" style="height: 350px; width:100%;position: absolute;">
                                                <img id="imagenpre" src={{asset($Image->ruta)}} style="height: inherit; width: 100%;">
                                            </div>
                                            <a id='imageurl' href={{asset($Image->ruta)}} target='_blank' style="text-decoration: none; color: #9c9b98">
                                                <div class="hijo1 d-flex mostrar" style="height: 350px; width:100%;; position: absolute;">
                                                    <i class="fas fa-search-plus m-auto" style="font-size: 8em"></i>
                                                </div>
                                            </a>
                                    </div>
                                </div>
                                @endif
                                
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 ">
                                @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 4)
                                <div class="sticky-top" style="padding-top: 5px">
                                    <div class="form-group">
                                        <label for="">Observaciones del solucionador:</label>
                                        {!! Form::textarea('observ', $Ticket->getEstadoTarea->sortByDesc('idestado')->first()->observacion, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh','disabled']) !!}
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <h2>¿Fue el Ticket completado exitosamente?</h2>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        {!! Form::open([
                                            'method' => 'GET',
                                            'route' => ['ticket.validar', $Ticket->idtarea],
                                            'style' => 'display:inline',
                                            'class' => 'validar'
                                        ]) !!}
                                        {!! Form::submit('SI', ['class' => 'btn btn-success mx-3', 'style' => 'width: 100px;']) !!}
                                        {!! Form::close() !!} 

                                        {!! Form::open([
                                            'method' => 'GET',
                                            'route' => ['ticket.reasignar', $Ticket->idtarea],
                                            'style' => 'display:inline',
                                            'class' => 're-asignar'
                                        ]) !!}
                                        {!! Form::submit('NO', ['class' => 'btn btn-danger mx-3', 'style' => 'width: 100px;']) !!}
                                        {!! Form::close() !!} 
                                    </div>
                            </div>
                                @endif
                            </div>        
                        </div>
                        <a href="javascript:history.back()" class="btn btn-dark fo">Volver</a>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/index_verticket.js') }}"></script>
</section>
@include('layouts.modal.ticket', ['modo' => 'Agregar'])
@endsection