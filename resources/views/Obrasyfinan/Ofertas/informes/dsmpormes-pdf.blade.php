<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Desembolsos por mes PDF</title>
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
            <h4 style="">INSTITUTO PROVISIONAL DE DESARROLLO HABITACIONAL</h4>            
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
                    <div class="column-2 form-group">
                        <label><b>Empresa:<b></label>
                        <label>{{$obra->getEmpresa->nom_emp}}</label>
                    </div>
                    <div class="column-2 form-group">
                        <label><b>Localidad: <b></label>
                        <label>{{$obra->getLocalidad->nom_loc}}</label>                    
                    </div>   
                    
                    {{-- <div class="column-3 form-group">
                        <label><b>Tipo de Contrato: <b></label>
                        <label>{{$obra->getTipoOferta->tipocontratofer}}</label>
                    </div> --}}
                </div>
                <div class="row">                          
                    <div class="column-2 form-group">                        
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{$obra->publica}}</label>
                        </div>
                    {{-- <div class="column-3 form-group"> 
                        <label><b>Código de barra del expediente:<b></label>
                        <label>{{$obra->idexpediente}}</label> 
                    </div>                     --}}
                    <div class="column-2 form-group"> 
                        <label><b>Expediente Número:<b></label>
                        <label>{{$obra->getExpediente->exp_numero ?? '-'}}</label>
                    </div>
                </div>
                {{-- <div class="row">        
                    <div class="form-group">             
                        <label><b>Asunto del Expediente:<b></label>
                        <label>{{$obra->getExpediente->exp_asunto}}</label>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="column-4 form-group"> 
                        <label><b>Vivienda:<b></label><br>
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
    
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto" >CRONOGRAMA DE DESEMBOLSOS</h4>
        </div>
        <div class="section-body">
            <table class="table">
                <thead>
                    <th>Mes</th>
                    <th>Montos mensuales</th>
                    <th>Montos acumulados</th>
                </thead>
                <tbody>
                    @php
                        $totalAcu = 0;
                    @endphp

                    @foreach ($desembolsos as $desembolso)
                        @php
                            $totalAcu += $desembolso->costo;
                        @endphp
                        <tr>
                            <td>MES {{$desembolso->mes}} </td>
                            <td>$ {{number_format($desembolso->costo, 2, ',', '.')}}</td>
                            <td>$ {{number_format($totalAcu, 2, ',', '.')}}</td>
                        </tr> 
                    @endforeach  
                       
                </tbody>
            </table>
        </div>
    </section> 
</body>
</html>