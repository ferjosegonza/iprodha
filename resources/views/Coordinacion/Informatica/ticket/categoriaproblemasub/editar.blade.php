@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Sub-Categoria problema</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         

                        {!! Form::model($categsub, ['method' => 'PATCH','route' => ['categoriaprobsub.update', $categsub->idcatprobsub]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    {{-- {!! Form::select('categ', [], null, ['placeholder' => 'Seleccionar', 'class' => 'form-select']) !!} --}}
                                    <select class="form-select" name="categ" placeholder="Seleccionar" id='selected-categoria' required>
                                        <option disabled selected>Seleccionar</option>
                                        @foreach ($Categorias as $Categoria)
                                            @if($categsub->idcatprob == $Categoria->idcatprob)
                                                <option value={{"$Categoria->idcatprob"}} selected>{{$Categoria->descatprob}}</option>
                                            @else
                                                <option value={{"$Categoria->idcatprob"}}>{{$Categoria->descatprob}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Sub-categoria:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap; width:100%']) !!}                                   
                                    {!! Form::text('nombre', $categsub->catprobsub, array('class' => 'form-control', 'type' => 'text', 'required')) !!}
                                </div>
                                
                                
                                
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Enviar</button>
                        <a href="{{ route('categoriaprobsub.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('js/ticket/index_ticket.js') }}"></script> --}}
</section>
@endsection