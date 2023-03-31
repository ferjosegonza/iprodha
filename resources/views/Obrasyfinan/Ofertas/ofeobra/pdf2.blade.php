<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Obra PDF</title>
</head>
<body style="margin-left: 3cm">
    <header style="margin-left: 1cm;">
        <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}">
        <label class="txt column-2"><br>{{$texto[0]->texto_1}}</label>
    </header>
    <footer style="margin-left: 3cm">   
    </footer>
    <section class="section">
        <div class="section-header">
            <h2 style="margin-top: 3cm">Información de la obra</h2>            
        </div>
        <div class="section-body">
            <div class="section-border">      
                <div class="row">         
                    <div class="form-group">
                        <label><b>Obra: <b></label> 
                        <label>{{$obra->nomobra}}</label>
                    </div>             
                </div>
                <div class="row">
                    <div class="column-3 form-group">
                        <label><b>Localidad: <b></label>
                        <label>{{$obra->getLocalidad->nom_loc}}</label>                    
                    </div>   
                    <div class="column-3 form-group">
                    <label><b>Empresa:<b></label>
                    <label>{{$obra->getEmpresa->nom_emp}}</label>
                    </div>
                    <div class="column-3 form-group">
                        <label><b>Tipo de Contrato: <b></label>
                        <label>{{$obra->getTipoOferta->tipocontratofer}}</label>
                    </div>
                </div>
                <div class="row">                          
                    <div class="column-3 form-group">                        
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{$obra->publica}}</label>
                        </div>
                    <div class="column-3 form-group"> 
                        <label><b>Código de barra del expediente:<b></label>
                        <label>{{$obra->idexpediente}}</label> 
                    </div>                    
                    <div class="column-3 form-group"> 
                        <label><b>Expediente Número:<b></label>
                        <label>{{$obra->getExpediente->exp_numero}}</label>
                    </div>
                </div>
                <div class="row">        
                    <div class="form-group">             
                        <label><b>Asunto del Expediente:<b></label>
                        <label>{{$obra->getExpediente->exp_asunto}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="column-4 form-group"> 
                        <label><b>Vivienta:<b></label><br>
                        <label>${{number_format($obra->monviv,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Infraestructura:<b></label><br>
                        <label>${{number_format($obra->moninf,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Nexo:<b></label><br>
                        <label>${{number_format($obra->monnex,2, ',', '.')}}</label>
                    </div>
                    <div class="column-4 form-group"> 
                        <label><b>Monto Tope:<b></label><br>
                        <label>${{number_format($obra->montotope,2, ',', '.')}}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="column-2 form-group"> 
                    <label><b>Plazo:<b></label>
                    <label>{{$obra->plazo}}</label>
                    </div>
                    <div class="column-2 form-group"> 
                    <label><b>Año Y Mes De Cotización:<b></label>
                    <label>{{$obra->aniocotizacion. '-' .$obra->mescotizacion}}</label>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    
    <section style="margin-top: 60px">
        <div class="section-header"><h2>Sombrero</h2></div>
        <div class="section-body">
            <table class="table">
                <thead>
                    <th></th>
                    <th>Total Vivienda</th>
                    <th>Total Infraestructura</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Subtotal 1</td>
                        <td>${{number_format($data->tot1viv,2, ',', '.')}}</td>
                        <td>${{number_format($data->tot1inf,2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td>Flete ({{$sombreros->where('idconceptosombrero', 10)->first()->valor}}%)</td>
                        <td>
                            ${{number_format($fleteviv=$data->tot1viv * (($sombreros->where('idconceptosombrero', '=', 10)->first()->valor)/100),2, ',', '.')}}                                    
                        </td>
                        <td>
                            ${{number_format($fleteinf=$data->tot1inf * (($sombreros->where('idconceptosombrero', '=', 10)->first()->valor)/100),2, ',', '.')}} 
                        </td>
                    </tr>
                     <tr>
                        <td>Subtotal 2</td>
                        <td>
                            ${{number_format($tot2viv=$data->tot1viv + $fleteviv,2, ',', '.')}}
                        </td>
                        <td>
                            ${{number_format($tot2inf=$data->tot1inf + $fleteinf,2, ',', '.')}}
                        </td>
                    </tr> 
                    <tr>
                        <td>Gastos ({{$sombreros->where('idconceptosombrero', '=', 20)->first()->valor}}%)</td>
                        <td>
                            ${{number_format($gastosviv=$tot2viv * (($sombreros->where('idconceptosombrero', '=', 20)->first()->valor)/100),2, ',', '.')}}
                        </td>
                        <td>
                            ${{number_format($gastosinf=$tot2inf * (($sombreros->where('idconceptosombrero', '=', 20)->first()->valor)/100),2, ',', '.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Subtotal 3</td>
                        <td>
                            ${{number_format($tot3viv = $tot2viv + $gastosviv,2, ',', '.')}}
                        </td>
                        <td>
                            ${{number_format($tot3inf = $tot2inf + $gastosinf,2, ',', '.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Utilidad ({{$sombreros->where('idconceptosombrero', '=', 30)->first()->valor}}%)</td>
                        <td>
                            ${{number_format($utiviv=$tot3viv * (($sombreros->where('idconceptosombrero', '=', 30)->first()->valor)/100),2, ',', '.')}}
                        </td>
                        <td>
                            ${{number_format($utiinf=$tot3inf * (($sombreros->where('idconceptosombrero', '=', 30)->first()->valor)/100),2, ',', '.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Subtotal 4</td>
                        <td>
                            ${{number_format($tot4viv = $tot3viv + $utiviv),2, ',', '.'}}
                        </td>
                        <td>
                            ${{number_format($tot4inf = $tot3inf + $utiinf),2, ',', '.'}}
                        </td>
                    </tr>
                    <tr>
                        @if($sombreros->where('idconceptosombrero', '=', 40)->first() != null)
                            @if ($sombreros->where('idconceptosombrero', '=', 50)->first() != null)
                            <td>IVA + IIBR (Vivienda: {{$sombreros->where('idconceptosombrero', '=', 40)->first()->valor}}%, Infraestructura: {{$sombreros->where('idconceptosombrero', '=', 50)->first()->valor}}%)</td>
                            <td>${{number_format($ivaviv=$tot4viv * (($sombreros->where('idconceptosombrero', '=', 40)->first()->valor)/100),2, ',', '.')}}</td>
                            <td>${{number_format($ivainf=$tot4inf * (($sombreros->where('idconceptosombrero', '=', 50)->first()->valor)/100),2, ',', '.')}}</td>
                            @else
                            <td>IVA + IIBR (Vivienda: {{$sombreros->where('idconceptosombrero', '=', 40)->first()->valor}}%, Infraestructura: No existe)</td>
                            <td>${{number_format($ivaviv=$tot4viv * (($sombreros->where('idconceptosombrero', '=', 40)->first()->valor)/100),2, ',', '.')}}</td>
                            <td>${{number_format($ivainf=0,2, ',', '.')}}</td>
                            @endif
                        @else
                            @if ($sombreros->where('idconceptosombrero', '=', 50)->first() != null)
                            <td>IVA + IIBR (Vivienda: No existe, Infraestructura: {{$sombreros->where('idconceptosombrero', '=', 50)->first()->valor}}%)</td>
                            <td>${{number_format($ivaviv=0,2, ',', '.')}}</td>    
                            <td>${{number_format($ivainf=$tot4inf * (($sombreros->where('idconceptosombrero', '=', 50)->first()->valor)/100),2, ',', '.')}}</td>
                            @else
                                <td>IVA + IIBR (Vivienda: No existe, Infraestructura: No existe)</td>
                                <td>${{number_format($ivaviv=0,2, ',', '.')}}</td>    
                                <td>${{number_format($ivainf=0,2, ',', '.')}}</td>
                            @endif        
                        @endif                     
                    </tr>
                    <tr>
                        <td>Totales</td>
                        <td>
                            ${{number_format($tot5viv = $tot4viv + $ivaviv,2, ',', '.')}}
                        </td>
                        <td>
                            ${{number_format($tot5inf = $tot4inf + $ivainf,2, ',', '.')}}
                        </td>
                    </tr>                    
                </tbody>
            </table>
            <table class="table"><th>TOTAL: ${{number_format($total=$tot5viv + $tot5inf,2, ',', '.')}}</th> </table>
        </div>
    </section>    
</body>
</html>