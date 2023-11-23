@extends('layouts.app')
@section('content')    
    <section class="section">
        <div class="section-header"><h3 class="page__heading">Alta Licitacion</h3></div> 
        @can('CREAR-OB_LIC')     
            <a class="btn btn-success float-right" href="{{route('ob_lic.crear')}}">Nuevo</a>
        @endcan
        <table id="tablaconceptos" style="width:100%;" class="table  table-striped mt-2 ">
            <thead style="height:50px;">
                <th scope="col" style="color:#fff;">Nro.</th>
                <th scope="col" style="color:#fff;width:60%;">Denominacion</th>
                <th scope="col" style="color:#fff;">Apertura</th>
                <th scope="col" style="color:#fff;">Año</th>
                <th scope="col" style="color:#fff;">Tipo</th>
                <th scope="col" style="color:#fff;width:30%;">Acciones</th>
            </thead>
            <tbody>
                @foreach($ob_licitacion as$unob_licitacion)
                    <tr>
                        <td>{{$unob_licitacion->numero}}</td>
                        <td>{{$unob_licitacion->denominacion}}</td>
                        <td>{{date("d/m/Y",strtotime($unob_licitacion->apertura))}}</td>                                                    
                        <td>{{$unob_licitacion->aÑo}}</td>
                        <td>{{$unob_licitacion->descripcion}}</td> 
                        @can('EDITAR-OB_LIC')                                                   
                            <td>
                                <a class="btn btn-dark" href="{{route('ob_lic.subir',['dir'=>$unob_licitacion->path])}}">Archivos</a>
                                <input type="text" class="visually-hidden" id="enlaceInput" value="https://www.iprodha.misiones.gov.ar/{{$unob_licitacion->path}}" />
                                <button onclick="copiarAlPortapapeles()">
                                    <img src="img/enlace.png" alt="Copiar" style="width:30px;height:20px;background-color:white;">
                                </button>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>                                
    </section>
@endsection
<script>
  function copiarAlPortapapeles() {
    /* Obtener el elemento de entrada de texto */
    var enlaceInput = document.getElementById("enlaceInput");

    /* Seleccionar el texto en el campo de entrada de texto */
    enlaceInput.select();
    enlaceInput.setSelectionRange(0, 99999); /* Para dispositivos móviles */

    /* Copiar el texto al portapapeles */
    document.execCommand("copy");

    /* Alerta de copiado */
    alert("Enlace copiado al portapapeles: " + enlaceInput.value);
  }
</script>