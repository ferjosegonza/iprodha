@extends('layouts.app')

@section('content')
    {{-- @include('layouts.modal.delete', ['modo' => 'Agregar']) --}}
    <section class="section">
        <div class="section-header">
            <h2 class="page__heading">Pagos X Obras</h2>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    @include('layouts.modal.mensajes')
                    <div class="card ">
                        <div class="card-body">
                            {!! Form::open([
                                'method' => 'GET',
                                'class' => '',
                                'route' => ['estadoobras.index'],
                                'style' => 'display:inline; height:37px',
                            ]) !!}
                            <div class="row g-3 justify-content-evenly align-items-center">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
                                    {!! Form::label('periodo', '', ['class' => 'col-form-label text-dark']) !!}
                                </div>
                                <div class="col-xs-4 col-sm-7 col-md-4 col-lg-2">
                                    {{-- Form::text('periodo', date('mY'), ['class' => 'form-control']) --}}
                                    {!! Form::month('periodo', \Carbon\Carbon::now(), [
                                        'min' => '2022-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'periodo',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                                <div class="col-auto ">
                                    {!! Form::button('Buscar', ['id' => 'buscar1', 'class' => 'btn btn-secondary']) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7  ">
                                    <div class="row justify-content-evenly align-items-center">
                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                                            {!! Form::select('empresa', [], null, [
                                                'placeholder' => 'Empresas',
                                                'style' => 'display:none',
                                                'id' => 'empresa',
                                                'class' => 'form-select  text-dark',
                                            ]) !!}
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 my-2 col-lg-4">
                                            {!! Form::select('programa', [], null, [
                                                'placeholder' => 'Programas',
                                                'style' => 'display:none',
                                                'id' => 'programa',
                                                'class' => 'form-select text-dark',
                                            ]) !!}
                                        </div>

                                        <div class='col-auto'>
                                            {!! Form::submit('Buscar', ['id' => 'buscar', 'class' => 'btn btn-secondary', 'style' => 'display:none']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (isset($estadoobras))
                                <div class="row  justify-content-between align-items-center">
                                    <div class="col-xs-12 col-sm-6 col-md-6  col-lg-4">
                                        <h3> {{ $periodoMostrar }}</h3>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 my-2  col-lg-4 ">
                                        <h5 class="text-end">Filtos : @php $x=0; @endphp
                                            @if (isset($empresa) && $empresa != 'Empresas')
                                                @php $x=1; @endphp
                                                Empresas
                                            @endif
                                            @if (isset($empresa) && $empresa != 'Empresas' && isset($programa) && $programa != 'Programas')
                                                -
                                            @endif
                                            @if (isset($programa) && $programa != 'Programas')
                                                @php $x=1; @endphp
                                                Programas
                                            @endif
                                            @if ($x == 0)
                                                @php $x=0; @endphp
                                                Ninguno
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                        <!-- Centramos la paginacion a la derecha -->
                                        <div class="pagination justify-content-end">
                                            {!! $estadoobras->onEachSide(0)->appends(['periodo' => $periodo, 'empresa' => $empresa, 'programa' => $programa])->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">

                                    <table id="example" class="table table-striped mt-2"style="width:100%;">
                                        <thead style="height:50px;">
                                            <th class='ml-3' style="width: 100px;color:#fff">Empresa</th>
                                            <th style="color:#fff;">Obra</th>
                                            <th style="width: 500px;color:#fff;">Denominacion</th>
                                            <th style="color:#fff;">Cert.</th>
                                            <th style="color:#fff;">Tot. Cert.</th>
                                            <th style="color:#fff;">Pendiente</th>
                                            <th style="color:#fff;">Programa</th>
                                            <th style="color:#fff;">Tipo</th>
                                            <th style="color:#fff;">Acciones</th>
                                        </thead>
                                        <tbody>

                                            @foreach ($estadoobras as $estadoobra)
                                                <tr>
                                                    <td class='pl-3'>{{ $estadoobra->nom_emp }}</td>
                                                    <td>{{ $estadoobra->num_obr }}</td>
                                                    <td>{{ $estadoobra->nom_obr }}</td>
                                                    <td>{{ $estadoobra->nro_cer_pag }}</td>
                                                    <td>${{ number_format($estadoobra->totcertif, 2) }}</td>

                                                    @if (isset($estadoobra->saldoapagar))
                                                        <td>${{ number_format($estadoobra->saldoapagar, 2) }}</td>
                                                    @else
                                                        <td style="color:rgb(243, 50, 50);"> <strong> Sin OP</strong>
                                                        </td>
                                                    @endif
                                                    <td>{{ $estadoobra->operatoria }}</td>
                                                    <td></td>

                                                    <td class="align-items-center justify-content-around">
                                                        {!! Form::button('Editar', ['class' => 'btn btn-primary']) !!}

                                                        {!! Form::button('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
    </section>
@endsection


@section('js')
<script src="{{ asset('js/Presidencia/estadoobras/index_estadoobras.js') }}"></script>
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
            });
            });
</script>
@endsection