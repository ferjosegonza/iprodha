<?php

namespace App\Http\Controllers\Coordinacion\RRHH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Personal\Agente;
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
        $historial = Historial::find($request->idhistorial);
        $historial->detalle = $request->detalle;
        $historial->fecha = $request->fecha;
        $historial->observacion = $request->observacion;
        $res = 1;
        $res *= $historial->save();

        $avalatorios=Historial_Archivo::where('idhistorial', '=', $historial->idhistorial)->get();
        $array=$request->avalatorios;
        
      

        if($array != null){             
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
                    $res *=$avalatorios[$i]->delete();
                } 
            }
           
            for($i=0; $i < sizeof($array); $i++){ 
                //return $array;
                $his_ar = new Historial_Archivo;
                $his_ar->idhistorial = $request->idhistorial;
                $his_ar->idarchivo = $array[$i];
                $res *=$his_ar->save();
            }
        }
        else{
            if($avalatorios != null){
                for($i = 0; $i<sizeof($avalatorios); $i++){                    
                    $res *= $avalatorios[$i]->delete();
                }
            }
        }

        return $res;
    }
}


