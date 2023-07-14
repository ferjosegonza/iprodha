<?php

namespace App\Http\Controllers\Coordinacion\RRHH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal\Agente;
use App\Models\Personal\Historial;
use App\Models\Personal\Historial_Archivo;
use DB;

class AgenteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function buscar(Request $request){
        $dni = $request->dni;
        $agente = Agente::where('nrodoc', '=', $dni)->first();
        return response()->json($agente);
    }

    public function historial(Request $request){
        $id = $request->id;
        $query = "select h.idhistorial, h.idagente, h.fecha, h.orden, h.detalle,
        h.observacion, ha.idarchivo, i.claves_archivo, i.path_archivo, i.nombre_archivo, i.nro_archivo,
        t.nombre_corto as tipo, s.dessubtipoarchivo as subtipo from PERSONAL.HISTORIAL h
        left join PERSONAL.HISTORIAL_ARCHIVO ha on 
        ha.IDHISTORIAL = h.IDHISTORIAL
        left join iprodha.dig_archivos i on idarchivo = i.id_archivo 
        left join iprodha.dig_tipoarchivo t on (i.id_tipoarchivo = t.id_tipoarchivo)
        and (i.id_tipocabecera = t.id_tipocabecera)
        left join iprodha.dig_subtipoarchivo s on (i.id_subtipoarchivo = s.id_subtipoarchivo) 
        and (s.id_tipoarchivo = t.id_tipoarchivo)
        and (i.id_tipocabecera = s.id_tipocabecera)
        where IDAGENTE = $id order by fecha";
        $historial = DB::select( DB::raw($query));
        //$historial = Historial::where('idagente', '=', $id)->leftJoin('PERSONAL.HISTORIAL_ARCHIVO', 'PERSONAL.HISTORIAL_ARCHIVO.idhistorial','PERSONAL.HISTORIAL.idhistorial')->orderBy('fecha')->get();
        return response()->json($historial);
    }
}
