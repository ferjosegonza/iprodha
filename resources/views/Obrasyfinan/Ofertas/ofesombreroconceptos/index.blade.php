@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3>Detalle del Item </h3>
        </div>
        <div class="section-body">
            <div class="row " >
                
                @include('layouts.modal.mensajes')
                <table id="example" class="table table-hover mt-2">
                    <thead style="background-color:#6d7cf1;">
                        <th scope="col" style="color:#fff;width:5%;">Orden</th>
                        <th scope="col" style="color:#fff;width:10%;">Id Item</th>                        
                        <th scope="col" style="color:#fff;width:30%;">Item</th>
                        <th scope="col" style="color:#fff;width:5%;">Costo</th>
                        <th scope="col" style="color:#fff;width:15%;">Porc. Inc.</th>
                        <th scope="col" style="color:#fff;width:5%;">Código</th>
                        <th scope="col" style="color:#fff;width:5%;">Tipo</th>
                        <th scope="col" style="color:#fff;width:30%;">Acciones</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                {{-- <div class="pagination justify-content-end">
                    {!! $Ofertas->links() !!}
                </div> --}}
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