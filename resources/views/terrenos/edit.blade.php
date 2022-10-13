@extends('layouts.app')

@section('content')
<h2 class="bg-primary text-white text-center">Datos del Terreno</h2>

<div style="width:60%; margin-left:20%; background-color:white;" class="card">
    <div class="card-body">
        <div class="card p-3 bg-secondary">    
            <span>Esto sería el formulario de edición de datos de terrenos</span>
        </div>    

        <form action="/terrenos/{{ $terreno->id_terterreno }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="" class="col-form-label text-right" style='padding-right:1%;'>Id: </label>
                <input type="text" class="col-form-control" name="id" value="{{ $terreno->id_terterreno }}" style='width:10%' readonly>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Seccion: </label>
                <input type="text" class="col-form-control" name="seccion" value="{{ $terreno->seccion }}" style='width:10%'>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Chacra: </label>
                <input type="text" class="col-form-control" name="chacra" value="{{ $terreno->chacra }}" style='width:10%'>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Manzana: </label>
                <input type="text" class="col-form-control" name="manzana" value="{{ $terreno->manzana }}" style='width:10%'>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Parcela: </label>
                <input type="text" class="col-form-control" name="parcela" value="{{ $terreno->parcela }}" style='width:10%'>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Calle: </label>
                <input type="text" class="col-form-control" name="calle" value="{{ $terreno->calle }}" style='width:60%'>
            </div>
            <div class="mb-3">
                <label for="" class="col-form-label" style='padding-right:1%;'>Municipio: </label>
                <!--input type="text" class="col-form-control" name="muni" value="{{ $terreno->municipios->nom_municipio }}" style='width:30%'-->
                <select class="col-form-label " name='muni' style='width:50%'>
                    @foreach ($municipios as $municipio)
                        @if($municipio->id_municipio == $terreno->id_mun)
                            <option value="{{ $municipio->id_municipio }}" selected >{{ $municipio->nom_municipio }}</option>
                        @else
                            <option value="{{ $municipio->id_municipio }}" >{{ $municipio->nom_municipio }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <a href="/terrenos" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" disabled >Guardar</button>
        </form>
    </div>
</div>
@endsection