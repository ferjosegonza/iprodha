@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Solucionador</h3>
    </div>
    @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">         
                    
                    {!! Form::open(array('route' => 'solucionador.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Nombre del Solucionador:</label>                                    
                                    {!! Form::text('nombre', null, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    {!! Form::label('Tipo de solucionador:', null, ['class' => 'control-label me-2', 'style' => 'white-space: nowrap;width:100%']) !!}
                                    <select class="form-select" name="tipo" placeholder="Seleccionar">
                                        @foreach ($Tipos as $Tipo)
                                            <option value={{"$Tipo->idtipsolucionador"}}>{{$Tipo->destipsolucionador}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('solucionador.index') }}"class="btn btn-secondary fo">Volver</a>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
