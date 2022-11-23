@extends('layouts.app')

@section('content')
    @include('layouts.modal.delete', ['modo' => 'Agregar'])
    <link rel="stylesheet" href="{{ asset('css/Presidencia/conceptofacturacion/conceptofacturacion.css') }}">
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Conceptos Facturacion</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col">
                    @include('layouts.modal.mensajes')

                    <div class="card col-sm-12 rounded">
                        <div class="card-body">
                            
                            <div class="row g-3 ">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                    <div class="row justify-content-evenly align-items-evenly">
                                        <div class="col-xs-2 col-sm-1 col-md-2 col-lg-1">
                                            @can('CREAR-CONCEPTOFACTURACION')
                                                {!! Form::open([
                                                    'method' => 'GET',
                                                    'route' => ['conceptofacturacion.create'],
                                                    'class' => 'd-flex justify-content-evenly',
                                                ]) !!}
                                                {!! Form::submit('Nuevo', ['class' => 'btn btn-warning my-1']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                                            {!! Form::open([
                                                'method' => 'GET',
                                                'class' => '',
                                                'route' => ['conceptofacturacion.index'],
                                            ]) !!}
                                            <div class="row justify-content-evenly align-items-center">
                                                <div
                                                    class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex justify-content-evenly">
                                                    {!! Form::text('name', null, ['placeholder' => 'Buscar', 'class' => 'form-control  ']) !!}
                                                </div>
                                                <div
                                                    class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex justify-content-evenly">
                                                    {!! Form::submit('Buscar', ['class' => 'btn btn-secondary  ']) !!}
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="pepe">
asda
                    </div>
                    <div class="card  rounded ">
                        <div class="card-body  ">
                            <div class="text-nowrap table-responsive">
                                <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
                                    <thead style="height:50px;">
                                        <tr>
                                            <th class='pl-3' style="color:#fff">Id-Concepto</th>
                                            <th style="color:#fff;">Concepto</th>
                                            <th style="color:#fff;">Monto</th>
                                            <th style="color:#fff;">Suma O Resta</th>
                                            <th style="color:#fff;">Nº Fila</th>
                                            <th style="color:#fff;">Nº Columna</th>
                                            <th style="color:#fff;">Fec. Baja</th>
                                            <th style="color:#fff;">Enx Adju</th>
                                            <th style="color:#fff;">CR</th>
                                            <th style="color:#fff;">BN</th>
                                            <th style="color:#fff;">MV</th>
                                            <th style="color:#fff;">CH</th>
                                            <th style="color:#fff;">Forma Cap</th>
                                            <th style="color:#fff;">PI</th>
                                            <th style="color:#fff;">Nota Credito</th>
                                            <th style="color:#fff;">Adel Cancela</th>
                                            <th style="color:#fff;">AH</th>
                                            <th style="color:#fff;">Forma Neta</th>
                                            <th style="color:#fff;">Enmascara</th>
                                            <th style="color:#fff;">Re Adju</th>
                                            <th style="color:#fff;">Entre Per.</th>
                                            <th style="color:#fff;">Mod NoUvi</th>
                                            <th style="color:#fff;">Mod Uvi</th>
                                            <th style="color:#fff;">Capital</th>
                                            <th style="color:#fff;">Deuda Cap</th>
                                            <th style="color:#fff;">Forma Pura</th>
                                            <th style="color:#fff;">AQ</th>
                                            <th style="color:#fff;">Recargo</th>
                                            <th style="color:#fff;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($conceptosfacturacion as $concepto)
                                            <tr>
                                                <td class='pl-3'>{{ $concepto->idconcepto }}</td>
                                                <td>{{ $concepto->concepto }}</td>
                                                <td>
                                                    @if ($concepto->monpor == '1')
                                                        $ Plata
                                                    @else
                                                        % Porcentaje
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($concepto->sumaoresta)
                                                        @case(-1)
                                                            - Resta
                                                        @break

                                                        @case(0)
                                                            No Su/No Re
                                                        @break

                                                        @case(1)
                                                            + Suma
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                                <td>{{ $concepto->nrofila }}</td>

                                                <td>{{ $concepto->nrocolumna }}</td>
                                                <td>{{ $concepto->fechabaja }}</td>
                                                <td>
                                                    @if ($concepto->va_enxadju == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_cr == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_bn == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_mv == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_ch == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->forma_cap == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_pi == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_notacre == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_adel_canc == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_ah == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->forma_neta == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->enmascara == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_readju_comun == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->ve_readju_entreper == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->modifica_nouvi == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->modifica_uvi == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->es_capital == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->es_deuda_cap == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->forma_pura == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->forma_aq == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($concepto->forma_recargo == '0')
                                                        No
                                                    @else
                                                        Si
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-around">
                                                        @can('EDITAR-CONCEPTOFACTURACION')
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'route' => ['conceptofacturacion.edit', $concepto->idconcepto],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Editar', ['class' => 'btn btn-primary mr-2']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                        @can('BORRAR-CONCEPTOFACTURACION')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['conceptofacturacion.destroy', $concepto->idconcepto],
                                                                'style' => 'display:inline',
                                                                'class' => 'formulario',
                                                            ]) !!}
                                                            {!! Form::submit('Borrar', ['onclick' => '', 'class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
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
            </div>
        </div>
    </section>
@endsection


@section('js')
<script src="{{ asset('js/Presidencia/conceptofacturacion/index_conceptofacturacion.js') }}"></script>
<script>
    $(document).ready(function () {
           $('#tablaconceptos').DataTable({
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
           });
           });
</script>
@endsection