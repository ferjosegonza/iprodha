
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Empleados</h3>
        </div>
        <div class="section-body">
            <div class="">
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
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-start">
                                    <div style="height:30px">
                                        @can('crear-empleado')
                                        <a class="btn btn-warning"  href="{{ route('empleado.create') }}">Nuevo</a>
                                        @endcan
                                    </div>
                                    <div class="pagination offset-xs-5">
                                        <!-- Ubicamos la paginacion a la derecha -->
                                        {!! $empleados->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover mt-2">
                            <thead style="background-color:#6777ef">                                     
                                <th scope="col" style="color:#fff;">ID</th>
                                <th scope="col" style="color:#fff;">Nombre</th>
                                <th scope="col" style="color:#fff;">Apellido</th>   
                                <th scope="col" style="color:#fff;">Domicilio</th>                                    
                                <th scope="col" style="color:#fff;">Foto</th>                                      
                                <th scope="col" style="color:#fff;">Fecha Alta</th>                                      
                                <th scope="col" style="color:#fff;">Fecha Mod.</th>                                    
                                <th scope="col" style="color:#fff;">Acciones</th>                                                                   
                            </thead>
                            <tbody>
                                @foreach ($empleados as $empleado)
                                    <tr>
                                        <th scope="row" >{{ $empleado->id }}</th>                                
                                        <td>{{ $empleado->nombre }}</td>
                                        <td>{{ $empleado->apellido }}</td>
                                        <td>{{ $empleado->domicilio }}</td>
                                        <td>
                                            @if (isset($empleado->foto))
                                                <img src="{{ asset('storage').'/'.$empleado->foto }}" style="width:100px;height:100px;" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $empleado->created_at }}</td>
                                        <td>{{ $empleado->updated_at }}</td>
                                        <td>
                                            <form action="{{ route('empleado.destroy',$empleado->id) }}" method="POST">                                        
                                                @csrf
                                                @can('editar-empleado')
                                                    <a class="btn btn-info"  href="{{ route('empleado.edit',$empleado->id) }}">Editar</a>
                                                @endcan

                                                
                                                @method('DELETE')
                                                @can('borrar-empleado')
                                                    <button type="submit" onclick="return confirm('Quieres borrar?')" class="btn btn-danger">Borrar</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
