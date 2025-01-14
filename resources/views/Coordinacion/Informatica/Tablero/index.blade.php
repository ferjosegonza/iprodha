@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <h4 class="titulo page__heading my-auto">Tablero y Vistas API</h4>
            </div>
            <div class="">
                @include('layouts.favorito.fav', ['modo' => 'Agregar'])
            </div>
            
            <div class="ms-auto">
                <div class="row">
                    <div class="col">
                        @can('CREAR-TABLERO')
                        {!! Form::open(['method' => 'GET', 'route' => ['tab_vista_v.create'], 'class' => '']) !!}
                            {!! Form::submit('Agregar vista', ['class' => 'btn btn-success my-auto']) !!}
                        {!! Form::close() !!}
                        @endcan
                    </div>
                    <div class="col">
                        @can('CREAR-TABLERO')
                        {!! Form::open(['method' => 'GET', 'route' => ['tab_vista.create'], 'class' => '']) !!}
                            {!! Form::submit('Agregar tablero', ['class' => 'btn btn-success my-auto']) !!}
                        {!! Form::close() !!}
                        @endcan
                    </div>
                </div> 
            </div>
        </div>
        @include('layouts.modal.mensajes', ['modo' => 'Agregar'])
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <h5 class="text-center">Vistas API</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">                      
                            <div class="table-responsive">
                                <table class="table table-striped mt-2" id="rutas">
                                    <thead style="">
                                        <th class='ml-3 text-center' style="color:#fff; width:10%;">ID</th>
                                        <th class='text-center' style="color:#fff; width:15%;">Alias</th>
                                        <th class='text-center' style="color:#fff; width:20%;">Nombre</th>
                                        <th class='text-center' style="color:#fff; width:20%;">Tablero</th>
                                        <th class='text-center' style="color:#fff; width:35%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($vistas as $vista)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$vista->id_tc_vista}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$vista->alias_vista}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$vista->nombre_vista}}</td>
                                                
                                                <td class='text-center' style="vertical-align: middle;">{{$vista->getTablero->nombre_tablero}}</td>                                   

                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['tab_vista_v.edit', $vista->id_tc_vista], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="col">
                                                            <button class="btn btn-primary w-100" onclick = "mostrarRuta('{{$vista->alias_vista}}', '{{$vista->getTablero->nombre_tablero}}')">Ruta</button>
                                                            {{-- <a href=""class="btn btn-primary w-100" onclick = "mostrarRuta({{$vista->alias_vista}}, {{$vista->getTablero->nombre_tablero}})">Ruta</a> --}}
                                                        </div>
                                                        <div class="col">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['tab_vista_v.destroy', $vista->id_tc_vista], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', 'onclick' => "return confirm('¿Está seguro que desea ELIMINAR la vista?')"]) !!}
                                                            {!! Form::close() !!}
                                                        </div>
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
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-head">
                            <br>
                            <div class="row m-auto">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <h5 class="text-center">Tablero</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">                                     
                            <div class="table-responsive">
                                <table class="table table-striped mt-2" id="tablero">
                                    <thead style="height:50px;">
                                        <th class='ml-3 text-center' style="color:#fff; width:5%;">ID</th>
                                        <th class='text-center' style="color:#fff; width:35%;">Nombre</th>
                                        <th class='text-center' style="color:#fff; width:55%;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($tableros as $tablero)
                                            <tr>
                                                <td class='text-center' style="vertical-align: middle;">{{$tablero->id_tc_tablero}}</td>

                                                <td class='text-center' style="vertical-align: middle;">{{$tablero->nombre_tablero}}</td>                                   

                                                <td>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            {!! Form::open(['method' => 'GET', 'route' => ['tab_vista.edit', $tablero->id_tc_tablero], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-warning w-100']) !!}
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['tab_vista.destroy', $tablero->id_tc_tablero], 'style' => 'display:inline']) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger w-100', 'onclick' => "return confirm('¿Está seguro que desea ELIMINAR el tablero?')"]) !!}
                                                            {!! Form::close() !!}
                                                        </div>
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
                <div id='mostrar' class="col-xs-12 col-sm-12 col-md-6" style="display: none">
                    <div class="card">
                        <div id='contenido' class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="">
            <strong>
                <h7>
                    ¿Dudas? <a href="{{ asset('storage/gdu/ObrasViviendas.pdf') }}" style="color: rgb(30, 67, 233)" target="_blank">Descargue un instructivo aqui.</a> 
                </h7>
            </strong>
        </div> --}}
    </section>
    @include('Coordinacion.Informatica.Tablero.modal-view-code')
    {{-- <script src="{{ asset('js/usuarios/index_usuarios.js') }}"></script> --}}

{{-- <script src="{{ asset('js/categorialaboral/index_categorialaboral.js') }}"></script> --}}
<script src="{{ asset('js/modal/success.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#rutas').DataTable({
            language: {
                    lengthMenu: 'Mostrar _MENU_ registros por pagina',
                    zeroRecords: 'No se ha encontrado registros',
                    info: 'Mostrando pagina _PAGE_ de _PAGES_',
                    infoEmpty: 'No se ha encontrado registros',
                    infoFiltered: '(Filtrado de _MAX_ registros totales)',
                    search: 'Buscar',
                    paginate:{
                        first:"Prim.",
                        last: "Ult.",
                        previous: 'Ant.',
                        next: 'Sig.',
                    },
                },
                "aaSorting": []
        });
    });

    function mostrarRuta(alias, tablero) {
        // cargarModal();
        let ruta = "https://sistema.iprodha.misiones.gob.ar/api/tc/"+tablero+"/"+alias;
        let codigo = document.getElementById('cod_txt_area');
        $('#ruta').val(ruta);
        let html = '';
        codigo.innerHTML = '';
        $.when($.ajax({
            type: "post",
            url: '/tab_vista/obtener_codigo/'+tablero+'/'+alias, 
            data: {
                tablero: tablero,
                alias: alias,
            },
            success: function (response) {
                codigo.innerHTML = response[0].codigo;
            },
            error: function (error) {
                console.log(error);
            }
        }));
        $('#exampleModalCo').modal('show');  
            // return confirm('La ruta es https://sistema.iprodha.misiones.gob.ar/api/tc/'+tablero+'/'+alias);
    }

    function copiarCodigo(){
        // Get the text field
        var copyText = document.getElementById("cod_txt_area");

        // Select the text field
        copyText.select();
        // copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Copiado");
    }

    function copiarRuta(){
        // Get the text field
        var copyText = document.getElementById("ruta");

        // Select the text field
        copyText.select();
        // copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Copiado");
    }

</script>

    
@endsection