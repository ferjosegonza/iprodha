@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Notificaciones</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                @include('layouts.modal.mensajes')
                <div class="row">                    
                    <table id="example" class="display table table-hover mt-2"" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 7%;color:#fff; text-align:center; ">Estado</th>
                                <th style="color:#fff; text-align:center;">Pendiente</th>
                                <th style="color:#fff; text-align:center;">Descripción</th>
                                <th style="color:#fff; text-align:center;">Fecha de Generación</th>
                                <th style="color:#fff; text-align:center;">Acción</th>   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notificaciones as $notif)
                                @if($notif->idestado != 3)
                                    <tr> 
                                        @if($notif->idestado==1)
                                        <td style="color: red; font-size:12px">NUEVO</td>
                                        @else
                                        <td style="font-size:12px">VISTO</td>
                                        @endif                                    
                                        <td style="text-align:center;">{{strtoupper($notif->getMensaje->titulo)}}</td>
                                        <td style="text-align:center;">{{$notif->getMensaje->mensaje}}</td>
                                        <td style="text-align:center;">{{$notif->fecha}}</td>
                                        <td style="text-align:center;"><a href='{{route('notif.ver', $notif->idnotificacion)}}' class="btn" style="text-decoration: none; font-size: 14px">Ir</a>  </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>        
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
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
                order: [[ 1, 'asc' ]],
            });
            });
    </script>
@endsection