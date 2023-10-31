@extends('layouts.app')
@section('content')
{{-- <style>
    /* ============ desktop view ============ */
@media all and (min-width: 992px) {
	.dropdown-menu li{ position: relative; 	}
	.nav-item .submenu{ 
		display: none;
		position: absolute;
		left:100%; top:-7px;
	}
	.nav-item .submenu-left{ 
		right:100%; left:auto;
	}
	.dropdown-menu > li:hover{ background-color: #f1f1f1 }
	.dropdown-menu > li:hover > .submenu{ display: block; }
}	
/* ============ desktop view .end// ============ */

/* ============ small devices ============ */
@media (max-width: 991px) {
  .dropdown-menu .dropdown-menu{
      margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
  }
}	
/* ============ small devices .end// ============ */
</style> --}}
<head><link rel="stylesheet" href="{{asset('css/ofeobra/presentar.css')}}">
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header d-flex">
        <div class="">
            <div class="titulo page__heading fs-5">Ver la oferta de obra n°: {{$data->idobra}}</div>
        </div>
        <div class="ms-auto">
            <div class="dropdown nav-item">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Informes <i class="fas fa-print" style="color: #ffffff;"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('ofeobraItemsGral.pdf', base64url_encode($data->idobra))}}" target="_blank">Cuadro A y E - General</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraItemsSubitems.pdf', base64url_encode($data->idobra))}}" target="_blank">Computo y presupuesto</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraItems.pdf', [base64url_encode($data->idobra), 2])}}" target="_blank">Cuadro A y E - Infraestructura</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraItems.pdf', [base64url_encode($data->idobra), 1])}}" target="_blank">Cuadro A y E - Vivienda</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraItems.pdf', [base64url_encode($data->idobra), 3])}}" target="_blank">Cuadro A y E - Nexo</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraIncItems.pdf', base64url_encode($data->idobra))}}" target="_blank">Incidencia de items</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraCrono.pdf', base64url_encode($data->idobra))}}" target="_blank">Plan de trabajo</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraDesmes.pdf', base64url_encode($data->idobra))}}" target="_blank">Cronograma de desembolso</a></li>
                  <li><a class="dropdown-item" href="{{route('ofeobraCurvaDes.pdf', base64url_encode($data->idobra))}}" target="_blank">Curva de inversiones</a></li>
                    {{-- <li><a class="dropdown-item" href="#"> Item General &raquo; </a>
                        <ul class="submenu submenu-left dropdown-menu">
                            <li><a class="dropdown-item" href="">Submenu item 1</a></li>
                            <li><a class="dropdown-item" href="">Submenu item 2</a></li>
                            <li><a class="dropdown-item" href="">Submenu item 3</a></li>
                            <li><a class="dropdown-item" href="">Submenu item 4</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div> 
        </div>
    </div>
    
    <div class="section-body">
        <div class="row">
            @include('layouts.modal.mensajes')

            @include('Obrasyfinan.Ofertas.layout.informacion_de_ofeobra')

            @include('Obrasyfinan.Ofertas.layout.items_de_ofeobra')

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Impuestos</h5></div>                        
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-hover mt-2">
                            <thead>
                                <th class= 'text-center' scope="col" style="color:#fff;width:35%;">Concepto</th>
                                <th class= 'text-center' scope="col" style="color:#fff;width:32%;">Total Vivienda</th>
                                <th class= 'text-center' scope="col" style="color:#fff;width:32%;">Total Infraestructura</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            Subtotal 1
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($data->tot1viv,2, ',', '.')}}
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($data->tot1inf,2, ',', '.')}}
                                        </strong>
                                    </td>
                                </tr>
                                
                                @php
                                    $flete = $sombreros->where('idconceptosombrero', '=', 10)->first()->valor ?? 0;
                                    $somfleteviv = $data->tot1viv * ($flete/100);
                                    $somfleteinfra = $data->tot1inf * ($flete/100);
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        Flete ( {{$flete}}% )
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        $ {{number_format($somfleteviv, 2, ',', '.')}}                                    
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        $ {{number_format($somfleteinfra, 2, ',', '.')}} 
                                    </td>
                                </tr>
                                @php
                                    $subtot2viv = $data->tot1viv + $somfleteviv;
                                    $subtot2infra = $data->tot1inf + $somfleteinfra;
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            Subtotal 2
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot2viv, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot2infra, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                </tr>
                                @php
                                    $gasto = $sombreros->where('idconceptosombrero', '=', 20)->first()->valor ?? 0;
                                    $somGastoviv = $subtot2viv * ($gasto/100);
                                    $somGastoinfra = $subtot2infra * ($gasto/100);
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        Gastos ( {{$gasto}}% )
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        $ {{number_format($somGastoviv, 2, ',', '.')}}
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        $ {{number_format($somGastoinfra, 2, ',', '.')}}
                                    </td>
                                </tr>
                                @php
                                    $subtot3viv = $subtot2viv + $somGastoviv;
                                    $subtot3infra = $subtot2infra + $somGastoinfra;
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            Subtotal 3
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot3viv, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot3infra, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                </tr>
                                @php
                                    $uti = $sombreros->where('idconceptosombrero', '=', 30)->first()->valor ?? 0;
                                    $somUtiviv = $subtot3viv * ($uti/100);
                                    $somUtiinfra = $subtot3infra * ($uti/100);
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        Utilidad ( {{$uti}}% )
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        $ {{number_format($somUtiviv, 2, ',', '.')}}
                                    </td>
                                    <td <td class= 'text-center' style="vertical-align: middle;">
                                        ${{number_format($somUtiinfra, 2, ',', '.')}}
                                    </td>
                                </tr>
                                @php
                                    $subtot4viv = $subtot3viv + $somUtiviv;
                                    $subtot4infra = $subtot3infra + $somUtiinfra;
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            Subtotal 4
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot4viv, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;">
                                        <strong>
                                            $ {{number_format($subtot4infra, 2, ',', '.')}}
                                        </strong>
                                    </td>
                                </tr>
                                @php
                                    $viv = $sombreros->where('idconceptosombrero', '=', 40)->first()->valor ?? 0;
                                    $infra = $sombreros->where('idconceptosombrero', '=', 50)->first()->valor ?? 0;
                                    $somViv = $subtot4viv * ($viv/100);
                                    $somInfra = $subtot4infra * ($infra/100);
                                @endphp
                                <tr>
                                    @if($viv != 0)
                                        @if ($infra != 0)
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                IVA + IIBR (Vivienda: {{$viv}}%, Infraestructura: {{$infra}}%)
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somViv, 2, ',', '.')}}
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somInfra, 2, ',', '.')}}
                                            </td>
                                        @else
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                IVA + IIBR (Vivienda: {{$viv}}%, Infraestructura: No existe)
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somViv, 2, ',', '.')}}
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somInfra=0, 2, ',', '.')}}
                                            </td>
                                        @endif
                                    @else
                                        @if ($infra != 0)
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                IVA + IIBR (Vivienda: No existe, Infraestructura: {{$infra}}%)
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somViv, 2, ',', '.')}}
                                            </td>    
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somInfra, 2, ',', '.')}}
                                            </td>
                                        @else
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                IVA + IIBR (Vivienda: No existe, Infraestructura: No existe)
                                            </td>
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somViv=0,2, ',', '.')}}
                                            </td>    
                                            <td class= 'text-center' style="vertical-align: middle;">
                                                $ {{number_format($somInfra=0,2, ',', '.')}}
                                            </td>
                                        @endif        
                                    @endif                     
                                </tr>
                                @php
                                    $subtot5viv = $subtot4viv + $somViv;
                                    $subtot5infra = $subtot4infra + $somInfra;
                                    $totalDef = $subtot5viv + $subtot5infra;
                                @endphp
                                <tr>
                                    <td class= 'text-center' style="vertical-align: middle;"><strong>Totales</strong></td>
                                    <td class= 'text-center' style="vertical-align: middle;"><strong>
                                        $ {{number_format($subtot5viv, 2, ',', '.')}}</strong>
                                    </td>
                                    <td class= 'text-center' style="vertical-align: middle;"><strong>
                                        $ {{number_format($subtot5infra, 2, ',', '.')}}</strong>
                                    </td>
                                </tr>
                            </tbody>     
                        </table>
                        <p class="text-center" style="font-size:18px;">
                            TOTAL:
                            <strong>
                                $ {{number_format($totalDef, 2, ',', '.')}}
                            </strong>
                        </p>                       
                       </div>
                    </div>
                </div>
            </div>

            @include('Obrasyfinan.Ofertas.layout.plandetrabajo_de_ofeobra')
            
            @include('Obrasyfinan.Ofertas.layout.cronodesem_de_ofeobra')

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <br>
                        <div class="text-center"><h5>Grafico de desembolso</h5></div>                        
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <a href="{{ route('ofeobra.index') }}"class="btn btn-primary fo">Volver</a>
                            </div>
                            <div class="col-11">
                                
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">

@include('layouts.modal.confirmation') 
@endsection

@section('js')
    <script src="{{ asset('js/Obrasyfinan/Ofertas/presentacion.js') }}"></script>

    <script>
        window.onload = function() {
            var to = document.getElementById("totalobr");
            total = {{$totalDef}};
            total.toFixed(2);
            to.value = '$' + ' ' + new Intl.NumberFormat('de-DE').format(total.toFixed(2));
        };
    </script>

    @include('Obrasyfinan.Ofertas.layout.graficodesem_de_ofeobra')
@endsection
