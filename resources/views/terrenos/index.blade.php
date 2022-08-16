@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/conceptofacturacion/conceptofacturacion.css') }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Terrenos</h3>
    </div>
    <div class="section-body">
        <table class="table table-hover mt-2">
            <thead style="background-color:#6777ef">
                <th scope="col" style="color:#fff;width:10%;">SECCION</th>
                <th scope="col" style="color:#fff;width:10%;">CHACRA</th>
                <th scope="col" style="color:#fff;width:10ch;">MANZANA</th>
                <th scope="col" style="color:#fff;width:10%;">PARCELA</th>
                <th scope="col" style="color:#fff;width:40%;">CALLE</th>
                <th scope="col" style="color:#fff;width:25%;">Acciones</th>
            </thead>
        </table>
    </div>
</section>

@endsection