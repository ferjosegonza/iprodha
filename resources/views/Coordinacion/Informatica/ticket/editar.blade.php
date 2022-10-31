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
        <h3 class="page__heading">Editar Ticket</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         
                        {!! Form::model($Ticket, ['method' => 'PATCH','route' => ['ticket.editar', $Ticket->idtarea], 'enctype'=>'multipart/form-data']) !!}
                        {{-- {!! Form::open(array('route' => 'ticket.editar','method'=>'POST', 'enctype'=>'multipart/form-data')) !!} --}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
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
                                    {!! Form::number('interno', $Ticket->interno, array('class' => 'form-control', 'type' => 'number', 'required')) !!}
                                </div>
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
                                    {!! Form::textarea('descrip', $Ticket->descripciontarea, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen: </label>
                                    {!! Form::file('image', array('class' => 'form-control', 'type' => 'file', 'id' => "inputGroupFile03", 'aria-describedby' => 'inputGroupFileAddon03', 'aria-label' => 'Upload', 'accept' => 'image/*')) !!}

                                    <div class="div-padre mt-2" style="height: 350px; position: relative; background-color: #fff">
                                        @if (!is_null($Image))
                                            <div class="hijo2" style="height: 350px; width:100%;position: absolute;">
                                                <img id="imagenpre" src={{asset($Image->ruta)}} style="height: inherit; width: 100%;">
                                            </div>
                                            <a id='imageurl' href={{asset($Image->ruta)}} target='_blank' style="text-decoration: none; color: #9c9b98">
                                                <div class="hijo1 d-flex mostrar" style="height: 350px; width:100%;; position: absolute;">
                                                    <i class="fas fa-search-plus m-auto" style="font-size: 8em"></i>
                                                </div>
                                            </a>
                                        @else
                                            <div class="hijo2" style="height: 350px; width:100%;position: absolute;">
                                                <img id="imagenpre" style="height: inherit; width: 100%;">
                                            </div>
                                            <a id='imageurl' target='_blank' style="text-decoration: none; color: #9c9b98">
                                                <div class="hijo1 d-flex mostrar" style="height: 350px; width:100%;; position: absolute;">
                                                    <i class="fas fa-search-plus m-auto" style="font-size: 8em"></i>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>                             
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('ticket.index') }}"class="btn btn-secondary fo">Volver</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/editar_ticket.js') }}"></script>
</section>
@endsection