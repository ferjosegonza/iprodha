
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Obras Nuevas</h3>
        </div>
        <form method="post" action="{{ route('obras.store') }}">
            <div class="card-body">    

            @include('layouts.modal.mensajes')
            </div>

            @csrf
            @method('POST')
            <div class="form-group">
                <label for="nom_obr">Obra:</label>
                <input type="text" class="form-control" name="nom_obr"/>
            </div>
            <div class="form-group">
                <label for="expedte">Expediente:</label>
                <input type="text" class="form-control" name="expedte"/>
            </div>
            @can('CREAR-OBRAS')
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            @endcan
            
      </form>
    </section>
@endsection
