@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sistema IPRODHA</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-12">
                    @include('layouts.modal.mensajes')

                    <div class="card col-sm-12">
                        <div class="card-body">
                            {{--Contenido--}}
                            {{-- hola --}}
                            @include('favoritos.index')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.favorito.editar', ['modo' => 'Agregar'])
@endsection
