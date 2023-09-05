<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
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
                    <div class="form-group column-2">
                        <label><b>Departamento: <b></label> 
                        <label>{{$obra->nom_obr}}</label>
                    </div>
                    <div class="form-group column-2">
                        <label><b>Municipio: <b></label> 
                        <label>{{$obra->nom_obr}}</label>
                    </div>
                </div>  
                <div class="row">         
                    <div class="form-group">
                        <label><b>Obra: <b></label> 
                        <label>{{$obra->nom_obr}}</label>
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
                    {{-- <div class="column-3 form-group">
                        <label><b>Tipo de Contrato: <b></label>
                        <label>{{$obra->getTipoOferta->tipocontratofer}}</label>
                    </div> --}}
                </div>
                <div class="row">                          
                    <div class="column-4 form-group">                        
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{$obra->publica}}</label>
                        </div>
                    {{-- <div class="column-3 form-group"> 
                        <label><b>Código de barra del expediente:<b></label>
                        <label>{{$obra->idexpediente}}</label> 
                    </div>                     --}}
                    <div class="column-3 form-group"> 
                        <label><b>Expediente Número:<b></label>
                        <label>{{$obra->expedte}}</label>
                    </div>
                </div>
                {{-- <div class="row">        
                    <div class="form-group">             
                        <label><b>Asunto del Expediente:<b></label>
                        <label>{{$obra->getExpediente->exp_asunto}}</label>
                    </div>
                </div> --}}
                
            </div>
        </div>
    </section>    
    
    <section style="margin-top: 10px">
        <div class="section-header">
            {{-- <h4 class="m-auto" >CURVA DE DESEMBOLSOS</h4> --}}
        </div>
        <div class="section-body">
            {{-- <img src="http://quickchart.io/chart?c={type:'bar',data:{labels:[2012,2013,2014,2015,2016],datasets:[{label:'Users',data:[120,60,50,180,120]}]}}"> --}}
            {{-- <img class= "logo column-2" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}"> --}}
            {{-- <img src="{{$chart}}"> --}}
        </div>
    </section> 
</body>
</html>