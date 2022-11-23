@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Editar Operatoria</h3></div>        
        {!!Form::model($ob_operatoria,['method'=>'PATCH','class'=>'formulario','route'=>['ob_operatoria.update',$ob_operatoria->id_ope]])!!}
        <div class="section-body row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                @include('layouts.modal.mensajes')
                <div class="card">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!!Form::label('operatoria','Operatoria :')!!}
                                    {!!Form::text('operatoria',old('operatoria'),['class'=>'form-control'])!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!!Form::label('cuenta','Cuenta :')!!}
                                    {!!Form::text('cuenta',old('cuenta'),['class'=>'form-control'])!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!!Form::label('banco','Banco :')!!}
                                    {!! Form::text('banco',old('banco'),['class'=>'form-control'])!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!!Form::label('caracter','Caracter :')!!}
                                    {!!Form::text('caracter',old('caracter'),['class'=>'form-control'])!!}                                   
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {{--@can('CREAR-USUARIO')--}}                                
                                {!!Form::submit('Guardar',['onclick'=>'','class'=>'btn btn-success mr-2'])!!}
                                {{--@endcan--}}
                                <a class="btn btn-dark" href="{{route("ob_operatoria.index")}}">Volver al listado</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </section>
@endsection