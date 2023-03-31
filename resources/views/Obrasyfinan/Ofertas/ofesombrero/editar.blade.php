@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo py-1">Edicion Concepto Sombrero - Obra: <strong>{{$unaObra->nomobra}}</strong></div>
            {{-- <a><strong>Edicion Concepto Sombrero - Obra: {{ $unaObra->nomobra}} </strong></a> --}}
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['route' => ['ofesombreroxobra.actualizar',$unaObra->idobra], 'method' => 'PATCH']) !!}
                            <div class="row">
                                <div hidden>
                                    {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::text('idobra',  $unaObra->idobra, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-12">
                                    <p>Conceptos:</p>
                                </div>
                                @foreach ( $sombrerosxobra as $sombrero => $i )
                                <div class="col-6 py-1">
                                    <div class="row">
                                        <div class="col-6 m-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{$i->idconceptosombrero}}" id="flexCheckDefault" name="conceptos[]" onclick = "this.checked = !this.checked" checked>
                                                {{--{!! Form::checkbox('conceptos[]', $i->idconceptosombrero, ($i->valor) ? true : false, ['class' => 'form-check-input', 'readonly']) !!} --}}
                                                <label class="" for="flexCheckDefault">
                                                    {{$i->getConceptoSombrero->conceptosombrero}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control" name="valores[]" value={{$i->valor}}>
                                        </div>
                                    </div> 
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="d-flex mt-1">
                                    <div class="me-auto"></div>
                                    <div class="p-1">
                                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        {!! Form::open(['method' => 'GET', 'route' => ['ofesombreroxobra.indexx',$unaObra->idobra], 'style' => '']) !!}
                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-outline-primary']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- {!! Form::open(['route' => ['ofesombreroxobra.actualizar',$unaObra->idobra], 'method' => 'PATCH']) !!}
        @include('layouts.modal.mensajes')
        <div style="width:99%;float:left;">
            <div hidden>
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div>
            <div hidden>
                {!! Form::label('Id Obra:', null, ['class' => 'control-label', 'style' => 'white-space: nowrap; ']) !!}
                {!! Form::text('idobra',  $unaObra->idobra, ['class' => 'form-control']) !!}
            </div>
                {!! Form::label('Concepto :', null, ['class' => 'control-label', 'style' => 'white-space: nowrap;']) !!}
                {!! Form::open(array('method'=>'post')) !!}
                @foreach ( $sombrerosxobra as $sombrero => $i )                    
                    <div style="width:70%;'float:left;">
                        @if ($sombrerosxobra->idconceptosombrero=$i->idconceptosombrero)
                            
                        @endif
                        {!! Form::checkbox('conceptos[]', $i->idconceptosombrero, ($i->valor) ? true : false) !!}
                        {!! Form::label($sombrero, $i->getConceptoSombrero->conceptosombrero,['class' => 'control-label']) !!}
                        
                        {!! Form::number('valores[]', $i->valor, [ 'class' => 'form-control','style' => 'white-space: nowrap;width:20%;']) !!}
                    </div>                    
                @endforeach
                
                {!! Form::close() !!}
                    @can('CREAR-OBRAS')
                @endcan
        {!! Form::submit('Guardar', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
                {!! Form::open(['method' => 'GET', 'route' => ['ofesombreroxobra.indexx',$unaObra->idobra], 'style' => 'display:inline']) !!}
                {!! Form::submit('Cancelar', ['class' => 'btn btn-primary my-3']) !!}
                {!! Form::close() !!}
                
        </div> --}}
    </section>
@endsection
