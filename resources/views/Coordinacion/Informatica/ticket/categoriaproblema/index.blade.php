@extends('layouts.app')

@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Categoria Problema</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col">
                    @include('layouts.modal.mensajes')
                    <div class="card col-sm-6">
                        <div class="card-body">
                            
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-ROL')
                                                {!! Form::open(['method' => 'GET', 'route' => ['categoriaprob.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['categoriaprob.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card col-sm-6">
                        <div class="card-body ">
                            <div class="pagination justify-content-end">
                                <!-- Ubicamos la paginacion a la derecha -->
                                {{-- {!! $roles->links() !!} --}}
                            </div>
                            <div class="table-responsive text-center">

                                <table class="table table-striped mt-2">
                                    <thead>
                                        <th style="color:#fff;">Nombre</th>
                                        <th style="color:#fff;">Baja</th>
                                        <th style="color:#fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach($CatProbs as $CatProb)
                                            <tr>
                                                <td>{{$CatProb->descatprob}}</td>
                                                <td>
                                                    @if ($CatProb->baja != null)
                                                        {{Carbon\Carbon::parse($CatProb->baja)->format('d-m-Y')}}
                                                    @endif 
                                                </td>
                                                <td>
                                                    <div class="align-items-center">
                                                        @can('EDITAR-ROL')
                                                            {!! Form::model($CatProb, [
                                                                'method' => 'GET',
                                                                'route' => ['categoriaprob.edit', $CatProb->idcatprob],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::text('id', null, ['class' => 'd-none', 'value' => $CatProb->idcatprob, 'placeholder' => $CatProb->idcatprob]) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan

                                                        @can('BORRAR-ROL')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'formulario',
                                                                'route' => ['categoriaprob.destroy', $CatProb->idcatprob],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
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
    {{-- <script src="{{ asset('js/ticket/index_tiposolucionador.js') }}"></script> --}}
@endsection