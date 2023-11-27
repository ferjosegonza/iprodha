<?php

namespace App\Http\Controllers\Coordinacion\Digesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_archivos;
use App\Models\Iprodha\Dig_subtipoarchivo;
use App\Models\Iprodha\Dig_digesto;
use App\Models\Iprodha\Dig_digesto_areas;
use App\Models\Personal\Vw_dig_areas;
use DB;

class DigestoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(){
        $tipos = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
       // $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->get(); se necesita agregar un atributo de modificable
        $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->where('id_subtipoarchivo', '=', 3)->where('id_tipoarchivo', '=', 1)
        ->orWhere('id_subtipoarchivo', '=', 2)->where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
        $areas = Vw_dig_areas::orderBy('area')->get();
        return view('Digesto.index')

        ->with('tipos', $tipos)
        ->with('subtipos', $subtipos)
        ->with('areas', $areas);
    }

    public function modificaciones(Request $request){
        $archivos = Dig_digesto::where('id_archivo0', '=', $request->id)
                    ->join('iprodha.dig_archivos', 'iprodha.dig_archivos.id_archivo', 'iprodha.dig_digesto.id_archivon')
                    ->get();

        if(sizeof($archivos) == 0){
            $get = Dig_digesto::where('id_archivon', '=', $request->id)->first();
            if($get==null){
                return view('Digesto.modificaciones')
                ->with('base', null)
                ->with('archivos', null); 
            }
            else{
                $id=$get->id_archivo0;
                $archivos = Dig_digesto::where('id_archivo0', '=', $id)
                    ->join('iprodha.dig_archivos', 'iprodha.dig_archivos.id_archivo', 'iprodha.dig_digesto.id_archivon')
                    ->get();
            }
              
        }
        else{
           $id = $request->id;
        }

        $base = Dig_archivos::where('id_archivo', '=', $id)->first();
        $base->path_archivo = substr($base->path_archivo, 14);
        for($i = 0; $i<sizeof($archivos); $i++){
            $archivos[$i]->path_archivo = substr($archivos[$i]->path_archivo, 14);
        }

        return view('Digesto.modificaciones')
        ->with('base', $base)
        ->with('archivos', $archivos);        
    }

    public function buscador(){
        $tipos = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
        $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->where('id_subtipoarchivo', '=', 3)->where('id_tipoarchivo', '=', 1)
        ->orWhere('id_subtipoarchivo', '=', 2)->where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
        return view('Digesto.buscador')
            ->with('tipos', $tipos)
            ->with('subtipos', $subtipos);
    }

    public function buscarArchivo(Request $request){
        //return $request;
        $archivo = Dig_archivos::where('id_tipoarchivo', '=', $request->tipo)
                    ->where('id_subtipoarchivo', '=', $request->subtipo)
                    ->where('nro_archivo', '=', $request->doc)->first();
        //return $archivo;
        $archivo->path_archivo = substr($archivo->path_archivo, 14);
        return response()->json($archivo);
    }

    public function guardar(Request $request){
        $datosValidos = $request->validate([
            'id0' => 'required',
            'idn' => 'required',
            'obs' => 'required'
        ]);

        $digesto = new Dig_digesto;
        $res = $digesto->guardar($request->id0, $request->idn, $request->obs);
        return $res;
    }

    public function modificar(Request $request){
        $datosValidos = $request->validate([
            'id0' => 'required',
            'idn' => 'required',
            'obs' => 'required'
        ]);

        $digesto = Dig_digesto::where('id_archivo0', '=', $request->id0)
        ->where('id_archivon', '=', $request->idn)->first();
        $digesto->observacion = $request->obs;
        return $digesto->save();
    }

    public function areas(Request $request){
        $data = Dig_digesto_areas::where('id_archivo', '=', $request->id)
                ->join('IPRODHA.VW_DIG_AREAS', 'IPRODHA.VW_DIG_AREAS.idarea', '=', 'iprodha.dig_digesto_areas.id_area')
                ->get();
        //$areas_original = Dig_digesto_areas::where('id_archivo', '=', $request->id)->get();
        return response()->json($data);
    }

    public function remove_area(Request $request){
        $area = Dig_digesto_areas::where('id_archivo', '=', $request->id_archivo)
                ->where('id_area', '=', $request->id_area)
                ->first();
        $res = $area->delete();
        return $res;
    }

    public function add_area(Request $request){
        $area = new Dig_digesto_areas;
        $area->id_area = $request->id_area;
        $area->id_archivo = $request->id_archivo;
        $res = $area->save();
        return $res;
    }

    public function relacionados(Request $request){
        $archivos = Dig_digesto::select('id_archivo0','id_archivon', 'nro_archivo', 'observacion', 'nombre_archivo', 'path_archivo')
        ->join('iprodha.dig_archivos', 'iprodha.dig_archivos.id_archivo', '=', 'iprodha.dig_digesto.id_archivo0')
        ->where('id_archivon', '=', $request->id)->get();
        return response()->json($archivos);
    }

    public function check(Request $request){
        $check = Dig_digesto::where('id_archivo0','=',$request->id)->orWhere('id_archivon','=',$request->id)->get();
        if(sizeof($check) == 0){
            return response()->json(false);
        }
        else{
            return response()->json(true);
        }
    }

    public function historial(Request $request){
    $query = "SELECT id_archivo0, id_archivon, observacion, 
    a0.nro_archivo as nro0, an.nro_archivo as nron 
    FROM IPRODHA.DIG_DIGESTO D
    INNER JOIN IPRODHA.DIG_ARCHIVOS A0 
    ON A0.ID_ARCHIVO = D.ID_ARCHIVO0
    left JOIN IPRODHA.DIG_ARCHIVOS An 
    ON AN.ID_ARCHIVO = D.ID_ARCHIVON";
    $historial = DB::select( DB::raw($query));
    return view('Digesto.historial')
        ->with('historial', $historial);
    }
}
