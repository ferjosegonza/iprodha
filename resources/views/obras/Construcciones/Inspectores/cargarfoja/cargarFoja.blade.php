@extends('layouts.app')
@section('content')    

@include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            {{-- Titulo --}}
            <h3 class="page__heading">Seleccionar Obra</h3> 
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    @include('layouts.modal.mensajes')
                    {{-- Buscadores --}}
                    {{--<div class="card">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-USUARIO')
                                                {!! Form::open(['method' => 'GET', 'route' => ['usuarios.create'], 'class' => 'd-flex justify-content-evenly']) !!}
                                                    {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['usuarios.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-8 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            {!! Form::open(['method' => 'GET', 'class' => 'd-flex justify-content-evenly', 'route' => ['usuarios.pdf']]) !!}
                                                {!! Form::submit('Imprimir', ['class' => 'btn btn-success my-1']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="card  col-md-12 ">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr class="table-dark">
                                            <th>Numero</th>
                                            <th>Nombre</th>
                                            <th>Empresa</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
                                        <br>                
                                        @foreach($cargarFoja as $cargarFoja)
                                            <tr>
                                                <td>{{$cargarFoja->num_obr}}</td>                        
                                                <td>{{$cargarFoja->nom_obr}}</td>
                                                <td>{{$cargarFoja->nom_emp}}</td>
                                                <td>
                                                    {!!Form::open(['method'=>'GET','route'=>['cargarfoja.edit',$cargarFoja->id_obr],'style'=>'display:inline'])!!}
                                                        {!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
                                                    {!!Form::close()!!}                            
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a class="btn btn-dark" href="{{route("cargarfoja.index")}}">Volver al listado</a> 
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
    </section>


@endsection