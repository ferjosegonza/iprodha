@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="titulo"><h4>{{$obra->nomobra}}</h4></div>
        </div>
        <div class="section-body">           
            <br>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Estados</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover mt-2">
                                <thead>
                                    <th class= 'text-center' scope="col" style="color:#fff;width:3%;">Estado</th> 
                                    <th class= 'text-center' scope="col" style="color:#fff;width:3%;">Fecha</th>                                         
                                </thead>
                                <tbody>
                                    @foreach ($estadosobra as $estadoobra)
                                        <tr>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$estados->find($estadoobra->idestado)->denestado}}</td>
                                            <td class= 'text-center' style="vertical-align: middle;">{{$estadoobra->fechacambio}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>
            <br>
            <div>
                <a href="{{ route('estadosxobra.index') }}"class="btn btn-primary">Volver</a>
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
    <script src="{{ asset('js/Obrasyfinan/Ofertas/index_oferta.js') }}"></script>
@endsection