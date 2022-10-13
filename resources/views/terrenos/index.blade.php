@extends('layouts.app')

@section('page_css')
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/conceptofacturacion/conceptofacturacion.css') }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Terrenos</h3>
    </div> 

    <div class="pagination justify-content-end">
        {!! $terrenos->links() !!}
    </div>
    <div class="section-body">
        <table id="terr" class="table table-hover mt-2">
            <thead style="background-color:#6777ef">
                <th scope="col" style="color:#fff;width:0%; display:none;">ID</th>
                <th scope="col" style="color:#fff;width:8%;" class="text-center">SECCION</th>
                <th scope="col" style="color:#fff;width:8%;" class="text-center">CHACRA</th>
                <th scope="col" style="color:#fff;width:8%;" class="text-center">MANZANA</th>
                <th scope="col" style="color:#fff;width:8%;" class="text-center">PARCELA</th>
                <th scope="col" style="color:#fff;width:28%; padding-left:5%;">CALLE</th>
                <th scope="col" style="color:#fff;width:21%; padding-left:1%;">MUNICIPIO</th>
                <th scope="col" style="color:#fff;width:15%;" class="text-center">Acciones</th>
            </thead>

            <tbody class='table-primary'>
                @foreach ($terrenos as $terreno)
                <tr>
                    <td style="display:none;">{{ $terreno->id_terterreno }}</td>
                    <td class="text-center">{{ $terreno->seccion }}</td>
                    <td class="text-center">{{ $terreno->chacra }}</td>
                    <td class="text-center">{{ $terreno->manzana }}</td>
                    <td class="text-center">{{ $terreno->parcela }}</td>
                    <td>{{ $terreno->calle }}</td>
                    <td>{{ $terreno->municipios->nom_municipio }}</td>
                    <td class="text-center">
                        <form action="{{ route('terrenos.destroy', $terreno->id_terterreno) }}" method="POST">
                            <a class='btn btn-info' href="/terrenos/{{ $terreno->id_terterreno }}/edit">Editar</a>
                            @csrf
                            @method("DELETE")
                            <button type="submit" class='btn btn-danger' disabled >Borrar</button>
                        </form>
                    </td>
                </tr>    
                @endforeach
            </tbody>
        </table>
        @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(
                function () { 
                    $('#terr').DataTable({"lengthMenu": [[5,10,50,-1],[5,10,50,"Todos"]], 
                                          "language": {"search": "Buscar:", 
                                                       "lengthMenu": "Mostrar _MENU_ registros por página", 
                                                       "info": "Mostrando página _PAGE_ de _PAGES_", 
                                                       "paginate": {"previous":"Anterior", "next":"Siguiente", "first":"Primero", "last":"Último"}
                                                      } 
                                         }); 
                }
            );
        </script>
    @endsection        
    </div>
</section>

@endsection