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
        <h3 class="page__heading">Editar Categoria del Ticket #{{$Ticket->idtarea}}</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         
                        {!! Form::model($Ticket, ['method' => 'PATCH','route' => ['ticket.cambiarcat', $Ticket->idtarea], 'enctype'=>'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    <select class="form-select" name="categoria" placeholder="Seleccionar" id='selected-categoria' required>
                                        <option disabled selected>Seleccionar</option>
                                        @foreach ($Categorias as $Categoria)
                                            @if($Ticket->getCategoriaProb->getCatProblema->idcatprob == $Categoria->idcatprob)
                                                <option value={{"$Categoria->idcatprob"}} selected>{{$Categoria->descatprob}}</option>
                                            @else
                                                <option value={{"$Categoria->idcatprob"}}>{{$Categoria->descatprob}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Sub-Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    <select class="form-select" name="subcateg" placeholder="Seleccionar" id='selected-subcategoria' required>
                                        @foreach ($Subcategorias as $Subcategoria)
                                                @if($Ticket->getCategoriaProb->getCatProblema->idcatprob == $Subcategoria->idcatprob)
                                                    @if($Ticket->getCategoriaProb->idcatprobsub == $Subcategoria->idcatprobsub)
                                                        <option value={{"$Subcategoria->idcatprobsub"}} selected>{{$Subcategoria->catprobsub}}</option>
                                                    @else
                                                        <option value={{"$Subcategoria->idcatprobsub"}}>{{$Subcategoria->catprobsub}}</option>
                                                    @endif  
                                                @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('N° de interno:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::number('interno', $Ticket->interno, array('class' => 'form-control', 'type' => 'number', 'required', 'disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Usuario:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('interno', $Ticket->usuario, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('IP:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('interno', $Ticket->iporigentarea, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Estado:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('estado', $Ticket->getEstadoTarea->last()->getEstado->denestado, array('class' => 'form-control', 'disabled')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripcion del requerimiento:</label>
                                    {!! Form::textarea('descrip', $Ticket->descripciontarea, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh', 'disabled']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen: </label>
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
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 ">
                                <div class="sticky-top" style="padding-top: 5px">
                                        <div class="form-group d-flex align-items-center">
                                            {!! Form::label('Solucionador:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                            {!! Form::select('solu', $Solucionadores, $Ticket->getSolucionador->idsolucionador,['class'=>'form-select', 'id'=>'selected-solucionador']) !!}
                                            <a class="align-items-center p-auto" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fas fa-info-circle fs-3"></i>
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Observaciones:</label>
                                            {!! Form::textarea('observ', $Ticket->getEstadoTarea->last()->observacion, ['class'=>'form-control', 'rows' => 54, 'cols' => 54, 'style' => 'resize:none; height: 40vh']) !!}
                                        </div>
                                        <div class="form-group d-flex justify-content-end">                                      
                                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                                            <a href="{{ route('ticket.index') }}"class="btn btn-secondary fo">Volver</a>
                                        </div>
                                </div>
                            </div>       
                        </div>
                        {{-- <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('ticket.index') }}"class="btn btn-secondary fo">Volver</a> --}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/asignar_ticket.js') }}"></script>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Estado de Solucionadores</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-striped mt-2">
                <thead style="height:50px;">
                    <th class='ml-3' style="color:#fff;">Solucionador</th>
                    <th class='ml-3' style="color:#fff;">En Proceso</th>
                    <th class='ml-3' style="color:#fff;">Asignado</th>
                    <th style="color:#fff;">Total</th>
                </thead>
                <tbody id="tabla-datos">
                   
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection