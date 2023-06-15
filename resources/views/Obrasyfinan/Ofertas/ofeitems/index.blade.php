@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header d-flex">
            <div class="">
                <div class="titulo page__heading py-1">Items de la obra: {{$laObra->nomobra}}</div>
            </div>
            <div class="ms-auto">
                @if ($laObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)  
                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' =>['ofeobraitems.crear',$laObra]]) !!}
                    {!! Form::submit('Crear Item', ['class' => 'btn  btn-success mt-2 ']) !!}
                    {!! Form::close() !!}
                @endif
            </div>   
        </div>
        <div class="section-body">
            <div class="row">
                @include('layouts.modal.mensajes')
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Centramos la paginacion a la derecha -->
                            {{-- <div class="pagination justify-content-end">
                                {!! $Tickets->links() !!}   
                            </div> --}}
                            <div class="table-responsive">
                                <table id="example" class="table table-hover mt-2">
                                    <thead>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Orden</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Código</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Tipo</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:30%;">Denom.Item</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:5%;">Costo</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:15%;">Porc. Inc.</th>
                                        <th class="text-center" scope="col" style="color:#fff;width:30%;">Acciones</th>
                                    </thead>
                                    <tfoot align="right" style=''>
                                        <tr> <th></th> <th></th> <th></th> <th></th> <th class='text-center'></th> <th class='text-center'></th> <th></th></tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $inciTotal = 0;
                                        @endphp
                                        @foreach ($itemsxobra->sortBy('orden') as $unItem)
                                            <tr>
                                                <td class= 'text-center'>{{ $unItem->orden }}</td>
                                                <td class= 'text-center'>{{ $unItem->codigo }}</td>
                                                {{-- <td class= 'text-center'>{{ $unItem->cod_tipo }} --}}
                                                @switch($unItem->cod_tipo)
                                                    @case(1)
                                                        <td class="text-center">VIVIENDA</td>
                                                        @break
                                                    @case(2)
                                                        <td class="text-center">INFRAESTRUCTURA</td>
                                                        @break
                                                    @case(3)
                                                        <td class="text-center">NEXO</td>
                                                        @break
                                                        
                                                @endswitch
                                                {{-- </td> --}}
                                                <td class= 'text-center'>{{ substr($unItem->nom_item, 0, 35) }}</td>                                
                                                <td class= 'text-center'>@money($unItem->costo)</td>
                                                <td class= 'text-center'>{{number_format($unItem->por_inc, 4, ',', '.') }}</td>
                                                <td class= 'text-center'>
                                                    @if ($laObra->getEstados->sortByDesc('actual')->first()->getEstado->idestado < 2)
                                                        {!! Form::open(['method' => 'GET','route' => ['ofeobraitems.edit', base64url_encode($unItem->iditem)],'style' => 'display:inline',]) !!}
                                                        {!! Form::submit('Editar', ['class' => 'btn btn-warning']) !!}
                                                        {!! Form::close() !!}   
                
                                                        {!! Form::open([
                                                        'method' => 'DELETE','route' => ['ofeobraitems.eliminar',$unItem->iditem],'style' => 'display:inline',]) !!}
                                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger','onclick' => "return confirm('¿Está seguro que desea ELIMINAR el item?')",]) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                
                                                    {!! Form::open(['method' => 'GET', 'class' => '', 'route' => ['ofeobraitemdet.detalleitem', base64url_encode($unItem->iditem)],'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Sub Items', ['class' => 'btn btn-primary']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                            @php
                                            $inciTotal += $unItem->por_inc;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                    {!! Form::open(['method' => 'GET', 'route' => ['ofeobra.index'], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Volver', ['class' => 'btn btn-primary mt-2']) !!}
                    {!! Form::close() !!}                    
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        let totalDeInci = {{$inciTotal}}
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
                "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
   
              // converting to interger to find total
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
   
              // computing column Total of the complete result 
              var monTotal = api
                  .column( 1 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
          var tueTotal = api
                  .column( 2 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
              var wedTotal = api
                  .column( 3 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
           var thuTotal = api
                  .column( 4 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
                  
           var importeTotal = api
                  .column( 5 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );

          var costoTotal = api
                  .column( 6 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
              
                  
              // Update footer by showing the total with the reference of the column index 
          $( api.column( 0 ).footer() ).html('Totales');
            //   $( api.column( 1 ).footer() ).html(monTotal.toFixed(4));
            //   $( api.column( 2 ).footer() ).html(tueTotal);
              // $( api.column( 3 ).footer() ).html(wedTotal);
              $( api.column( 4 ).footer() ).html(new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(thuTotal.toFixed(2)));
              $( api.column( 5 ).footer() ).html(totalDeInci);
            //   $( api.column( 6 ).footer() ).html(costoTotal.toFixed(8));
          },
            });
            });
    </script>
@endsection