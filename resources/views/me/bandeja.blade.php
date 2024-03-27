@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Bandeja</h3></div> 
        <style>.tab-content{display:none;}</style>       
        <div class="card-body">@include('layouts.modal.mensajes')</div>
        @csrf
        @method('POST')
        <div class="tabs">
            <button class="tablinks" onclick="openTab(event,'tab1')">Exptes</button>
            <button class="tablinks" onclick="openTab(event,'tab2')">Notas</button>
            <button class="tablinks" onclick="openTab(event,'tab3')">Correspondencia</button>
            <button class="tablinks" onclick="openTab(event,'tab4')">Convenio</button>
        </div>
        <br>
        <table>
            <thead>
                <th scope="col" style="color:#fff;width:202px;">Numero</th>            
                <th scope="col" style="color:#fff;width:806px;">Asunto</th>
                <th scope="col" style="color:#fff;width:202px;">Fecha</th>
            </thead>
        </table>
        <div id="tab1" class="tab-content" style="height:300px;overflow-y:scroll;">
            <table id="tablaconceptos" style="width:100%" class="table  table-striped mt-2 ">                
                <tbody>
                    @foreach($exptes as$unExptes)
                        <tr>                            
                            <td style="width:202px;">{{$unExptes->numero}}</td>                        
                            <td style="width:806px;">{{$unExptes->asunto}}</td>
                            <td style="width:202px;">{{$unExptes->mov_fecha}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>   
        </div> 
        <div id="tab2" class="tab-content" style="height:300px;overflow-y:scroll;">
            <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">                
                <tbody>
                    @foreach($notas as$unNotas)
                        <tr>                            
                            <td style="width:202px;">{{$unNotas->numero}}</td>                        
                            <td style="width:806px;">{{$unNotas->asunto}}</td>
                            <td style="width:202px;">{{$unNotas->mov_fecha}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>   
        </div>
        <div id="tab3" class="tab-content" style="height:300px;overflow-y:scroll;">
            <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">                
                <tbody>
                    @foreach($correspondencias as$unCorrespondencias)
                        <tr>                            
                            <td style="width:202px;">{{$unCorrespondencias->numero}}</td>                        
                            <td style="width:606px;">{{$unCorrespondencias->asunto}}</td>
                            <td style="width:202px;">{{$unCorrespondencias->mov_fecha}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>   
        <div id="tab4" class="tab-content" style="height:300px;overflow-y:scroll;">
            <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">                
                <tbody>
                    @foreach($convenios as$unConvenios)
                        <tr>                            
                            <td style="width:202px;">{{$unConvenios->numero}}</td>                        
                            <td style="width:806px;">{{$unConvenios->asunto}}</td>
                            <td style="width:202px;">{{$unConvenios->mov_fecha}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>  
    </section>
@endsection  
<script>
    function openTab(evt,tabName){
        // Ocultar todos los contenidos de las pestañas
        var tabcontents=document.getElementsByClassName("tab-content");
        for(var i=0;i<tabcontents.length;i++){tabcontents[i].style.display="none";}
        // Mostrar el contenido de la pestaña seleccionada
        document.getElementById(tabName).style.display="block";
    }
</script>          