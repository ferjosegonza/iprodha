@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Atencion de Tickets</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3 my-auto">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <div class="row justify-content-evenly align-items-evenly">
                                    <form method="GET" action="{{route('ticket.atencion')}}">
                                        <div class="input-group mb-3">
                                            <input name="name" type="text" class="form-control" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-3 my-auto">
                               
                            </div>
                            
                            <div class="col-lg-2">
                                
                            </div>
                            
                            <div class="col-lg-2">
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <!-- Centramos la paginacion a la derecha -->
                        {{-- @if (!is_null($Tickets)) --}}
                            <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}
                            </div>
                        {{-- @endif --}}
                        
                        <div class="table-responsive text-center">
                            <table class="table table-striped mt-2">
                                <thead style="height:50px;">
                                    <th class='ml-3' style="color:#fff;">ID</th>
                                    <th class='ml-3' style="color:#fff;">Categoria</th>
                                    <th style="color:#fff;">Estado</th>
                                    {{-- <th style="color:#fff;">Solucionador</th> --}}
                                    <th colspan="2" style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($Tickets as $Ticket)
                                        <tr>
                                            <td>{{$Ticket->idtarea}}</td>
                                            <td>{{$Ticket->getCategoriaProb->catprobsub}}</td>
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
                                            
                                            {{-- <td>{{$Ticket->getSolucionador->nombre}}</td> --}}
                                            
                                            <td>
                                                @if ($Ticket->getEstadoTarea->sortByDesc('idestado')->first()->getEstado->idestado == 2 || $Ticket->getEstadoTarea->last()->getEstado->idestado == 3)
                                                    {!! Form::open([
                                                        'method' => 'GET',
                                                        'route' => ['ticket.atender', $Ticket->idtarea],
                                                        'style' => 'display:inline',
                                                    ]) !!}
                                                    {!! Form::submit('Atender', ['class' => 'btn btn-primary']) !!}
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
            <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display: none">
                <div class="card">
                    <div id='contenido' class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Coordinacion/Informatica/ticket/index_ticket.js') }}"></script>
</section>
@endsection