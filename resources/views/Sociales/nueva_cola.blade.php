@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/sociales/nueva_cola.css')}}">
    <script src="{{ asset('js/Sociales/nueva_cola.js') }}"></script>
</head>
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Cola</h3>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-12">
                    <label for="tramite" class="control-label">Trámite</label>
                    <select class="form-select" id="tramite" name="tramite">
                        @foreach ($tramites as $tramite)                           
                            <option value="{{$tramite->idtramite}}">{{$tramite->denominacion}}</option>
                        @endforeach                        
                    </select>   
                    <hr>
                </div>
                <div class="col-lg-8">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                </div>       
                <div class="col-lg-2">
                    <label for="puestos" class="control-label">Cantidad de Puestos</label>
                    <input type="number" min="1" name="puestos" id="puestos" class="form-control">
                </div>                
                <div class="col-lg-2">
                    <label for="duracion" class="control-label">Duración de turno (min)</label>
                    <input type="number" min="1" name="duracion" id="duracion" class="form-control">
                </div>       
                <div class="col-lg-6">
                    <label for="desde" class="control-label">Desde</label>
                    <input type="date" name="desde" id="desde" class = 'form-control'>
                </div>
                <div class="col-lg-6">
                    <label for="hasta" class="control-label">Hasta</label>
                    <input type="date" name="hasta" id="hasta" class = 'form-control'>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <h5>Horarios:</h5>
                    <table id="horarios" style="width: 50%">
                        <thead>
                            <th>Dia</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Disponible</th>
                        </thead>
                        <tr>
                            <td>Lunes</td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="lunes_inicio_hora" value="8">
                                    </div>
                                    <p class="col-lg-1 dosPuntos">:</p>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="lunes_inicio_min" value="00">
                                    </div>
                                </div>
                            </td>
                            <td><div class="row">
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="lunes_fin_hora" value="13">
                                </div>
                                <p class="col-lg-1 dosPuntos">:</p>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="lunes_fin_min" value="00">
                                </div>
                            </div></td>
                            <td>
                                <div class="form-check" style="display: flex;">
                                <input type="checkbox" class="form-check-input" id="checkLunes" checked>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Martes</td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="martes_inicio_hora" value="8">
                                    </div>
                                    <p class="col-lg-1 dosPuntos">:</p>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="martes_inicio_min" value="00">
                                    </div>
                                </div>
                            </td>
                            <td><div class="row">
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="martes_fin_hora" value="13">
                                </div>
                                <p class="col-lg-1 dosPuntos">:</p>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="martes_fin_min" value="00">
                                </div>
                            </div></td>
                            <td>
                                <div class="form-check" style="display: flex;">
                                <input type="checkbox" class="form-check-input" id="checkMartes" checked>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Miercoles</td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="miercoles_inicio_hora" value="8">
                                    </div>
                                    <p class="col-lg-1 dosPuntos">:</p>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="miercoles_inicio_min" value="00">
                                    </div>
                                </div>
                            </td>
                            <td><div class="row">
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="miercoles_fin_hora" value="13">
                                </div>
                                <p class="col-lg-1 dosPuntos">:</p>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="miercoles_fin_min" value="00">
                                </div>
                            </div></td>
                            <td>
                                <div class="form-check" style="display: flex;">
                                <input type="checkbox" class="form-check-input" id="checkMiercoles" checked>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Jueves</td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="jueves_inicio_hora" value="8">
                                    </div>
                                    <p class="col-lg-1 dosPuntos">:</p>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="jueves_inicio_min" value="00">
                                    </div>
                                </div>
                            </td>
                            <td><div class="row">
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="jueves_fin_hora" value="13">
                                </div>
                                <p class="col-lg-1 dosPuntos">:</p>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="jueves_fin_min" value="00">
                                </div>
                            </div></td>
                            <td>
                                <div class="form-check" style="display: flex;">
                                <input type="checkbox" class="form-check-input" id="checkJueves" checked>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Viernes</td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="viernes_inicio_hora" value="8">
                                    </div>
                                    <p class="col-lg-1 dosPuntos">:</p>
                                    <div class="col-lg-5">
                                        <input class="form-control" type="number" id="viernes_inicio_min" value="00">
                                    </div>
                                </div>
                            </td>
                            <td><div class="row">
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="viernes_fin_hora" value="13">
                                </div>
                                <p class="col-lg-1 dosPuntos">:</p>
                                <div class="col-lg-5">
                                    <input class="form-control" type="number" id="viernes_fin_min" value="00">
                                </div>
                            </div></td>
                            <td>
                                <div class="form-check" style="display: flex;">
                                <input type="checkbox" class="form-check-input" id="checkViernes" checked>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-12 btnCenter">
                    <button class="btn btn-outline-success" disabled id="guardar" onclick="guardar()">Guardar</button>
                    <a href="turnos"><button class="btn btn-outline-secondary">Cancelar</button></a> 
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="popTitulo"></h5>
          <a href="turnos" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></a>
        </div>
        <div class="modal-body" id="popBody">
        </div>
        <div class="modal-footer">
          <a href="turnos" type="button" class="btn btn-secondary">Ok</a>
        </div>
      </div>
    </div>
</div>
@include('layouts.favorito.editar', ['modo' => 'Agregar'])
@include('layouts.modal.confirmation') 
@endsection
