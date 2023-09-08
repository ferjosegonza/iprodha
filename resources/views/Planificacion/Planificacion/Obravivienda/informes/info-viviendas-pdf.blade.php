<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/Obrasyfinan/informes.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion de las viviendas de la obra PDF</title>
</head>
<body style="">
    <header style="margin-left: 1cm;">
        <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}">
        <label class="txt column-2"><br>{{$texto[0]->texto_1}}</label>
    </header>
    <footer style="margin-left: 3cm">   
    </footer>

    <section class="section">
        <div class="section-header text-center">
            <h4 style="text-align: center;">LISTADO DE VIVIENDAS DE UNA OBRA</h4>            
        </div>
        <div class="section-body">
            <div class="section-border">    
                <div class="row">
                    <div class="form-group column-10">
                        <label><b>Numero: <b></label> 
                        <label>{{$obra->num_obr}}</label>
                    </div>
                    <div class="form-group">
                        <label><b>Obra: <b></label> 
                        <label>{{$obra->nom_obr}}</label>
                    </div>
                </div>  

                <div class="row">
                    <div class="form-group column-2">
                        <label><b>Etapa: <b></label> 
                        <label>{{$etapa->descripcion ?? '---'}}</label>
                    </div>
                    <div class="form-group column-2">
                        <label><b>Entrega: <b></label> 
                        <label>{{$entrega->descripcion ?? '---'}}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group column-3">
                        <label><b>Departamento: <b></label> 
                        <label>{{ $viviendas->first()->getMunicipio->getDepartamento->nom_dep ?? '---'}}</label>
                    </div>
                    <div class="form-group column-3">
                        <label><b>Municipio: <b></label> 
                        <label>{{ $viviendas->first()->getMunicipio->nom_municipio ?? '---'}}</label>
                    </div>
                    <div class="form-group column-3">
                        <label><b>Operatoria: <b></label> 
                        <label>{{$obra->getOperatoria->operat_adm}}</label>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    
    <section style="margin-top: 10px">
        <div class="section-header">
            {{-- <h4 class="m-auto" >CURVA DE DESEMBOLSOS</h4> --}}
        </div>
        <div class="section-body">
            <table class="table" style="table-layout:fixed; font-size:70%">
                <thead>
                    <tr>
                        <th colspan="2">GENERAL</th>
                        <th colspan="2">MENSURA</th>
                        <th colspan="4">DATOS CATASTRALES</th>
                        <th colspan="2">S/EMPRESA</th>
                        <th colspan="3" >DATOS MUNICIPALES</th>
                        <th colspan="2">SUPERFICIE (m2)</th>
                        <th colspan="4">PROPIEDAD HORIZONTAL</th>
                    </tr>
                    <tr>
                        <th class="width: 1%">ORDEN</th>
                        <th class="width: 1%">DISCAP</th>
                        <th class="width: 1%">PLANO</th>
                        <th class="width: 1%">PARTIDA</th>
                        <th class="width: 1%">SECCION</th>
                        <th class="width: 1%">CHACRA</th>
                        <th class="width: 1%">MANZANA</th>
                        <th class="width: 1%">PARCELA</th>
                        <th class="width: 1%">MANZANA</th>
                        <th class="width: 1%">LOTE</th>
                        <th class="width: 1%">FINCA</th>
                        <th style="width: 15%">CALLE</th>
                        <th class="width: 1%">NUMERO</th>
                        <th class="width: 1%">FINCA</th>
                        <th class="width: 1%">LOTE</th>
                        <th class="width: 1%">EDIFICIO</th>
                        <th class="width: 1%">ESCALERA</th>
                        <th class="width: 1%">PISO</th>
                        <th class="width: 1%">DEPTO</th>
                    </tr>          
                </thead>

                <tbody>
                    @foreach ($viviendas as $vivienda)
                        <tr>
                            <td class= 'text-center' style="vertical-align: middle;">{{$vivienda->orden}}</td>
                            @if ($vivienda->discap)
                                <td class= 'text-center' style="vertical-align: middle;">SI</td>
                            @else
                                <td class= 'text-center' style="vertical-align: middle;">NO</td>
                            @endif
                            <td style="vertical-align: middle;">{{$vivienda->plano}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->partida}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->seccion}}</td>
                            {{-- <td class= 'text-center' style="vertical-align: middle; font-size:80%">{{$vivienda->chacra}}</td> --}}
                            <td style="vertical-align: middle;">{{$vivienda->chacra}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->manzana}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->parcela}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->man_emp}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->lot_emp}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->finca}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->nom_cal}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->num_cal}}</td>
                            <td style="vertical-align: middle;">{{str_replace('.', ',', $vivienda->sup_fin)}}</td>
                            <td style="vertical-align: middle;">{{str_replace('.', ',', $vivienda->sup_lot)}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->edificio}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->escalera}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->piso}}</td>
                            <td style="vertical-align: middle;">{{$vivienda->departamento}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <img src="http://quickchart.io/chart?c={type:'bar',data:{labels:[2012,2013,2014,2015,2016],datasets:[{label:'Users',data:[120,60,50,180,120]}]}}"> --}}
            {{-- <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}"> --}}
            {{-- <img src="{{$chart}}"> --}}
        </div>
    </section> 
</body>
</html>