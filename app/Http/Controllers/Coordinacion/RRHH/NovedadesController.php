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
        $query = "SELECT COUNT(FECHA) as c FROM PERSONAL.HISTORIAL WHERE IDAGENTE = $request->id";
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

        for($i = 0; $i<sizeof($request->avalatorios); $i++){
            $archivo = new Historial_Archivo;
            $archivo->idhistorial = $historial->idhistorial;
            $archivo->idarchivo = $request->avalatorios[$i];
            $archivo->save();
        }

        return $historial->idhistorial;
    }
}
