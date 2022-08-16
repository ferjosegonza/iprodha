
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Costos de Barrio  {{$unBarrio->nombarrio }}</h3>
        </div>
        <div class="section-body">
            {!! Form::model($Costos, ['method' => 'POST','route' => ['barrio.index', $unBarrio->barrio]]) !!}
            <div class="card-body">
                @include('layouts.modal.mensajes')
            </div>
            <div style="width:99%;float:left;">
                <div style="width:30%;float:left;margin-left:1%;">
                    {!! Form::label('Dormitorios:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('dormitorioCosxBarrio',$Dormis1->pluck('cantdorm'),null
                        ,['placeholder' => 'Seleccionar', 'class' => 'form-select','onClick' => 'show1();']
                        ) !!}
                </div>
                <div style="width:30%;float:left;margin-left:1%;">                    
                    {!! Form::label('Mensual:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('plazomensualCosxBarrio',$BarrioMen->pluck('plazo'),$BarrioMen->pluck('plazo')
                        , ['placeholder' => 'Seleccionar', 'class' => 'form-select']
                        ) !!}
                </div>
                <div style="width:30%;float:left;margin-left:1%;">
                    {!! Form::label('Anual:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                    {!! Form::select('plazoanualCosxBarrio',$BarrioAnual->pluck('plazo'),$BarrioAnual->pluck('plazo')
                        , ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!}
                </div>
            </div>
            </div>     
       
            <div class="row">
                <div class="col">
                    <div>
                        @if (Session::has('mensaje'))                                                        
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('mensaje') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <table class="table table-hover mt-2">
                        <thead style="background-color:#6777ef">                                     
                            <th scope="col" style="color:#fff;">ID_CONCOSTO</th>
                            <th scope="col" style="color:#fff;">CANTDORM</th>
                            <th scope="col" style="color:#fff;">IDTIPOFAC</th>   
                            <th scope="col" style="color:#fff;">IDTIPOTERRE</th>
                            <th scope="col" style="color:#fff;">CONCOSTO</th>
                            <th scope="col" style="color:#fff;">SUMAORESTA</th>
                            <th scope="col" style="color:#fff;">IMPORTE</th>

                        </thead>
                        <tbody>                                
                            @foreach ($Costos as $costo)
                                <tr>
                                    <td>{{ $costo->id_concosto }}</td>
                                    <td>{{ $costo->cantdorm }}</td>
                                    <td>{{ $costo->idtipofac }}</td>
                                    <td>{{ $costo->idtipoterre }}</td>
                                    <td>{{ $costo->concosto }}</td>
                                    <td>{{ $costo->sumaoresta }}</td>
                                    <td>{{ $costo->importe }}</td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection