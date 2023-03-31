@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Sector</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">          
                        <h1>Sector: {{$sector->id_sector}}</h1> 
                        {!! Form::model($sector, ['method' => 'PATCH','route' => ['sector.update', $sector->id_sector]]) !!}                     
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="">Nombre del sector:</label>               
                                    {!! Form::text('nom_sector', $sector->nom_sector, array('class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Descripción del sector:</label>                                    
                                    {!! Form::text('desc_sector', $sector->desc_sector, array('class' => 'form-control','style' => 'text-transform:uppercase')) !!}
                                </div>
                            </div>       
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <a href="{{ route('sector.index') }}"class="btn btn-secondary fo">Volver</a>
                        {!! Form::close() !!} 
                    </div> 
                </div>
            </div>
        </div>
    </section>
@endsection