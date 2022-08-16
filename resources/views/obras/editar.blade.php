
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Obras</h3>
        </div>
        <div class="section-body">
        <form method="post" action="{{ route('obras.update',$unaobra->id_obr) }}" >
            @csrf
            @method('PATCH')
            <div class="card-body">    
                @include('layouts.modal.mensajes')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="nomObra">Nombre</label>
                    <input type="text" class="form-control" name="nom_obr" value="{{ $unaobra->nom_obr }}"/>
                    
                </div>

                <div class="form-group">
                    <label for="expteObra">Expediente</label>                    
                    <input type="text" class="form-control" name="expedte" value="{{ $unaobra->expedte }}"/>
                </div>
            </div> 
                    
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">   
                </div>
            <!--a class="btn btn-info"  href="{{ route('obras.crear',$unaobra) }}">Grabar</a-->

            </div>
        </form>
        </div>
    </section>
@endsection
