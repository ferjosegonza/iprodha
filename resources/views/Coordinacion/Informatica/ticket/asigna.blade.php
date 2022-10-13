@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Asignadores</h3>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{route('ticket.asigna')}}">
                            <div class="row g-3 my-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        {{-- <form method="GET" action="{{route('ticket.atencion')}}"> --}}
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2" name="name">
                                                <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        {{-- </form> --}}
                                    </div>
                                </div>

                                <div class="col-lg-3 my-auto">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios0" value="0" checked>
                                                <label class="form-check-label" for="exampleRadios0">
                                                  Todo
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios1" value="1">
                                                <label class="form-check-label" for="exampleRadios1">
                                                  En espera
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios2" value="2">
                                                <label class="form-check-label" for="exampleRadios2">
                                                  Asignado
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios3" value="3">
                                                <label class="form-check-label" for="exampleRadios3">
                                                  En proceso
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios4" value="4">
                                                <label class="form-check-label" for="exampleRadios4">
                                                  Completado
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios5" value="5">
                                                <label class="form-check-label" for="exampleRadios5">
                                                  Validado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios6" value="6">
                                                <label class="form-check-label" for="exampleRadios6">
                                                  Cancelado
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="exampleRadios7" value="7">
                                                <label class="form-check-label" for="exampleRadios7">
                                                  Re asignado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-select" name="categ" placeholder="Seleccionar" id='selected-categoria' required>
                                        <option disabled selected>Categoria</option>
                                        @foreach ($Categorias as $Categoria)
                                            <option value={{"$Categoria->idcatprob"}}>{{$Categoria->descatprob}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}   
                            </div>
                            <div class="table-responsive text-center">
                                <table class="table table-striped mt-2">
                                    <thead style="height:50px;">
                                        <th class='ml-3' style="color:#fff;">ID</th>
                                        <th class='ml-3' style="color:#fff;">Categoria</th>
                                        <th class='ml-3' style="color:#fff;">Usuario</th>
                                        <th style="color:#fff;">Estado</th>
                                        <th style="color: #fff">Última Actualización</th>
                                        <th style="color:#fff;">Solucionador</th>
                                        <th colspan="3" style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Tickets as $Ticket)
                                            <tr>
                                                <td>{{$Ticket->idtarea}}</td>
                                                <td>{{$Ticket->getCategoriaProb->getCatProblema->descatprob}}</td>
                                                <td>{{$Ticket->usuario}}</td>
                                                @switch($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado)
                                                    @case(1)
                                                        <td>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="fas fa-hourglass-start"></i></td>
                                                        @break
                                                    @case(2)
                                                        <td>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="fas fa-user-clock"></i></td>
                                                        @break
                                                    @case(3)
                                                        <td>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="fas fa-user-cog"></i></td>
                                                        @break
                                                    @case(4)
                                                        <td style='color: #55a852'>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="far fa-check-circle"></i></td>
                                                        @break
                                                    @case(5)
                                                        <td style='color: #55a852'>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="far fa-check-circle"></i><i class="far fa-check-circle"></i></td>
                                                        @break
                                                    @case(6)
                                                        <td style='color: #fc685d'>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="far fa-times-circle"></i></td>
                                                        @break
                                                    @case(7)
                                                        <td>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}} <i class="fas fa-arrow-up"></i></td>
                                                        @break
                                                    @default
                                                        <td>{{$Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->denestado}}</td>
                                                @endswitch
                                                <td>{{Carbon\Carbon::parse($Ticket->getEstadoTarea->last()->fecha)->format('d-m-Y')}}</td>
                                                <td>{{$Ticket->getSolucionador->nombre}}</td>
                                                
                                                <td>
                                                    @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 1)
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'route' => ['ticket.asignar', $Ticket->idtarea],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Asignar', ['class' => 'btn btn-primary']) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado <= 2)
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'route' => ['ticket.cambiar', $Ticket->idtarea],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-success']) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>   
                                                <td>        
                                                    {!! Form::open([
                                                        'method' => 'GET',
                                                        'route' => ['ticket.show', $Ticket->idtarea],
                                                        'style' => 'display:inline',
                                                    ]) !!}
                                                    {!! Form::submit('Ver', ['class' => 'btn btn-warning']) !!}
                                                    {!! Form::close() !!}  
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- <script src="{{ asset('js/tarea/index_tarea.js') }}"></script> --}}

    
@endsection