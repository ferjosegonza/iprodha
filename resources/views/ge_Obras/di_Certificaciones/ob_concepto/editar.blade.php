
@extends('layouts.app')

@section('content')
<section class="section">
    {!! Form::model($vConceptos,['method' => 'PATCH', 'class' => 'formulario','route' => ['Ob_Concepto.update', $vConceptos->id_concepto]]) !!} 
    <div class="section-header">
        <h3 class="page__heading">Editar Concepto </h3>
    </div>
    <div class="section-body">

        <div class="section-body row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                {{-- @include('layouts.modal.mensajes') --}}
                <div class="card">
                    <div class="card-body">

                        <div class="row ">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">

                                    {!! Form::label('id_concepto', 'id Concepto :') !!}
                                    {!! Form::text('id_concepto', null,['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Nombre Concepto :') !!}
                                    {!! Form::text('descripcion' ,null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::label('sigo', 'sigo :') !!}
                                    {!! Form::select('signo', array('1' => 'Suma', '2' => 'Resta', '0' => 'Neutro'),null,['class'=>'form-control'])!!}
                                </div>
                            </div>
                            <div class="col-xs-15 col-sm-15 col-md-15">
                                <div class="form-group">
                                    {!! Form::label('orden_pie1', 'orden :') !!}
                                    {!! Form::selectRange('orden_pie',1,17,null,['class' => 'form-control'])!!}
                                </div>
                            </div>                    
                            <div class="col-xs-15 col-sm-15 col-md-15">
                                <div class="form-group">
                                    {!! Form::submit('Editar', ['onclick' => '', 'class' => 'btn btn-success mr-2']) !!}
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- {!! Form::model($vConceptos)!!}        
        {!! Form::text('id_concepto') !!}
        {!! Form::text('descripcion') !!}
        {!! Form::text('signo') !!}
        {!! Form::text('orden_pie') !!} --}}
        
        {{ Form::close()}}
    </div>
</section>
@endsection

