@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Obras</h3>
        </div>
        <div class="section-body">
            <div class="">
                <div class="row">
                    @include('layouts.modal.mensajes')
                    <div class="pagination justify-content-end">
                        {!! $Obras->links() !!}
                    </div>
                    <div class="col">
                        <div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-start">
                                    <div style="height:30px">

                                        @can('VER-OBRAS')
                                            <a class="btn btn-warning" href="{{ route('obras.crear') }}">Nuevo</a>
                                        @endcan
                                    </div>
                                    <div class="pagination offset-xs-5">
                                        <!-- Ubicamos la paginacion a la derecha -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover mt-2">
                            <thead style="background-color:#6777ef">
                                <th scope="col" style="color:#fff;">ID Obra</th>
                                <th scope="col" style="color:#fff;width:60%;">Nombre Obra</th>
                                <th scope="col" style="color:#fff;">Expediente</th>
                                <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($Obras as $unaobra)
                                    <tr>
                                        <td>{{ $unaobra->id_obr }}</td>
                                        <td>{{ $unaobra->nom_obr }}</td>
                                        <td>{{ $unaobra->expedte }}</td>
                                        <td>
                                            @csrf
                                            @can('EDITAR-OBRAS')
                                                <a class="btn btn-info" href="{{ route('obras.editar', $unaobra) }}">Editar</a>
                                            @endcan
                                            @can('VER-OBRAS')
                                                <a class="btn btn-info"
                                                    href="{{ route('obrasCertif.detalle', $unaobra) }}">Detalle</a>
                                            @endcan
                                            @method('DELETE')
                                            @can('BORRAR-OBRAS')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['obras.eliminar', $unaobra->id_obr],
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                {!! Form::submit('Borrar', [
                                                    'class' => 'btn btn-danger',
                                                    'onclick' => "return confirm('Estas seguro que desea ELIMINAR la obra \"" . $unaobra->nom_obr . "\"')",
                                                ]) !!}
                                                {!! Form::close() !!}
                                            @endcan
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
