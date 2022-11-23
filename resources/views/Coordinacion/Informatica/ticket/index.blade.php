@extends('layouts.app')

@section('content')

{{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
{{-- @include('layouts.modal.success', ['modo' => 'Agregar']) --}}


    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ticket</h3>
            @include('layouts.favorito.fav', ['modo' => 'Agregar'])
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        @include('layouts.modal.delete', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 my-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <form method="GET" action="{{route('ticket.index')}}">
                                            <div class="input-group mb-3">
                                                <input name="name" type="text" class="form-control" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5 my-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @can('ATENDER-TICKET')
                                            <a type="button" class="btn btn-light" href="{{route('ticket.atencion')}}">Atencion Ticket</a>
                                        @endcan
                                        @can('ASIGNAR-TICKET')
                                            <a type="button" class="btn btn-light" href="{{route('ticket.asigna')}}">Asignadores</a>
                                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Extra</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{route('solucionador.index')}}" target="_blank">Solucionador</a></li>
                                                <li><a class="dropdown-item" href="{{route('categoriaprob.index')}}" target="_blank">Categoria</a></li>
                                                <li><a class="dropdown-item" href="{{route('categoriaprobsub.index')}}" target="_blank">Sub-categoria</a></li>
                                            </ul>
                                        @endcan
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    {!! Form::open(['method' => 'GET', 'route' => ['ticket.create'], 'class' => 'd-flex justify-content-end']) !!}
                                        {!! Form::submit('+ Nuevo Ticket', ['class' => 'btn btn-success my-1']) !!}
                                    {!! Form::close() !!}
                                </div>
                                
                            </div>
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
                                        <th class='ml-3' style="color:#fff;">Numero</th>
                                        <th class='ml-3' style="color:#fff;">Categoria</th>
                                        <th style="color:#fff;">Estado</th>
                                        <th style="color:#fff;">Solucionador</th>
                                        <th colspan="3" style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Tickets as $Ticket)
                                            <tr>
                                                <td>{{$Ticket->idtarea}}</td>
                                                <td>{{$Ticket->getCategoriaProb->getCatProblema->descatprob}}</td>
                                               
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
                                                
                                                <td>{{$Ticket->getSolucionador->nombre}}</td>
                                                
                                                <td>
                                                    @can('VER-TICKET')
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'route' => ['ticket.show', $Ticket->idtarea],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Ver', ['class' => 'btn btn-warning']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                                <td>
                                                    @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 1)
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'route' => ['ticket.edit', $Ticket->idtarea],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                                        {!! Form::close() !!}    
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 1)
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'class' => 'formulario',
                                                            'route' => ['ticket.cancel', $Ticket->idtarea],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Cerrar', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endif  
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

<script src="{{ asset('js/Coordinacion/Informatica/ticket/index_ticket.js') }}"></script>

    
@endsection