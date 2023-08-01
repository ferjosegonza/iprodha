<?php

namespace App\Http\Controllers\Coordinacion\RRHH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Personal\Agente;
use App\Models\Personal\Camxagente;
use App\Models\Personal\Historial;
use App\Models\Personal\Historial_Archivo;
use App\Models\Iprodha\Dig_subtipoarchivo;
use DB;

class NovedadesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function novedades(){        
        return view('rrhh.novedades');
    }

    public function crear_novedad(Request $request, $id){
        $agente = Agente::where('idagente', '=', $id)->first();
        $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
        $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
        return view('rrhh.crear_novedad')
        ->with('tipos',$TipoDocumento)
        ->with('subtipos',$SubTipoDocumento)
        ->with('agente', $agente);
    }

    public function guardarNovedad(Request $request){
        $historial = new Historial;
        $historial->idagente = $request->id;
        $historial->fecha = $request->fecha;
        $historial->detalle = $request->detalle;
        $historial->observacion = $request->observacion;
        $query = "SELECT COUNT(FECHA) as c FROM PERSONAL.HISTORIAL WHERE IDAGENTE = $request->id AND fecha = '$request->fecha'";
        $orden = DB::select( DB::raw($query));
        $historial->orden = $orden[0]->c;
        $query = "SELECT MAX(idhistorial) as id FROM PERSONAL.HISTORIAL";
        $id = DB::select( DB::raw($query));
        if(sizeof($id) == 0){
            $historial->idhistorial = 0;
        }
        else{
            $historial->idhistorial = $id[0]->id + 1;
        }        
        $historial->save();

        if($request->avalatorios != null){
            for($i = 0; $i<sizeof($request->avalatorios); $i++){
            $archivo = new Historial_Archivo;
            $archivo->idhistorial = $historial->idhistorial;
            $archivo->idarchivo = $request->avalatorios[$i];
            $archivo->save();
            }
        }
       

        return $historial->idhistorial;
    }

    public function getAvalatorios(Request $request){
        $query = "select idhistorial, idarchivo, nro_archivo, t.nombre_corto as tipo, s.dessubtipoarchivo as subtipo  from PERSONAL.HISTORIAL_archivo
        left join iprodha.dig_archivos i on idarchivo = i.id_archivo 
        left join iprodha.dig_tipoarchivo t on (i.id_tipoarchivo = t.id_tipoarchivo)
        and (i.id_tipocabecera = t.id_tipocabecera)
        left join iprodha.dig_subtipoarchivo s on (i.id_subtipoarchivo = s.id_subtipoarchivo) 
        and (s.id_tipoarchivo = t.id_tipoarchivo)
        and (i.id_tipocabecera = s.id_tipocabecera)
        where idhistorial = $request->id";
        $avalatorios = DB::select( DB::raw($query));
        return response()->json($avalatorios);
    }

    public function modificarNovedad(Request $request){
        $res = 1;
        $historial = Historial::find($request->idhistorial);
        if($historial->detalle != $request->detalle){            
            $detalle = Camxagente::asentarNovedadDetalle($historial->detalle, $request->detalle, $request->idagente);
            $res *= $detalle->save();
            $historial->detalle = $request->detalle;
            //asentar cambio
        }
        if(date("d-m-Y",strtotime($historial->fecha)) != date("d-m-Y",strtotime($request->fecha))){
            $detalle = Camxagente::asentarNovedadFecha($historial->fecha, $request->fecha, $request->idagente);
            $res *= $detalle->save();
            $historial->fecha = $request->fecha;
        }
        if($historial->observacion != $request->observacion){
            $detalle = Camxagente::asentarNovedadOBS($historial->observacion, $request->observacion, $request->idagente);
            $res *= $detalle->save();
            $historial->observacion = $request->observacion;
            //asentar cambio
        }            
        $res *= $historial->save();

        $avalatorios=Historial_Archivo::where('idhistorial', '=', $historial->idhistorial)->get();
        $array=$request->avalatorios;
        
       
       
        if(sizeof($avalatorios) > 0){
            $auxviejo = 'Ids de archivos: ';
            for($i=0; $i<sizeof($avalatorios); $i++){
                $auxviejo =  $auxviejo . $avalatorios[$i]->idarchivo .' ';
            }
        }
        else{
            $auxviejo = 'No hay archivos.';
        }
           
        
        $band2=1;
        if($array != null){     
            $auxnuevo= 'Ids de archivos: ';
            for($i=0; $i<sizeof($array); $i++){
                $auxnuevo = $auxnuevo . $array[$i] .' ';
            }         
            for($i = 0; $i<sizeof($avalatorios); $i++){
                $band=0;                              
                for($j=sizeof($array); $j>0; $j--){                      
                    if($avalatorios[$i]->idarchivo == $array[$j-1]){                        
                        $band=1;
                        unset($array[$j-1]);
                        $array = array_values($array);
                      // return($array);
                    }
                } 
                if($band==0){
                    $band2=0;
                    $detalle = Camxagente::asentarArchivos($auxviejo, $auxnuevo, $request->idagente);
                    $res *= $detalle->save();
                    $res *=$avalatorios[$i]->delete();
                } 
            }
           
            for($i=0; $i < sizeof($array); $i++){ 
                //return $array;
                if($band2==1){
                    $detalle = Camxagente::asentarArchivos($auxviejo, $auxnuevo, $request->idagente);
                    $res *= $detalle->save();
                }
                $his_ar = new Historial_Archivo;
                $his_ar->idhistorial = $request->idhistorial;
                $his_ar->idarchivo = $array[$i];
                $res *=$his_ar->save();
            }
        }
        else{
            $auxnuevo= 'No hay archivos';
            if($avalatorios != null){
                $detalle = Camxagente::asentarArchivos($auxviejo, $auxnuevo, $request->idagente);
                $res *= $detalle->save();
                for($i = 0; $i<sizeof($avalatorios); $i++){                    
                    $res *= $avalatorios[$i]->delete();
                }
            }
        }

        return $res;
    }

    public function borrarNovedad(Request $request){
        $historial = Historial::find($request->idhistorial);
        $avalatorios=Historial_Archivo::where('idhistorial', '=', $historial->idhistorial)->get();
        $res = 1;
        if($avalatorios != null){
            for($i = 0; $i<sizeof($avalatorios); $i++){                    
                $res *= $avalatorios[$i]->delete();
            }
        }
        $res *= $historial->delete();
        return $res;
    }
}


