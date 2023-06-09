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


class DigestoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(){
        $tipos = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
        $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->where('id_subtipoarchivo', '=', 3)->get();
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

        if($archivos == null){
            $get = Dig_digesto::where('id_archivon', '=', $request->id)->first();
            $archivos = Dig_digesto::where('id_archivo0', '=', $get->id_archivo0)
                    ->join('iprodha.dig_archivos', 'iprodha.dig_archivos.id_archivo', 'iprodha.dig_digesto.id_archivon')
                    ->get();  
        }

        $base = Dig_archivos::where('id_archivo', '=', $archivos[0]->id_archivo0)->first();
                
        return view('Digesto.modificaciones')
        ->with('base', $base)
        ->with('archivos', $archivos);        
    }

    public function buscador(){
        $tipos = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
        $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->where('id_subtipoarchivo', '=', 3)->get();
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

    public function areas(Request $request){
        $data = Dig_digesto_areas::where('id_archivo', '=', $request->id)
                ->join('PERSONAL.VW_DIG_AREAS', 'PERSONAL.VW_DIG_AREAS.idarea', '=', 'iprodha.dig_digesto_areas.id_area')
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
        $archivos = Dig_digesto::select('id_archivon', 'nro_archivo', 'observacion', 'nombre_archivo')
        ->join('iprodha.dig_archivos', 'iprodha.dig_archivos.id_archivo', '=', 'iprodha.dig_digesto.id_archivon')
        ->where('id_archivo0', '=', $request->id)->get();
        return response()->json($archivos);
    }
}
