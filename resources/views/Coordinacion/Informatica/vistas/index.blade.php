@extends('layouts.app')
@section('css')
    <style>
        #menu * {
            list-style: none;
        }

        #menu li {
            line-height: 180%;
        }

        #menu li a {
            color: #222;
            text-decoration: none;
        }

        #menu li a:before {
            content: "\025b8";
            color: #ddd;
            margin-right: 4px;
        }

        #menu input[name="list"] {
            position: absolute;
            left: -1000em;
        }

        #menu label:before {
            content: "\025b8";
            margin-right: 4px;
        }

        #menu input:checked~label:before {
            content: "\025be";
        }

        #menu .interior {
            display: none;
        }

        #menu .interior1 {
            display: block;
        }

        #menu input:checked~ul {
            display: block;
        }
    </style>
@endsection
@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Vistas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col row d-flex justify-content-between">
                    @include('layouts.modal.mensajes')
                    
                    <div class="card col-sm-12  col-md-12 col-lg-6">
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2 ">
                                    <thead>
                                        <tr>
                                            <th style="color:#fff;">Nombre</th>
                                            <th style="color:#fff;">Archivo</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vistas as $vista)
                                            <tr onclick="buscarvista({{ $vista->idvista }});">
                                                <td style="height: 10px">{{ $vista->nomvista }}</td>
                                                <td>{{ $vista->nomarchivo }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'vistas.updatevista','class'=>' col-sm-12  col-md-12 col-lg-5', 'method' => 'POST','onKeyPress'=>"if(event.keyCode == 13) event.returnValue = false;"]) !!}

                    <div class="card">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong><label class="text-dark" >Info</label></strong>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 ms-3">
                                        <label>Id:</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 row ms-3">
                                        <div  class="col-auto">
                                            {!! Form::number('id', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'id' => 'id',
                                                'class' => ' form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3 row ms-auto">
                                        <div  class="col-auto">
                                            {!! Form::submit('Guardar', ['id'=>'btnguardar','class' => 'btn btn-warning mx-2']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 mt-2 ms-3">
                                        <label>Nombre:</label>
                                    </div>
                                    <div class="col-xs-12 row ms-3">
                                        <div class="col-xs-12 col-sm-12 col-md-8 ">
                                            {!! Form::text('name', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'id' => 'name',
                                                'class' => ' form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 mt-2 ms-3">
                                        <label>Path:</label>
                                    </div>
                                    <div class="col-xs-12 row ms-3">
                                        <div class="col-xs-12 col-sm-12 col-md-8 ">
                                            {!! Form::text('path', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'id' => 'path',
                                                'class' => ' form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 mt-2 ms-3">
                                        <label>Archivo:</label>
                                    </div>
                                    <div class="col-xs-12 row ms-3">
                                        <div class="col-xs-12 col-sm-12 col-md-8 ">
                                            {!! Form::text('archivo', null, [
                                                'style' => 'text-transform:uppercase;',
                                                'id' => 'archivo',
                                                'class' => ' form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    <div class="col-sm-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ms-3">
                                    <div class="row align-items-center justify-content-center">
                                        
                                        <div class="col-xs-12 mt-5 ms-5 d-flex"  >
                                            <label class="col-sm-8" style="font-size: 1.5em"> <strong>
                                                ARBOL</strong></label>
                                        </div>
    
                                        <ul class="col-xs-12 mt-2 ms-5" id="menu">
                                            @include('Coordinacion.Informatica.vistas.menu-unavista', ['arbol' => $arbol])
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>

        function eliminarmenu(nom,id) {
                //obtengo el nombre
                let nombre = nom;
                //cambio los valores del modal -- ruta -- mensaje
                $('#eliminar').attr('action','http://192.168.10.84/roles/eliminarmenu/'+id);
                $('#contenidoModal').text('Seguro que desea Eliminar el Menu \"'+nombre+'\"');
                $('#exampleModal').modal('show');
        }

        function buscarvista(id) {
            $.ajax({
                type: "get",
                url: "http://192.168.10.84/vistas/buscarvista",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response)
                    vista = response.vista;
                    arbol = response.html;
                    
                    $('#id').val(vista.idvista);
                    $('#name').val(vista.nomvista);
                    $('#path').val(vista.path);
                    $('#archivo').val(vista.nomarchivo);
                    $('#menu').empty();
                    $('#menu').html(arbol);
                },
                error: function(error) {
                    console.log(error);
                }
            });

        }

        $(document).ready(function () {
            $('#example').DataTable({
                language: {
                    lengthMenu: 'Mostrar _MENU_',
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
            });
            });
    </script>
@endsection
