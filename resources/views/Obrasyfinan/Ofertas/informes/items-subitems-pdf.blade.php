<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/ofeobra/pdf.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Items y Sub-items PDF</title>
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
                    <div class="form-group column-2">
                        <label><b>Empresa:<b></label>
                        <label>{{$obra->getEmpresa->nom_emp}}</label>
                    </div>
                    <div class="form-group column-2">
                        <label><b>Expediente N°:<b></label>
                        <label>{{$obra->getExpediente->exp_numero ?? '-'}}</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group column-2">
                        <label><b>Localidad: <b></label>
                        <label>{{$obra->getLocalidad->nom_loc}}</label>  
                    </div>
                    <div class="form-group column-2">
                        <label><b>Fecha de publicación:<b></label>
                        <label>{{$obra->publica}}</label>
                    </div>
                </div>       
            </div>
        </div>
    </section>    
    
    <section style="margin-top: 10px">
        <div class="section-header">
            <h4 class="m-auto" >ITEMS Y SUB-ITEMS</h4>
        </div>
        <div class="section-body">
            <table class="table">
                <thead>
                    <th>Orden</th>
                    <th>Denominacion item</th>
                    <th>Denominacion sub-item</th>
                    <th>% Inc.</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Costo unitario</th>
                    <th>Costo subitem</th>
                    <th>Costo parcial</th>
                </thead>
                <tbody>
                    @php
                        $acuInc = 0;
                        $totalObra = 0;
                    @endphp
                    @foreach ($items->sortby('orden') as $item)
                        @php
                            $acuInc += $item->por_inc;
                            $totalObra = $totalObra + $item->costo;
                        @endphp
                        <tr>
                            <td>{{$item->orden}} </td>
                            <td>{{$item->nom_item}}</td>
                            <td></td>
                            <td>{{number_format($item->por_inc, 4, ',', '.')}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>${{number_format($item->costo, 2, ',', '.')}}</td>
                        </tr> 
                        @foreach ($item->getSubItems as $subitem)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$subitem->denominacion}}</td>
                                <td></td>
                                <td>{{$subitem->getUnidad->unidad}}</td>
                                <td>{{str_replace('.', ',', $subitem->cantidad)}}</td>
                                <td>${{number_format($subitem->costounitario,2, ',', '.')}}</td>
                                @php
                                    $costosubitm = 0;
                                    $costosubitm = $subitem->costounitario * $subitem->cantidad;
                                @endphp
                                <td>${{number_format($costosubitm, 2, ',', '.')}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr style="background-color: rgb(141, 141, 141)">
                            <td style="color: rgb(141, 141, 141)">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                        <tr style="">
                            <td></td>
                            <td></td>
                            <td>Total:</td>
                            <td>
                                {{number_format($acuInc,4, ',', '.')}}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>${{number_format($totalObra, 2, ',', '.')}}</td>
                        </tr>   
                </tbody>
            </table>
        </div>
    </section> 
</body>
</html>